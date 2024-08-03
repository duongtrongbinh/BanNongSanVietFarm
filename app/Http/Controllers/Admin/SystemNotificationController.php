<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use Illuminate\Support\Facades\Auth;

class SystemNotificationController extends Controller
{
    public function destroy(NotificationRequest $request)
    {
        $notifications = Auth::user()->notifications()->whereIn('id', $request->input('notifications'));
        if($request->has('read')){
            $notifications->update([
                'read_at' => now()
            ]);
        }else{
            $notifications->delete();
        }
        return redirect()->back();
    }
}
