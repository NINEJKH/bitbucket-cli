<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

// disable xdebug thingy
ini_set('xdebug.remote_autostart', false);
ini_set('xdebug.remote_enable', false);
ini_set('xdebug.profiler_enable', false);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('xdebug.var_display_max_depth', -1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\Repositories\PullRequests\GetCommand;
use App\Commands\Repositories\PullRequests\GetDescriptionCommand;
use App\Commands\Repositories\PullRequests\UpdateCommand;
use App\Commands\Repositories\PullRequests\UpdateDescriptionCommand;
use Symfony\Component\Console\Application;

if (file_exists(__DIR__ . '/version.txt')) {
    $version = rtrim(file_get_contents(__DIR__ . '/version.txt'));
} else {
    $version = 'dev';
}

$app = new Application('bitbucket', $version);
$app->add(new GetCommand);
$app->add(new GetDescriptionCommand);
$app->add(new UpdateCommand);
$app->add(new UpdateDescriptionCommand);
$app->run();
