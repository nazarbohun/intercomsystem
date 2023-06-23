<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messenger_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('telegram_id');
            $table->string('name')->nullable();
            $table->string('user_name')->nullable();
            $table->unsignedBigInteger('intercom_device_id');
            $table->timestamps();

            $table->foreign('intercom_device_id')
                ->references('id')
                ->on('intercom_devices')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messenger_users');
    }
};
