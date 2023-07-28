<?php

namespace App\DTO;

use Fresns\DTO\DTO;

class CodeDataDTO extends DTO
{
    public function rules(): array
    {
        return [
            'sign' => 'required|string',
            'codes' => 'required|string'
        ];
    }
}
