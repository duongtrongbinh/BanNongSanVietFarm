<?php

namespace App\Http\Controllers\Admin;
use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::query()->with(['permissions'])->get();
        return view('admin.permission.index',compact('roles'));
    }

    public function create(Role $role)
    {
        $rolePermissions = $role->permissions->pluck('id')->toArray(); // Lấy danh sách ID của các quyền đã liên kết
        $permissions = Permission::all(); // Lấy tất cả các quyền
        foreach ($permissions as $permission) {
            // Kiểm tra nếu quyền hiện tại có trong danh sách quyền đã liên kết
            $permission->checked = in_array($permission->id, $rolePermissions);
        }

        return view('admin.permission.create',compact(['role','permissions']));
    }

    public function store(PermissionRequest $request,Role $role)
    {
            $permissions = array_map('intval', $request->permission);
            $role->syncPermissions($permissions);
            return redirect()->route('permission.index')->with('created', 'Thêm mới thành công!');
    }
}
