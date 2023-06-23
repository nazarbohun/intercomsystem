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
        Schema::create('permission_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('messenger_user_id');
            $table->BigInteger('number_premise');
            $table->boolean('permission_access');
            $table->timestamps();

            $table->foreign('messenger_user_id')
                ->references('id')
                ->on('messenger_users')
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
        Schema::dropIfExists('permission_requests');
    }
};
