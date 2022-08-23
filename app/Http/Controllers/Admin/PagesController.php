<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Models\CategoryDescription;
use App\Traits\CustomFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{

    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.category'));
    }

    public function index(Request $request) {

        $name = $request->get('name', '');
        $records = Page::select('*')
            ->when($name != '', function($q) use($name) {
                    $q->where('title','like',"%$name%");
        })->whereDeletedAt(null)->paginate($this->defaultPaginate);
        return view('admin.pages.index',['records' => $records]);
    }

    public function add() {
        return view('admin.pages.add');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'heading' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ]);

        $category = new Page($request->only('title','heading','description'));
        $category->save();

        return redirect(route('pages'))->with('success','Page Created Successfully');
    }

    public function edit($id) {

        return view('admin.pages.edit',[
            'data' => Page::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

      $this->validate($request, [
          'title' => ['required', 'string', 'max:255'],
          'heading' => ['required', 'string', 'max:255'],
          'description' => ['required'],
      ]);

        //Update Category
        $page = Page::findOrFail($id);

        $page->fill($request->only('title','heading','description'))->save();

        return redirect(route('pages'))->with('success','Page Updated Successfully');
    }

}
