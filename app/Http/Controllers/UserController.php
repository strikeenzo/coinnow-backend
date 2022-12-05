<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $name = $request->get('name', '');

        $records = User::select('id', 'name', 'email', 'status')
            ->when($name != '', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%")->orWhere('email', 'like', "%$name%");
            })->paginate($this->defaultPaginate);
        return view('admin.users.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.users.add', ['roles' => Role::pluck('name')]);
    }

    public function edit($id)
    {

        $data = User::with('roles')->findOrFail($id);
        $role = $data->getRoleNames()->first();
        return view('admin.users.edit', [
            'roles' => Role::pluck('name'),
            'data' => $data,
            'role' => $role,

        ]);
    }

    public function store(Request $request)
    {

        $this->validateData($request);
        $data = new User($request->only('name', 'email', 'mobile', 'status'));
        $data->password = bcrypt($request->password);
        $data->save();
        $data->assignRole($request->role);

        return redirect(route('user'))->with('success', 'User Created Successfully');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->hasRole('Admin')) {
            $this->validateData($request);
        } else {
            $this->validateDataForCustomers($request);
        }

        $data = User::findOrFail($id);
        //dd($request->role);
        if ($request->role) {
            $data->assignRole($request->role);
            $data->syncRoles($request->role);
        }

        $data->fill($request->only('name', 'email', 'mobile', 'status'))->save();

        if (Auth::user()->hasRole('Admin')) {
            return redirect(route('user'))->with('success', 'User Updated Successfully');
        } else {
            return redirect(route('dashboard'))->with('success', 'User Updated Successfully');
        }

    }

    protected function validateData($request)
    {

        $passwordValidations = [];
        if (Route::currentRouteName() == 'user.store') {
            $passwordValidations = ['password' => ['required', 'min:6'],
                'confirmed' => ['required', 'same:password'],
            ];
        }

        $validations = [
            'name' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email'],
            'mobile' => ['required'],
            'status' => ['required'],
            'role' => ['required'],
        ];

        $validationArray = array_merge($passwordValidations, $validations);

        $this->validate($request, $validationArray);
    }

    protected function validateDataForCustomers($request)
    {

        $passwordValidations = [];
        if (Route::currentRouteName() == 'user.store') {
            $passwordValidations = ['password' => ['required', 'min:6'],
                'confirmed' => ['required', 'same:password'],
            ];
        }

        $validations = [
            'name' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email'],
            'mobile' => ['required'],
            'status' => ['required'],
        ];

        $validationArray = array_merge($passwordValidations, $validations);

        $this->validate($request, $validationArray);
    }

    public function delete($id)
    {
        $data = User::with('roles')->findOrFail($id);
        $data->removeRole($data->getRoleNames()->first());
        $data->delete();

        return redirect(route('user'))->with('success', 'User Updated Successfully');

    }
}
