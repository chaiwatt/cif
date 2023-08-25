<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserManagementSystemSettingUserInfAttachmentController extends Controller
{
    public function store(Request $request)
    {

        $file = $request->file('file');
        $userId = $request->userId;
        $name = $request->name;

        // Store the file in the 'attachments' disk
        $filePath = $file->store('', 'attachments'); 

        UserAttachment::create([
            'user_id' => $userId,
            'name' => $name,
            'file' => $filePath
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.attachment-table-render',[
            'user' => $user
            ])->render();
    }

    public function delete(Request $request)
    {
        $userId = $request->data['userId'];
        $attachmentId = $request->data['attachmentId'];
        $attachment = UserAttachment::find($attachmentId);
        
        $filePath = $attachment->file;
        Storage::disk('attachments')->delete($filePath);
        $attachment->delete();
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.attachment-table-render',[
            'user' => $user
            ])->render();
    }
}
