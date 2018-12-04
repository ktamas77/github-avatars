#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;

function getCollaborators($account, $repository, $username, $password)
{
    $apiUrl = "https://api.github.com/repos/$account/$repository/collaborators";
    $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';
    $process = curl_init($apiUrl);
    if (($username !== null) && ($password !== null)) {
        curl_setopt($process, CURLOPT_USERPWD, "$username:$password");
    }
    curl_setopt($process, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($process, CURLOPT_HEADER, 0);
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($process);
    return json_decode($result, true);
}

$app = new Application();
$app->command('download account repository [-u|--username=] [-p|--password=] [-d|--directory=]',
    function ($account, $repository, $username, $password, $directory, OutputInterface $output) {
        if ($directory === null) {
            $directory = __DIR__;
        }
        $output->writeln("Destination directory: [$directory]");
        $output->writeln("Downloading list...");
        $collaborators = getCollaborators($account, $repository, $username, $password);
        $totalCollaborators = sizeof($collaborators);
        $output->writeln("Found $totalCollaborators collaborators.");
        foreach ($collaborators as $collaborator) {
            $login = $collaborator['login'];
            $avatarUrl = $collaborator['avatar_url'];
            $output->writeln("Downloading avatar [$login.jpg]...");
            $avatarImage = file_get_contents($avatarUrl);
            file_put_contents("$directory/$login.jpg", $avatarImage);
        }
        $output->writeln("Done.");
    });

$app->run();
