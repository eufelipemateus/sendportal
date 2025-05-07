<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CanAccessSubscriber;

class TagSubscriberUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subscribers' => ['array', 'required'],
            'subscribers.*' => ['integer', new CanAccessSubscriber()]
        ];
    }
}
