<?php

$bot = new Bot('token');

$container = new Container();

$runner = new PollingRunner($bot, $container);
// or
$runner = new WebhookRunner($bot, $container);

$runner->run();

// ____________OR____________

$runner = Runner::make()
    ->behaviour(Webhook::class)
    ->bot($bot)
    ->container(new Container())
    ->build();

// or
$runner = Runner::make()
    ->behaviour(Webhook::class)
    ->bot($bot)
    ->handlers([
        new SomeCommand(),
        new SomeCommand(),
        new SomeCommand(),
        new PlainTextHandler(),
        new ImagEHandler(),
    ])
    ->build();

$runner->run();


// ____________OR____________

$webhook = new Webhook($bot);
$webhook->set();
// or
$webhook->unset();
