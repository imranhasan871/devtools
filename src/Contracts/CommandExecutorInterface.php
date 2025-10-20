<?php

namespace Imran\DevTools\Contracts;

interface CommandExecutorInterface
{
    /**
     * Execute an Artisan command and return the result.
     *
     * @param string $command
     * @param array $parameters
     * @return CommandResult
     */
    public function execute(string $command, array $parameters = []): CommandResult;

    /**
     * Execute multiple commands and return results.
     *
     * @param array $commands
     * @return array<CommandResult>
     */
    public function executeMultiple(array $commands): array;
}
