<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Message;
use App\Events\MessageSent;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatsApiController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => ['required', 'numeric'],
            'receiver_id' => ['required', 'numeric'],
            'message' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            $message = $this->one_validation_message($validator);
            return ['status' => 0, 'message' => $message];
        } else {
            $message = Message::create($request->all());
            broadcast(
                new MessageSent($request->sender_id, $request->receiver_id)
            )->toOthers();
            if ($message) {
                return ['status' => 1, 'message' => 'Messge sended!'];
            } else {
                return ['status' => 0, 'message' => 'Error When message send'];
            }
        }
    }

    public function getUsers(Request $request)
    {
        $params = $request->query();
        if ($params['user']) {
            $users = Seller::where('email', 'like', '%' . $params['user'] . '%')
                ->select('id', 'email', 'firstname', 'lastname')
                ->limit(5)
                ->get();
            return $users;
        } else {
            return [];
        }
    }

    public function getMessagesByChannel(Request $request)
    {
        $params = $request->query();
        $user1 = $params['user1'];
        $user2 = $params['user2'];
        $messages = Message::where([
            ['sender_id', $user1],
            ['receiver_id', $user2],
        ])->update(['received_at' => Carbon::now()]);
        $messages = Message::where([
            ['sender_id', $user1],
            ['receiver_id', $user2],
        ])
            ->orWhere([['sender_id', $user2], ['receiver_id', $user1]])
            ->with([
                'sender' => function ($query) {
                    $query->select(['id', 'email', 'firstname', 'lastname']);
                },
                'receiver' => function ($query) {
                    $query->select(['id', 'email', 'firstname', 'lastname']);
                },
            ])
            ->orderBy('created_at')
            ->get();
        if ($messages) {
            return $messages;
        } else {
            return [];
        }
    }

    public function getReceivedMessagesCounts(Request $request)
    {
        $params = $request->query();
        $receiver = $params['receiver'];
        $count = Message::where('receiver_id', $receiver)->where('received_at', null)->count();
        return $count;
    }

    public function getMessagesByReceiver(Request $request)
    {
        $params = $request->query();
        $receiver = $params['receiver'];
        $messages = [];
        $userIds = [];
        $users = Message::where('receiver_id', $receiver)
            ->orWhere('sender_id', $receiver)
            ->select('sender_id', 'receiver_id')
            ->get();

        for ($i = 0; $i < count($users); $i++) {
            if (
                !in_array($users[$i]->sender_id, $userIds) &&
                $users[$i]->sender_id !== $receiver
            ) {
                array_push($userIds, $users[$i]->sender_id);
            }

            if (
                !in_array($users[$i]->receiver_id, $userIds) &&
                $users[$i]->receiver_id !== $receiver
            ) {
                array_push($userIds, $users[$i]->receiver_id);
            }
        }

        for ($i = 0; $i < count($userIds); $i++) {
            $message = Message::where([
                ['receiver_id', $receiver],
                ['sender_id', $userIds[$i]],
            ])
                ->orWhere([
                    ['sender_id', $receiver],
                    ['receiver_id', $userIds[$i]],
                ])
                ->with([
                    'sender' => function ($query) {
                        $query->select(['id', 'email', 'firstname', 'lastname']);
                    },
                    'receiver' => function ($query) {
                        $query->select(['id', 'email', 'firstname', 'lastname']);
                    },
                ])
                ->orderBy('created_at', 'desc')
                ->first();
            $unread_messages_count = Message::where('receiver_id', $receiver)->where('sender_id', $userIds[$i])->where('received_at', null)->count();
            if ($message) {
                array_push($messages, [
                    'message' => $message,
                    'unread_message_count' => $unread_messages_count
                ]);
            }
        }

        if ($messages) {
            usort($messages, function ($a, $b) {
                return $a['message']->created_at < $b['message']->created_at;
            });
            return $messages;
        } else {
            return [];
        }
    }

    public function one_validation_message($validator)
    {
        $validation_messages = $validator->getMessageBag()->toArray();
        $validation_messages1 = array_values($validation_messages);
        $new_validation_messages = [];
        for ($i = 0; $i < count($validation_messages1); $i++) {
            $inside_element = count($validation_messages1[$i]);
            for ($j = 0; $j < $inside_element; $j++) {
                array_push($new_validation_messages, $validation_messages1[$i]);
            }
        }
        return implode(' ', $new_validation_messages[0]);
    }
}
