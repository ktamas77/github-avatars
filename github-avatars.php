#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;


$app = new Application();
$app->command('download account repository [-u|--username=] [-p|--password=]',
    function ($account, $repository, $username, $password, OutputInterface $output) {
        $output->writeln('hello');
    });
$app->run();
