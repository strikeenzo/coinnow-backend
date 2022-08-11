<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = Role::select('id','name')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->paginate($this->defaultPaginate);
        return view('admin.role.index',['records' => $records]);
    }

    public function add() {
        return view('admin.role.add');
    }

    protected function validateData ($request) {

        $uniqueRuleCode = 'unique:roles';

        if(Route::currentRouteName() == 'role.update') {
            $uniqueRuleCode = 'unique:roles,name,'.$request->id;
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', $uniqueRuleCode]
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);

        $permissions = $this->getPermissionArray($request->get('permissions', []));

        $role = new Role($request->only('name'));
        $role->save();

        $role->givePermissionTo($permissions);

        return redirect(route('role'))->with('success','Role Created Successfully');
    }

    protected function getPermissionArray($requestedPermissions) :array {

        $permissions = [];

        foreach ($requestedPermissions as $key => $value) {
            $name = $value;
            $singlePermissionArray = explode('.',$value);
            if(count($singlePermissionArray) ) {
                $name = setPermissionValue($singlePermissionArray[0],$singlePermissionArray[1]);
            }
            $permissions[] = $name;
        }

        return $permissions;
    }

    public function edit($id) {

        $role = Role::findOrFail($id);
        $permissions = $role->permissions->pluck('name')->toArray();

        return view('admin.role.edit',[
            'data' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);

        $data = Role::findOrFail($id);
        $permissions = $this->getPermissionArray($request->get('permissions', []));

        $data->syncPermissions($permissions);
        $data->fill($request->only('name'))->save();

        return redirect(route('role'))->with('success','Role Updated Successfully');
    }

    public function delete($id) {
        if(! $data = OrderStatus::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('role'))->with('success', 'Order Status  Deleted Successfully');
    }
}
