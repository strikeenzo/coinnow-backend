<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class PermissionController extends Controller
{
    public function index(Request $request) {

//        $permissions = Permission::pluck('name');
//        dd($permissions);
//        $role = Role::find(1);
//        $role->syncPermissions($permissions);
//        dd(Auth::user()->assignRole($role));
//        dd($permission->fill(['name' => 'customer.add'])->save());
//        $role = Role::create([
//            'name' => 'Writer',
//        ]);
//        $role->givePermissionTo($permission);
//        $role->hasPermissionTo('customer.create');
//        dd($permission);
        $name = $request->get('name', '');

        $records = Permission::select('id','name','display_name')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%")->orWhere('display_name','like',"%$name%");
            })->paginate($this->defaultPaginate);

        return view('admin.permission.index',['records' => $records]);
    }

    public function add() {
        return view('admin.permission.add');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:190', 'unique:permissions'],
            'display_name' => ['required', 'string', 'max:190'],
        ]);

        DB::table('permissions')->insert([
            'name' => $request->name,
            'display_name' =>$request->display_name,
            'guard_name' => 'web'
        ]);

        return redirect(route('permission'))->with('success','Permission Created Successfully');
    }


}
