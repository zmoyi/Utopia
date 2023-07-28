<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardCodeActivation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_code_id',
        'activated_at',
        'activation_ip',
        'activation_device',
        'activation_app_signature',
        'app_id',
        'activation_count',
        'is_single_use',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * 获取该激活记录所属的卡密。
     */
    public function cardCode(): BelongsTo
    {
        return $this->belongsTo(CardCodes::class, 'card_code_id');
    }

    /**
     * 获取该激活记录所属的 App。
     */
    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class, 'app_id');
    }
}
