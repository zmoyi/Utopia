<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class App extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'user_id',
        'public_key',
        'private_key',
        'custom_fields',
    ];

    protected $casts = [
        'custom_fields' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cardCodes(): HasMany
    {
        return $this->hasMany(CardCodes::class, 'app_id');
    }

    /**
     * 获取该 App 拥有的所有卡密记录。
     */
    public function activations(): HasMany
    {
        return $this->hasMany(CardCodeActivation::class, 'app_id');
    }


}
