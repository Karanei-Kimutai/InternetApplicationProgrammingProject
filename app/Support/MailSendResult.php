<?php

namespace App\Support;

class MailSendResult
{
    public function __construct(
        public readonly bool $sent,
        public readonly ?string $error = null,
    ) {
    }

    public static function sent(): self
    {
        return new self(true, null);
    }

    public static function failed(?string $error = null): self
    {
        return new self(false, $error);
    }
}
