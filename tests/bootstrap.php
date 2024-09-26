<?php

declare(strict_types=1);

namespace Tests;

$envVariables = [
    'BOT_TOKEN' => 'bot_token'
];

foreach ($envVariables as $name => $value) {
    putenv("$name=$value");
}
