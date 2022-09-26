<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clan;

class ClanController extends Controller
{
    public function index() {
        $records = Clan::with(['product' => function($query) {
            $query->with('productDescription');
        }, 'members', 'owner'])->paginate($this->defaultPaginate);
        return view('admin.clan.index', ['records' => $records]);
    }

    public function add($id) {
        return view('admin.clan.add', ['id' => $id]);
    }

    public function store(Request $request) {
        $this->validateData($request);
        $new_clan = Clan::create([
            'product_id' => $request->product_id,
            'title' => $request->title,
            'price' => $request->price,
            'fee' => $request->fee,
            'discount' => $request->discount
        ]);

        return redirect(route('clan'))->with('success', 'Clan Created Successfully');
    }

    public function edit(Request $request, $id) {
        $clan = Clan::where('id', $id)->first();
        return view('admin.clan.edit', ['clan' => $clan]);
    }

    public function update(Request $request, $id) {
        $this->validateData($request);
        $clan = Clan::where('id', $id)->first();
        $clan->product_id = $request->product_id;
        $clan->title = $request->title;
        $clan->price = $request->price;
        $clan->fee = $request->fee;
        $clan->discount = $request->discount;
        $clan->save();
        return redirect(route('clan'))->with('success', 'Clan Updated Successfully');
    }

    public function delete($id) {
        $clan = Clan::where('id', $id)->first();
        if ($clan->owner_id) {
            return redirect(route('clan'))->with('error', 'Owner Already Exist');
        } else {
            $clan->delete();
            return redirect(route('clan'))->with('success', 'Clan Deleted Successfully');
        }
    }

    private function validateData($request) {
        $newValidations = [
            'title' => ['required'],
            'price' => ['required', 'gt:0'],
            'fee' => ['required', 'gt:0'],
            'discount' => ['required', 'gt:0'],
            'product_id' => ['required']
        ];
        $this->validate($request, $newValidations);
    }
}
