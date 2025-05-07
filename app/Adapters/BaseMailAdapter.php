<?php

namespace App\Adapters;

use App\Interfaces\MailAdapterInterface;

abstract class BaseMailAdapter implements MailAdapterInterface
{
    /** @var array */
    protected $config;

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
