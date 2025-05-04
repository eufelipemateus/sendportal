<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Facades\Sendportal;
use App\Models\Subscriber;

class CanAccessSubscriber implements Rule
{
    public function passes($attribute, $value): bool
    {
        $subscriber = Subscriber::find($value);

        if (! $subscriber) {
            return false;
        }

        return $subscriber->workspace_id == Sendportal::currentWorkspaceId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
