<?php

namespace App\Commands\Repositories;

use App\Commands\BitbucketCommand;
use App\Providers\BitbucketConfigProvider;
use Bitbucket\API\Http\Listener\BasicAuthListener;
use Bitbucket\API\Repositories\PullRequests;

abstract class PullRequestsCommand extends BitbucketCommand
{
    protected function create()
    {
        $bitbucket_config = new BitbucketConfigProvider;

        $pull = new PullRequests;
        $pull->getClient()->addListener(
            new BasicAuthListener($bitbucket_config->getBasicAuthUsername(), $bitbucket_config->getBasicAuthPassword())
        );

        return $pull;
    }
}
