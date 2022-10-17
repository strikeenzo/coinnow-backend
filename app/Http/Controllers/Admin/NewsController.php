<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $records = News::orderBy('created_at', 'DESC')->paginate($this->defaultPaginate);
        return view('admin.news.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.news.add');
    }

    public function store(Request $request)
    {
        $content = $request->content;
        $this->validateData($request);
        $news = News::create([
            'content' => $request->content,
            'type' => 'default',
        ]);
        broadcast(
            new MessageSent('news-sent', $news)
        )->toOthers();
        return redirect(route('news'))->with('success', 'News Created Successfully');
    }

    public function edit(Request $request, $id)
    {
        $news = News::where('id', $id)->first();
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, $id)
    {
        $this->validateData($request);
        $news = News::where('id', $id)->first();
        $news->content = $request->content;
        $news->save();
        return redirect(route('news'))->with('success', 'News Updated Successfully');
    }

    public function delete($id)
    {
        $news = News::where('id', $id)->first();
        $news->delete();
        return redirect(route('news'))->with('success', 'News Deleted Successfully');
    }

    protected function validateData($request)
    {
        $newsValidations = [
            'content' => ['required'],
        ];
        $this->validate($request, $newsValidations);
    }
}
