<?php

namespace App\Helpers;

use App\Models\LogActivity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($action, $model)
    {
        $user = Auth::user();
        $userName = $user->name; 
        $userLastname = $user->lastname; 
        
        $message = "ผู้ใช้งานทำการ {$action} บนรายการ " . get_class($model) . " รหัส: {$model->id}";
        $message .= " โดยผู้ใช้: {$userName} {$userLastname}";

        // Create a log record in the database
        LogActivity::create([
            'user_id' => $user->id,
            'action' => $action,
            'model' => get_class($model),
            'model_id' => $model->id,
        ]);
        
        // Log the message to the application log file
       Log::info($message);
    }
}
