<?php

namespace Database\Seeders;

use App\Models\IntercomDevice;
use Illuminate\Database\Seeder;

class IntercomDevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $intercom_devices = [
            [
                'address' => 'вулиця Степана Бандери, 12, Львів, Львівська область, Україна',
                'user_id' => 1,
                'number_premises' => 27,
                'mac_address' => '00-B0-D0-63-C2-26',
                'ip_address' => '192.158.1.38'

            ],
            [
                'address' => 'вулиця Степана Бандери, 30, Львів, Львівська область, Україна',
                'user_id' => 1,
                'number_premises' => 28,
                'mac_address' => '00-B0-D0-63-C2-27',
                'ip_address' => '192.158.1.39'

            ],
            [
                'address' => 'вулиця Академіка Андрія Сахарова, 23, Львів, Львівська область, Україна',
                'user_id' => 1,
                'number_premises' => 32,
                'mac_address' => '00-B0-D0-63-C2-28',
                'ip_address' => '192.158.1.40'

            ]
        ];
        foreach ($intercom_devices as $device)
        {
            IntercomDevice::create($device);
        }
    }
}
