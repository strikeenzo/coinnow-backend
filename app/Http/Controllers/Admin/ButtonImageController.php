<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ButtonImage;
use App\Traits\CustomFileTrait;

class ButtonImageController extends Controller
{
    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.button'));
    }
    public function index() {
        $records = ButtonImage::get();
        return view('admin.button.index', ['records' => $records]);
    }

    public function add() {
        return view('admin.button.add');
    }

    public function store(Request $request) {
        $this->validateData($request);
        $button = ButtonImage::where('type', $request->type)->first();
        $this->createDirectory($this->path);
        $image = $this->saveCustomFileAndGetImageName(request()->file('main_image'),$this->path);
        $msg = '';
        if ($button) {
            $button->type = $request->type;
            $button->image = $image;
            $button->save();
            $msg = 'Button Image Updated Successfully';

        } else {
            $button = ButtonImage::create([
                'type' => $request->type,
                'image' => $image
            ]);
            $msg = 'Button Image Created Successfully';
        }
        return redirect(route('button'))->with('success', $msg);
    }

    private function validateData($request) {
        $newValidations = [
            'type' => ['required'],
            'main_image' => ['required']
        ];
        $this->validate($request, $newValidations);
    }
}
