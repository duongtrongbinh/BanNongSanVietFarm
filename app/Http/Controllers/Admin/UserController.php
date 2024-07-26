<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinces;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] = User::query()->orderByDesc('id')->paginate(10);
        return view('admin.user.index', $data);
    }
    public function create()
    {
        $provinces = Provinces::all();
        return view('admin.user.create', compact('provinces'));
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->except('avatar');
        $data['avatar'] = $request->input('avatar');
        $data['password'] = Hash::make($request->input('password'));
        $user = User::create($data);
        return redirect()->route('user.index')->with('created', 'Thêm khách hàng thành công!');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $provinces = Provinces::all();
        return view('admin.user.edit', compact('user','provinces'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->except('avatar');
        if ($request->input('avatar')) {
            if ($user->avatar) {
                $oldImagePath = str_replace(url('storage'), 'public', $user->avatar);
                Storage::delete($oldImagePath);
            }
            $data['avatar'] = $request->input('avatar');
        }
        $user->status = $request->input('status', 0);
        $user->active = $request->input('active', 0);
        $user->update($data);
        return redirect()->route('user.index')->with('update', 'Bạn đã cập nhật thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar) {
            $oldImagePath = str_replace(url('storage'), 'public', $user->avatar);
            Storage::delete($oldImagePath);
        }
        $user->delete();
        return response()->json(true);
    }
}
