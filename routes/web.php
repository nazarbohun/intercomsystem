<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntercomDeviceController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MainIntercomDeviceController;
use App\Http\Controllers\MessengerUserController;
use App\Http\Controllers\PermissionRequestController;
use App\Http\Controllers\TelegramController;
use App\Models\MessengerUsers;
use App\Models\PermissionRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::group(
    [
        'middleware' => [
            'admin',
        ],
    ],
    function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/permission_requests', [PermissionRequestController::class, 'index'])->name('permission_requests');
        Route::post('/permission_requests/{permissionRequest}/access', [PermissionRequestController::class, 'access'])->name('permission_requests.access');
        Route::get('/intercom_devices', [IntercomDeviceController::class, 'index'])->name('intercom_devices');
        Route::get('/messenger_users', [MessengerUserController::class, 'index'])->name('messenger_users');
    }
);
Route::prefix('bot')->group(function () {
    Route::get('/set_web_hook', [TelegramController::class,'set_web_hook']);
    Route::post('/5861606311:AAEATkMEBkigrfB3dNR6cFva39haDNkrV1I/webhook', [TelegramController::class,'webhook']);
});
Route::post('/verify', [MainIntercomDeviceController::class,'verify']);
Route::post('/video', [MainIntercomDeviceController::class,'video']);
Route::get('/test', function (){
    $keyboard = new Keyboard(['one_time_keyboard' => true]);
    $keyboard->inline();
    $keyboard->row([Keyboard::inlineButton(['text'=> "Надати доступ до вашого приміщення",'callback_data'=>json_encode(['allow_access' => true])])]);
    $keyboard->row([Keyboard::inlineButton(['text'=> "Відмовити у доступі до вашого приміщення",'callback_data'=>json_encode(['allow_access' => false])])]);
    Telegram::sendAnimation([
        'chat_id' => '799387867',
        'animation' => InputFile::create('https://nazarbohun.xyz/knocking-on-the-door-charlie-hudson.gif')
    ]);
    Telegram::sendMessage([
        'chat_id' => '799387867',
        'text' => "У вас запитують доступ до приміщення. Вирішіть чи надавати чи відмовляти у доступі?\n Зробіть свій вибір натиснувши одну з кнопок",
        'reply_markup' => $keyboard
    ]);
});

