<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;

class GuideController extends Controller
{
    public function index() {
        $records = Guide::paginate($this->defaultPaginate);
        return view('admin.guide.index', ['records' => $records]);
    }

    public function add() {
        return view('admin.guide.add');
    }

    public function store(Request $request) {
        $this->validateData($request);
        Guide::create($request->all());
        return redirect(route('guide'))->with('success', 'Guide Created Successfully');
    }

    public function update(Request $request, $id) {
        $this->validateData($request);
        $guide = Guide::where('id', $id)->first();
        $guide->title = $request->title;
        $guide->content = $request->content;
        $guide->type = $request->type;
        $guide->save();
        return redirect(route('guide'))->with('success', 'Guide Updated Successfully');
    }

    public function delete($id) {
        $guide = Guide::where('id', $id)->first();
        $guide->delete();
        return redirect(route('guide'))->with('success', 'Guide Deleted Successfully');
    }

    public function updateStatus(Request $request, $id) {
        $guide = Guide::where('id', $id)->first();
        if ($request->status === 'on') $guide->status = true;
        else $guide->status = false;
        $guide->save();
        return redirect(route('guide'))->with('success', 'Status Updated Successfully');
    }

    public function edit($id) {
        $guide = Guide::where('id', $id)->first();
        return view('admin.guide.edit', ['guide' => $guide]);
    }

    private function validateData ($request) {
        $guideValidations = [
            'title' => ['required'],
            'content' => ['required'],
            'type' => ['required'],
            'sort_order' => ['required', 'numeric']
        ];

        $this->validate($request, $guideValidations);
    }
}
