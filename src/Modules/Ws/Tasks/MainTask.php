<?php

declare(strict_types=1);

namespace App\Modules\Ws\Tasks;

use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Minimal public-safe WebSocket example.
 *
 * The default protocol accepts only a JSON ping message and returns pong. Add
 * authenticated application message types in a project-owned task instead of
 * exposing arbitrary subscription or broadcast behavior.
 */
class MainTask extends AbstractTask
{
    /**
     * Build the response for an incoming text frame.
     *
     * @return array{type: string, message?: string}
     */
    public function getMessageResponse(string $message): array
    {
        if (!json_validate($message)) {
            return ['type' => 'error', 'message' => 'Invalid JSON'];
        }

        $payload = json_decode($message, true);
        if (!is_array($payload) || !isset($payload['type']) || !is_string($payload['type'])) {
            return ['type' => 'error', 'message' => 'A string message type is required'];
        }

        return match ($payload['type']) {
            'ping' => ['type' => 'pong'],
            default => ['type' => 'error', 'message' => 'Unsupported message type'],
        };
    }

    /**
     * Reply to a WebSocket text frame without echoing untrusted input.
     */
    #[\Override]
    public function onMessage(Server $server, Frame $frame): void
    {
        $response = json_encode($this->getMessageResponse((string)$frame->data));
        if ($response !== false) {
            $server->push($frame->fd, $response);
        }
    }
}
