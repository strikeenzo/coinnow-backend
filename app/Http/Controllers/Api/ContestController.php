<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestStarRelation;
use App\Models\Notification;
use App\Models\Seller;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $getUser;
    private $investment;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->getUser = Auth::guard('seller')->user();
            return $next($request);
        });
        $this->investment = 2000;
    }

    public function endContest()
    {
        $now = Carbon::now();
        $contests = Contest::where('status', 1)->where('ended_at', '<', $now)->get();
        for ($i = 0; $i < count($contests); $i++) {
            $contests[$i]->status = 2;
            $contests[$i]->save();
            $relations = ContestStarRelation::where('contest_id', $contests[$i]->id)->with('digital')->get()->sortBy('digital.view_counts');
            $j = 0;
            foreach ($relations as $relation) {
                if ($j < 4) {
                    $notification_data = array(
                        'type' => 'investor_lost',
                        'contest_id' => $relation->contest_id,
                        'seller_id' => $relation->investor_id,
                        'receiver_id' => $relation->digital_id,
                        'price' => $this->investment,
                        'balance' => $relation->investor->balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();
                    $notification_data = array(
                        'type' => 'star_lost',
                        'contest_id' => $relation->contest_id,
                        'seller_id' => $relation->digital_id,
                        'receiver_id' => $relation->investor_id,
                        'price' => $this->investment,
                        'balance' => $relation->digital->owner->balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();
                } else {
                    $relation->digital->winning_counts = $relation->digital->winning_counts ? $relation->digital->winning_counts : 0 + 1;
                    $relation->digital->save();
                    $notification_data = array(
                        'type' => 'investor_win',
                        'contest_id' => $relation->contest_id,
                        'seller_id' => $relation->investor_id,
                        'receiver_id' => $relation->digital_id,
                        'price' => $this->investment * (1.9 - $relation->digital->owner->star_profit / 100),
                        'balance' => $relation->investor->balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();
                    $notification_data = array(
                        'type' => 'star_win',
                        'contest_id' => $relation->contest_id,
                        'seller_id' => $relation->star_id,
                        'receiver_id' => $relation->investor_id,
                        'price' => $this->investment * $relation->digital->owner->star_profit / 100,
                        'balance' => $relation->digital->owner->balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();
                    $relation->investor->balance += $this->investment * (1.9 - $relation->digital->owner->star_profit / 100);
                    $relation->investor->save();
                    $relation->digital->owner->balance += $this->investment * $relation->digital->owner->star_profit / 100;
                    $relation->digital->owner->save();

                }
                $j++;
            }
        }
        return ['success' => 'Contests ended'];
    }

    public function index()
    {
        // started contests list
        $contests = Contest::orderBy('created_at', 'desc')->with(['digitals' => function ($query) {
            $query->withCount('sellers as views_counts');
        }])->paginate($this->defaultPaginate);
        return ['status' => 1, 'contests' => $contests];
    }

    public function invest(Request $request)
    {
        $digital_id = $request->digital_id;
        $investor_id = $this->getUser->id;
        if ($this->getUser->balance >= $this->investment) {
            $contest = Contest::where('status', 0)->first();
            $now = Carbon::now();
            $ended = Carbon::now()->addDays(1);
            if ($contest) {
                if (count($contest->digitals) < 8) {
                    if (count($contest->digitals) == 7) {
                        $contest->status = 1;
                        $contest->started_at = $now;
                        $contest->ended_at = $ended;
                    } else {
                        $contest->status = 0;
                    }
                    $contest->save();
                }
            } else {
                $contest = Contest::create([
                    'status' => 0,
                ]);
            }
            ContestStarRelation::create([
                'digital_id' => $digital_id,
                'investor_id' => $investor_id,
                'investment' => $this->investment,
                'contest_id' => $contest->id,
            ]);
            $notification_data = array(
                'type' => 'invest',
                'contest_id' => $contest->id,
                'seller_id' => $this->getUser->id,
                'receiver_id' => $request->digital_id,
                'price' => $this->investment,
                'balance' => $this->getUser->balance,
                'seen' => 0,
            );
            $new_notification = new Notification($notification_data);
            $new_notification->save();
            $this->getUser->balance -= $this->investment;
            $this->getUser->save();
            return ['status' => 1, 'message' => 'Successfully invested'];
        } else {
            return [
                'status' => 0,
                'message' => 'No enough balance',
            ];
        }
    }

    public function getInvestedImages()
    {
        $images = ContestStarRelation::where('investor_id', $this->getUser->id)->whereHas('digital')->with('digital')->with('contest')->whereHas('contest', function ($query) {
            $query->whereIn('status', [0, 1]);
        })->get();
        return $images;
    }

    public function getStars(Request $request)
    {
        $params = $request->query();
        $sorted = Seller::get()
            ->sortByDesc('view_counts') //appended attribute
            ->pluck('id')
            ->toArray();
        $orderedIds = implode(',', $sorted);
        $query = Seller::orderByRaw(DB::raw("FIELD(id, " . $orderedIds . " )"));
        if (isset($params['key']) && $params['key']) {
            $query = $query->select('id', 'firstname', 'lastname')->where('firstname', 'like', '%' . $params['key'] . '%');
        } else {
            $query = $query->select('id', 'firstname', 'lastname');
        }
        $stars = $query->orderBy('created_at')->with(['contests' => function ($query) {
            $query->whereIn('status', [0, 1]);
        }])->paginate($this->defaultPaginate);
        return ['status' => 1, 'stars' => $stars];
    }
}
