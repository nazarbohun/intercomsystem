<?php

namespace App\Bots\Telegram\Commands;

use App\Models\IntercomDevice;
use App\Models\MessengerUsers;
use App\Models\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start Command to get you started';

    public function handle()
    {
        $keyboard = new Keyboard(['one_time_keyboard' => true]);
        $keyboard->inline();

        $devices = IntercomDevice::select(['id','address'])->get();

        foreach ($devices as $device)
        {

            $keyboard->row([Keyboard::inlineButton(['text'=> $device->address,'callback_data'=>json_encode(['device' => $device->id])])]);
        }
        $tel_user = MessengerUsers::where('telegram_id',$this->getUpdate()->getMessage()['from']['id'])->first();
        if (!empty($tel_user->permission_request) && $tel_user->permission_request->permission_access)
        {
            $this->replyWithMessage([
                'text' => "Ви уже зареєстровані у системі та керуєте домофоном за адресою: " . $tel_user->intercom_device->address . " номер приміщення (квартири): " . $tel_user->permission_request->number_premise
            ]);
        }
        else
        {
            $this->replyWithMessage([
                'text' => "Вітання!! Ви потрапили до системи домофону!\nВам потрібно вибрати адрес приміщення доступом до якого ви хочете керувати. \nОберіть адрес приміщення із списку нижче:",
                'reply_markup' => $keyboard
            ]);
        }


    }
}
