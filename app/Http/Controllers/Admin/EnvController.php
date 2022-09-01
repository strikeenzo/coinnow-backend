<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalVariable;
use Illuminate\Http\Request;

class EnvController extends Controller
{
    public function index() {
        $env = EnvironmentalVariable::first();
        if (!$env) {
            $env = EnvironmentalVariable::create([
                'min_time' => 10800,
                'max_time' => 21600
            ]);
        }
        return view('admin.env_setting.index', ['min_time' => $env->min_time, 'max_time' => $env->max_time]);
    }

    public function update(Request $request) {
        $env = EnvironmentalVariable::first();
        $env->min_time = $request->min_time;
        $env->max_time = $request->max_time;
        $env->save();
        return redirect(route('env'))->with('success', 'Environmental Variables Updated Successfully.');
    }
}
