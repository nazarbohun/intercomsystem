<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MessengerUsers extends Model
{
    protected $fillable = [
        'telegram_id',
        'intercom_device_id',
        'name',
        'user_name'
    ];


    public function intercom_device(): BelongsTo
    {
        return $this->belongsTo(IntercomDevice::class);
    }
    public function permission_request() : HasOne
    {
        return $this->hasOne(PermissionRequest::class,'messenger_user_id','id');
    }

}
