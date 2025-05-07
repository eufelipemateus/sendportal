<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CanAccessTag;

class SubscriberTagStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tags' => ['array', 'required'],
            'tags.*' => ['integer', new CanAccessTag()]
        ];
    }
}
