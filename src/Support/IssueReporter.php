<?php

namespace Hexters\FeedbackNow\Support;

use Hexters\FeedbackNow\Support\Contracts\IssueDriver;
use Hexters\FeedbackNow\Support\Drivers\GithubDriver;
use Hexters\FeedbackNow\Support\Drivers\GitlabDriver;

class IssueReporter
{
    public static function driver(): IssueDriver
    {
        return match (config('feedback-now.provider')) {
            'gitlab' => new GitlabDriver,
            default  => new GithubDriver,
        };
    }
}
