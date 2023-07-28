<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class CardCodes extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'category_id',
        'app_id',
        'code',
        'secret_key',
        'expiration_date',
        'is_used',
        'usage_limit',
        'activated_at',
        'note',
        'active',
        'expiration_action',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function searchableAs(): string
    {
        return 'cardCode_index';
    }

    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class, 'app_id');
    }

    /**
     * 获取该卡密的所有激活记录。
     */
    public function activations(): HasMany
    {
        return $this->hasMany(CardCodeActivation::class, 'card_code_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
        ];
    }
}
