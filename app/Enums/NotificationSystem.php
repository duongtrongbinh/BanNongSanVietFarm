<?php

namespace App\Enums;


enum  NotificationSystem: string
{
    public static function adminNotificationNew()
    {
        $admin = Roles::admins()->first();
        return $admin->notifications->first();
    }
}
