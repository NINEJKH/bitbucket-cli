<?php

namespace App\Commands\Repositories\PullRequests;

use App\Commands\Repositories\PullRequestsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;

class UpdateCommand extends PullRequestsCommand
{
    protected function configure()
    {
        $this
            ->setName('repositories:pullrequests:update')
            ->setDescription('Get a specific pull request')
            ->addOption('file', 'f', InputOption::VALUE_OPTIONAL,'Path to JSON formatted input file')
            ->addArgument('repo', InputArgument::REQUIRED, 'owner/repository_slug')
            ->addArgument('pull_request_id', InputArgument::REQUIRED, 'The id of the pull request.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($filename = $input->getOption('file')) {
            $payload = file_get_contents($filename);
        } elseif (ftell(STDIN) === 0) {
            $payload = stream_get_contents(STDIN);
        } else {
            throw new RuntimeException('Please provide a filename or pipe content to STDIN.');
        }

        if (empty($payload)) {
            throw new RuntimeException('Empty payload.');
        }

        $payload = json_decode($payload, true);

        $pull = $this->create();

        list($username, $repo_slug) = $this->splitRepo($input->getArgument('repo'));

        $pr = $pull->update($username, $repo_slug, $input->getArgument('pull_request_id'), $payload);

        if (!$pr->isOk()) {
            $this->throwApiResponseError($pr);
        }

        return true;
    }
}
