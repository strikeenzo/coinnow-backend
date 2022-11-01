<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalShowImage;

class DigitalShowImageController extends Controller
{
    public function index()
    {
        $records = DigitalShowImage::orderBy('created_at', 'DESC')->with(['owner' => function ($query) {
            $query->select('id', 'firstname', 'lastname');
        }])->withCount('comments')->withCount(['sellers' => function ($query) {
            $query->where('heart', true);
        }])->paginate($this->defaultPaginate);
        return view('admin.digital.index', ['records' => $records]);
    }
}
