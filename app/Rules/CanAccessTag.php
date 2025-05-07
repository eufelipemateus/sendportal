<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Facades\Sendportal;
use App\Models\Tag;

class CanAccessTag implements Rule
{
    public function passes($attribute, $value): bool
    {
        $tag = Tag::find($value);

        if (! $tag) {
            return false;
        }

        return $tag->workspace_id == Sendportal::currentWorkspaceId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Tag ID :input does not exist.';
    }
}
