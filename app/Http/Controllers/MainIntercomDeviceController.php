<?php

namespace App\Http\Controllers;

use App\Models\IntercomDevice;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class MainIntercomDeviceController extends Controller
{
    public function verify(Request $request)
    {
        $mac_address = $request->get('device_mac_address');
        $number_of_float = $request->get('number_of_float');
        $ip_address = $request->get('ip_address');
        $intercom_device = IntercomDevice::where('mac_address',$mac_address)->get();
        if ($intercom_device->isEmpty())
        {
            return response()->json(['success' => false]);
        }
        if ($intercom_device->number_premises < $number_of_float)
        {
            return response()->json(['success' => false]);
        }
        sleep(4);
        $intercom_device->update(["ip_address" => $ip_address]);
        $keyboard = new Keyboard(['one_time_keyboard' => true]);
        $keyboard->inline();
        $keyboard->row([Keyboard::inlineButton(['text'=> "Надати доступ до вашого приміщення",'callback_data'=>json_encode(['allow_access' => true])])]);
        $keyboard->row([Keyboard::inlineButton(['text'=> "Відмовити у доступі до вашого приміщення",'callback_data'=>json_encode(['allow_access' => false])])]);
        if (Storage::exists("public/videos/temp_video.gif")) {
            Telegram::sendAnimation([
                'chat_id' => $intercom_device->messenger_user->telegram_id,
                'animation' => InputFile::create(Storage::get('public/videos/temp_video.gif'))
            ]);
        }
        Telegram::sendMessage([
            'chat_id' => $intercom_device->messenger_user->telegram_id,
            'text' => "У вас запитують доступ до приміщення. Вирішіть чи надавати чи відмовляти у доступі?\n Зробіть свій вибір натиснувши одну з кнопок",
            'reply_markup' => $keyboard
        ]);
        Log::create(['descriptions' => "Запит на отримання доступу до приміщення [intercom_devices.id = " . $intercom_device->id . "][intercom_devices.mac_address = " . $intercom_device->mac_address . "][messenger_users.id = 4][messenger_users.telegram_id = " . $intercom_device->messenger_user->telegram_id . "]"]);


        return response()->json(['success' => true]);
    }

    public function video(Request $request)
    {
        // Check if the request has 'video' field
        if ($request->has('video')) {
            // Get the video from the request
            $video = $request->file('video');


            if (Storage::exists('public/videos/temp_video.gif')) {

                Storage::delete('public/videos/temp_video.gif');
            }
            $path = $video->storeAs('public/videos', 'temp_video');

            // Respond with the stored video path
            return response()->json([
                'status' => 'success',
                'path' => $path,
            ], 200);
        } else {
            // If no 'video' field in the request, respond with an error
            return response()->json([
                'status' => 'error',
                'message' => 'No video in the request',
            ], 400);
        }
    }
    }
}
