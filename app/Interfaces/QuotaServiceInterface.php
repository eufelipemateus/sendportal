<?php

namespace App\Interfaces;

use App\Models\EmailService;

interface QuotaServiceInterface
{
    public function exceedsQuota(EmailService $emailService, int $messageCount): bool;
}
