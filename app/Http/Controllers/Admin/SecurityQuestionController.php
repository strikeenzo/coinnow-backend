<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use Illuminate\Http\Request;

class SecurityQuestionController extends Controller
{
    //
    public function index()
    {
        $records = SecurityQuestion::get();
        return view('admin.question.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.question.add');
    }

    public function store(Request $request)
    {
        $this->validateData($request);

        SecurityQuestion::create([
            'question' => $request->question,
        ]);
        return redirect(route('question'))->with('success', 'Question Created Successfully');
    }

    public function edit(Request $request)
    {
        $question = SecurityQuestion::where('id', $request->id)->first();
        return view('admin.question.edit', ['question' => $question]);
    }

    public function update(Request $request, $id)
    {
        $question = SecurityQuestion::where('id', $id)->first();
        $question->question = $request->question;
        $question->save();
        return redirect(route('question'))->with('success', 'Question Updated Successfully');
    }

    public function delete(Request $request, $id)
    {
        $question = SecurityQuestion::where('id', $id)->first();
        $question->delete();
        return redirect(route('question'))->with('success', 'Question Deleted Successfully');
    }

    private function validateData($request)
    {
        $newValidations = [
            'question' => ['required'],
        ];
        $this->validate($request, $newValidations);
    }
}
