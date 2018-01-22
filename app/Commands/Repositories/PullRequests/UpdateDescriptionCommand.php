<?php

namespace App\Commands\Repositories\PullRequests;

use App\Commands\Repositories\PullRequestsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;

class UpdateDescriptionCommand extends PullRequestsCommand
{
    protected function configure()
    {
        $this
            ->setName('repositories:pullrequests:update:description')
            ->setDescription('Update a specific pull request description')
            ->addArgument('repo', InputArgument::REQUIRED, 'owner/repository_slug')
            ->addArgument('pull_request_id', InputArgument::REQUIRED, 'The id of the pull request.')
            ->addArgument('description', InputArgument::OPTIONAL, 'New description to set.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $description = null;

        if ($description = $input->getArgument('description')) {
        } elseif (ftell(STDIN) === 0) {
            $description = stream_get_contents(STDIN);
        }

        if (empty($description)) {
            throw new RuntimeException('Empty description.');
        }

        $pull = $this->create();

        list($username, $repo_slug) = $this->splitRepo($input->getArgument('repo'));

        $pr = $pull->get($username, $repo_slug, $input->getArgument('pull_request_id'));
        if (!$pr->isOk()) {
            $this->throwApiResponseError($pr);
        }

        $current_pr = json_decode($pr->getContent(), true);

        $payload = [
            'title' => $current_pr['title'],
            'description' => $description,
            'destination' => [
                'branch' => [
                    'name' => $current_pr['destination']['branch']['name']
                ]
            ]
        ];

        $pr = $pull->update($username, $repo_slug, $input->getArgument('pull_request_id'), $payload);

        if (!$pr->isOk()) {
            $this->throwApiResponseError($pr);
        }

        return true;
    }
}
