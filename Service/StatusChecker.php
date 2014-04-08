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

class StatusChecker
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var CheckerInterface[]
     */
    protected $checkers;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct($token, $checkers, ContainerInterface $container)
    {
        $this->token = $token;
        $this->checkers = $checkers;
        $this->container = $container;
    }

    public function performStatusCheck($token)
    {
        if($token !== $this->token)
            throw new InvalidTokenException;

        $status = true;
        $statuses = array();

        foreach($this->getCheckers() as $checker)
        {
            /** @var CheckerInterface $checker */
            $checker = $this->container->get($checker);
            $checkerStatus = $checker->getStatus();

            $statuses[$checker->getName()] = $checkerStatus->getData();
            $status = $status && $checkerStatus->getStatus();
        }

        return new Status($status, $statuses);
    }

    /**
     * @return CheckerInterface[]
     */
    protected function getCheckers()
    {
        return $this->checkers;
    }
}