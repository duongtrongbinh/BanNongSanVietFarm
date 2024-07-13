<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    public function index()
    {
        $data['banners'] = Banner::query()->orderByDesc('id')->paginate(10);
        return view('admin.banner.index', $data);
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('image');
        $data['image'] = $request->input('image');
        $banner = Banner::create($data);
        return redirect()->route('banners.index')->with('thongbao', 'bạn đã thêm thành công !');
    }
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit',compact('banner'));
    }
    public function update(Request $request,$id)
    {
        $banner = Banner::findOrFail($id);
        $data = $request->except('image');
        if ($request->input('image')) {
            if ($banner->image) {
                $oldImagePath = str_replace(url('storage'), 'public', $banner->image);
                Storage::delete($oldImagePath);
            }
            $data['image'] = $request->input('image');
        }
        $banner->is_home = $request->input('is_home', 0);
        $banner->is_active = $request->input('is_active', 0);
        $banner->update($data);
        return redirect()->route('banners.index')->with('thongbao', 'Bạn đã cập nhật thành công!');
    }
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image) {
            $oldImagePath = str_replace(url('storage'), 'public', $banner->image);
            Storage::delete($oldImagePath);
        }
        $banner->delete();
        return response()->json(true);
    }
}
