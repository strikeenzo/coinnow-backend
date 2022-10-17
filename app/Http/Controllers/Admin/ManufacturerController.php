<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Traits\CustomFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ManufacturerController extends Controller
{
    use CustomFileTrait;

    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.manufacturer'));
    }

    public function index(Request $request)
    {
//        dd($request->all());
        $name = $request->get('name', '');
        $records = Manufacturer::select('id', 'name', 'image', 'sort_order', 'status')
            ->when($name != '', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            })->orderBy('created_at', 'DESC')->paginate($this->defaultPaginate);
        return view('admin.manufacturer.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.manufacturer.add', []);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png'],
        ]);

        $this->createDirectory($this->path);
        $data = new Manufacturer($request->only('name', 'sort_order', 'status'));
        $data->image = $this->saveCustomFileAndGetImageName(request()->file('image'), $this->path);
        $data->save();

        return redirect(route('manufacturer'))->with('success', 'Manufacturer Created Successfully');
    }

    public function edit($id)
    {

        return view('admin.manufacturer.edit', [
            'data' => Manufacturer::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => ['required'],
        ]);

        //Update Manufacturer
        $data = Manufacturer::findOrFail($id);
        if ($request->hasFile('image')) {
            $currentCategoryImage = $this->path . '/' . $data->image;
            if (File::exists($currentCategoryImage)) {
                unlink($currentCategoryImage);
            }
            $data->image = $this->saveCustomFileAndGetImageName(request()->file('image'), $this->path);
        }

        $data->fill($request->only('name', 'sort_order', 'status'))->save();
        return redirect(route('manufacturer'))->with('success', 'Manufacturer Updated Successfully');
    }

    public function delete($id)
    {
        if (!$data = Manufacturer::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $this->removeOldImage($data->image, $this->path);
        $data->delete();
        return redirect(route('manufacturer'))->with('success', 'Manufacturer  Deleted Successfully');
    }

}
