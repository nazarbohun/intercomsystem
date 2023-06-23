<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\PermissionRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class PermissionRequestController extends Controller
{
    public function index(): View
    {
        $permissionRequests = PermissionRequest::where('permission_access',false)->get();
        return view('permissionRequest',compact('permissionRequests'));
    }
    public function access(PermissionRequest $permissionRequest): RedirectResponse
    {
        $permissionRequest->update(['permission_access' => true]);
        Telegram::sendMessage([
            'chat_id' => $permissionRequest->messenger_user->telegram_id,
            'text' => 'Вам надано можливість контролю доступу до приміщення',
        ]);
        Log::create(['descriptions' => "Запит на контроль доступу надано [user.id = " . Auth::id() . "][messenger_users.id = " . $permissionRequest->messenger_user->telegram_id . "][messenger_users.telegram_id = " . $permissionRequest->messenger_user->telegram_id . "]"]);
        return redirect()->route('permission_requests')
            ->with('success', 'Контроль доступу надано!');
    }
}
