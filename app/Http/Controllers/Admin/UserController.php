<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
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
    const token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
    const url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';

    public function index()
    {
        $data['user'] = User::query()->orderByDesc('id')->paginate(10);
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'token' => self::token,
        ];
        $response = Http::withHeaders($headers)->get(self::url);
        if ($response->successful()) {
            $provinces = $response->json();
        } else {
            $provinces = null;
            dd('error system');
        }
        return view('admin.user.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $headers = [
            'Content-Type' => 'application/json',
            'token' => self::token,
        ];
        $response = Http::withHeaders($headers)->get(self::url);
        if ($response->successful()) {
            $provinces = $response->json();
        } else {
            $provinces = null;
            dd('error system');
        }
        return view('admin.user.edit', compact('user','provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
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
