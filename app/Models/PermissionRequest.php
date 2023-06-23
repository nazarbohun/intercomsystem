<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionRequest extends Model
{
    protected $fillable = [
        'messenger_user_id',
        'number_premise',
        'permission_access'
    ];

    public function messenger_user(): BelongsTo
    {
        return $this->belongsTo(MessengerUsers::class);
    }
}
