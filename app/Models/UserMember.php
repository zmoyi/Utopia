<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'membership_level',
        'expiration_date',
        'card_codes_quota'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
