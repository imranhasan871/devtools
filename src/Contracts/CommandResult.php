<?php

namespace Imran\DevTools\Contracts;

class CommandResult
{
    public function __construct(
        public readonly string $command,
        public readonly bool $success,
        public readonly string $output,
        public readonly ?string $error = null
    ) {}

    public function toArray(): array
    {
        return [
            'command' => $this->command,
            'success' => $this->success,
            'output' => $this->output,
            'error' => $this->error,
        ];
    }
}
