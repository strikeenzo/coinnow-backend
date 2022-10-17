<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerComment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerCommentController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $records = CustomerComment::whereHas('customer', function ($query) use ($keyword) {
            if ($keyword) {
                $query->where('email', $keyword);
            }
        })
            ->with('customer')->orderBy('created_at', 'desc')->paginate($this->defaultPaginate);
        return view('admin.comment.index', ['records' => $records, 'id' => 'all']);
    }

    public function detail($id)
    {
        $customers = CustomerComment::select('user_id')->groupBy('user_id')->with('customer')->get();
        $records = CustomerComment::where('user_id', $id)->with('customer')->orderBy('user_id')->orderBy('created_at')->paginate($this->defaultPaginate);
        return view('admin.comment.index', ['customers' => $customers, 'records' => $records, 'id' => $id]);
    }

    public function edit($id)
    {
        $comment = CustomerComment::where('id', $id)->first();
        return view('admin.comment.reply', ['comment' => $comment]);
    }

    public function reply(Request $request, $id)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);
        $comment = CustomerComment::where('id', $id)->first();
        $comment->reply = $request->reply;
        $comment->reply_at = Carbon::now();
        $comment->save();
        return redirect(route('comments'))->with('success', 'Comment Replyed Successfully');
    }
}
