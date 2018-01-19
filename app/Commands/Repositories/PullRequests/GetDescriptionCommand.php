<?php

namespace App\Commands\Repositories\PullRequests;

use App\Commands\Repositories\PullRequestsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetDescriptionCommand extends PullRequestsCommand
{
    protected function configure()
    {
        $this
            ->setName('repositories:pullrequests:get:description')
            ->setDescription('Get a specific pull request description')
            ->addArgument('repo', InputArgument::REQUIRED, 'owner/repository_slug')
            ->addArgument('pull_request_id', InputArgument::REQUIRED, 'The id of the pull request.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pull = $this->create();

        list($username, $repo_slug) = $this->splitRepo($input->getArgument('repo'));

        $pr = $pull->get($username, $repo_slug, $input->getArgument('pull_request_id'));

        if (!$pr->isOk()) {
            $this->throwApiResponseError($pr);
        }

        $output->writeln(json_decode($pr->getContent(), true)['description']);
    }
}
