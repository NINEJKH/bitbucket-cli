<?php

namespace App\Commands;

use Buzz\Message\MessageInterface;
use Symfony\Component\Console\Command\Command;
use RuntimeException;

abstract class BitbucketCommand extends Command
{
    protected function throwApiResponseError(MessageInterface $message)
    {
        $error_message = $message->getContent();
        if (preg_match('~^{.*}$~', $error_message)) {
            $error_message = json_decode($error_message, true);
            if (!empty($error_message['error'])) {
                $error_message = sprintf('[%s]%s%s', $error_message['error']['message'], PHP_EOL, $error_message['error']['detail']);
            }
        }

        throw new RuntimeException($error_message, $message->getStatusCode());
    }

    protected function splitRepo($repo)
    {
        return explode('/', $repo, 2);
    }
}
