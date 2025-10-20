<?php

namespace Imran\DevTools\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Imran\DevTools\Contracts\CommandExecutorInterface;
use Imran\DevTools\Contracts\CommandResult;

class ArtisanCommandService implements CommandExecutorInterface
{
    /**
     * Execute an Artisan command and return the result.
     */
    public function execute(string $command, array $parameters = []): CommandResult
    {
        try {
            $exitCode = Artisan::call($command, $parameters);
            $output = trim(Artisan::output());
            
            $success = $exitCode === 0;
            
            if (!$success) {
                Log::warning("DevTools command '{$command}' exited with code {$exitCode}", [
                    'output' => $output,
                ]);
            }

            return new CommandResult(
                command: $command,
                success: $success,
                output: $output,
                error: $success ? null : "Command exited with code {$exitCode}"
            );
        } catch (\Throwable $e) {
            Log::error("DevTools command '{$command}' failed: {$e->getMessage()}", [
                'exception' => $e,
            ]);

            return new CommandResult(
                command: $command,
                success: false,
                output: '',
                error: $e->getMessage()
            );
        }
    }

    /**
     * Execute multiple commands and return results.
     */
    public function executeMultiple(array $commands): array
    {
        $results = [];

        foreach ($commands as $command => $parameters) {
            // Support both ['command' => ['param' => 'value']] and ['command']
            if (is_numeric($command)) {
                $command = $parameters;
                $parameters = [];
            }

            $results[] = $this->execute($command, $parameters);
        }

        return $results;
    }
}
