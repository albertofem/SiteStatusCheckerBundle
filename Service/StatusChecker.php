<?php

/*
 * This file is part of SiteStatusCheckerBundle
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace AFM\Bundle\SiteStatusCheckerBundle\Service;

use AFM\Bundle\SiteStatusCheckerBundle\Checker\CheckerInterface;
use AFM\Bundle\SiteStatusCheckerBundle\Exception\InvalidTokenException;
use AFM\Bundle\SiteStatusCheckerBundle\Status\Status;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZendDiagnostics\Runner\Runner;

class StatusChecker
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var Runner
     */
    protected $runner;

    public function __construct($token, Runner $runner)
    {
        $this->token = $token;
        $this->runner = $runner;
    }

    public function performStatusCheck($token)
    {
        if($token !== $this->token)
            throw new InvalidTokenException;

        $this->runner->setBreakOnFailure(true);
        $results = $this->runner->run();
        $this->runner->setBreakOnFailure(false);

        if($results->getFailureCount() > 0)
            return false;

        return true;
    }
}