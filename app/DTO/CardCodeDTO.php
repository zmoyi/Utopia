<?php

namespace App\DTO;

use Fresns\DTO\DTO;

class CardCodeDTO extends DTO
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'unique:card_codes'],
            'secret_key' => ['required', 'string'],
            'expiration_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'app_id' => ['required', 'integer', 'exists:apps,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'is_used' => ['boolean'],
            'usage_limit' => ['required', 'integer', 'min:1'],
            'activated_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'note' => ['nullable', 'string'],
            'active' => ['boolean'],
            'expiration_action' => ['string'],
        ];
    }
}
