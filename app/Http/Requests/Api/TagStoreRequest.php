<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Facades\Sendportal;

class TagStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('sendportal_tags')
                    ->where('workspace_id', Sendportal::currentWorkspaceId()),
            ],
            'subscribers' => [
                'array',
                'nullable',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('The tag name must be unique.'),
        ];
    }
}
