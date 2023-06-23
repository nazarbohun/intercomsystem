<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\MessengerUsers;
use App\Models\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function set_web_hook()
    {
        echo Telegram::setWebhook(['url' => "https://nazarbohun.xyz/bot/5861606311:AAEATkMEBkigrfB3dNR6cFva39haDNkrV1I/webhook"]);
    }

    public function webhook()
    {
        $update = Telegram::commandsHandler(true);
        if ($update->objectType() === 'callback_query')
        {
            $data = json_decode($update['callback_query']['data']);
            if (!empty($data->device))
            {
                Telegram::answerCallbackQuery([
                    'callback_query_id' => $update['callback_query']['id'],
                    'text' => 'Ви успішно вибрали адресу приміщення'
                ]);
                $tel_user = MessengerUsers::where('telegram_id',$update['callback_query']['from']['id'])->first();
                if (empty($tel_user))
                {
                    MessengerUsers::create([
                        'telegram_id' => $update['callback_query']['from']['id'],
                        'intercom_device_id' => $data->device,
                        'name' => empty($update['callback_query']['from']['first_name']) ? null : $update['callback_query']['from']['first_name'],
                        'user_name' => empty($update['callback_query']['from']['username']) ? null : $update['callback_query']['from']['username'],
                    ]);
                    Log::create(['descriptions' => "Створено нового Telegram користувача [messenger_users.telegram_id = " . $update['callback_query']['from']['id'] . "]"]);
                }

                $keyboard = new Keyboard(['resize_keyboard' => true, 'one_time_keyboard' => true]);
                $keyboard->inline();
                $device = \App\Models\IntercomDevice::find($data->device);
                $i = 1;
                $buttons = collect();
                while ($i <= $device->number_premises)
                {
                    $buttons->push(Keyboard::inlineButton(['text'=> $i,'callback_data'=>json_encode(['number_premise' => $i])]));
                    $i++;
                }
                $buttons = $buttons->chunk(8);
                foreach ($buttons as $button)
                {
                    $keyboard->row($button->values()->toArray());
                }

                Telegram::sendMessage([
                    'chat_id' => $update['callback_query']['from']['id'],
                    'text' => 'Зараз вам потрібно обрати номер приміщення до якого ви хочете отримати доступ',
                    'reply_markup' => $keyboard
                ]);
            }
            if (!empty($data->number_premise))
            {
                Telegram::answerCallbackQuery([
                    'callback_query_id' => $update['callback_query']['id'],
                    'text' => "Ви успішно подали заявку на контроль доступу до приміщення",
                    'show_alert' => true
                ]);
                PermissionRequest::create([
                    'messenger_user_id' => MessengerUsers::where('telegram_id',$update['callback_query']['from']['id'])->first()->id,
                    'number_premise' => $data->number_premise,
                    'permission_access' => false
                ]);
                Log::create(['descriptions' => "Створено запит на контроль доступу [messenger_users.id = " . MessengerUsers::where('telegram_id',$update['callback_query']['from']['id'])->first()->id . "][messenger_users.telegram_id =  " . $update['callback_query']['from']['id'] . "]"]);
                Telegram::sendMessage([
                    'chat_id' => $update['callback_query']['from']['id'],
                    'text' => "Ваша заявка на контроль доступу до приміщення подана. \nОчікуйте на відповідь адміністратора системи.",
                ]);
            }
            if (!empty($data->allow_access))
            {
                $telegram_user =  MessengerUsers::where('telegram_id',$update['callback_query']['from']['id'])->first();
                $ip_address = $telegram_user->intercom_device->ip_address;
                if ($data->allow_access === true)
                {
                    Telegram::answerCallbackQuery([
                        'callback_query_id' => $update['callback_query']['id'],
                        'text' => "Ви надали доступ до приміщення",
                        'show_alert' => true
                    ]);
                    Log::create(['descriptions' => "Надано доступ до приміщення [intercom_devices.id = " . $telegram_user->intercom_device->id . "][intercom_devices.mac_address = " . $telegram_user->intercom_device->mac_address . "][messenger_users.id = 4][messenger_users.telegram_id = " . $telegram_user->telegram_id . "]"]);
                }
                else
                {
                    Telegram::answerCallbackQuery([
                        'callback_query_id' => $update['callback_query']['id'],
                        'text' => "Ви відмовили у доступі до приміщення",
                        'show_alert' => true
                    ]);
                    Log::create(['descriptions' => "Відмовлено доступ до приміщення [intercom_devices.id = " . $telegram_user->intercom_device->id . "][intercom_devices.mac_address = " . $telegram_user->intercom_device->mac_address . "][messenger_users.id = 4][messenger_users.telegram_id = " . $telegram_user->telegram_id . "]"]);
                }

                if (!$telegram_user->intercom_device->created_at->addSeconds(20)->isPast())
                {
                    Http::post('http://' . $ip_address . ':80/', [
                        'success' => 'true',
                    ]);
                }



            }

        }


        return true;
    }
}
