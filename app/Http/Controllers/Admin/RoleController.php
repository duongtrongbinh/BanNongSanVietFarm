<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class RoleController extends Controller
{

    public function create(User $user)
    {
        $roles = Role::query()->get();
        $userHasRole = $user->roles->pluck('id')->toArray();
        foreach ($roles as $item) {
            $item->checked = in_array($item->id, $userHasRole);
        }
        return view('admin.user.role',compact('roles','user'));
    }

    public function store(RoleRequest $request,User $user)
    {
        $roleIds = array_map('intval', $request->roles);
        $user->syncRoles($roleIds);
        return redirect()->route('user.index')->with('created', 'Thêm mới thành công!');
    }
}
