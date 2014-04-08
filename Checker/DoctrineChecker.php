<?php

/*
 * This file is part of SiteStatusCheckerBundle
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace AFM\Bundle\SiteStatusCheckerBundle\Checker;

use AFM\Bundle\SiteStatusCheckerBundle\Status\Status;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineChecker implements CheckerInterface
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        $data = array();
        $status = true;

        foreach($this->doctrine->getConnections() as $connection)
        {
            /** @var $connection Connection */
            if($connection->isConnected())
            {
                $connection->close();
                $data[$connection->getHost()] = true;
            }

            try
            {
                $connection->connect();
                $connection->close();

                $data[$connection->getHost()] = true;
            }
            catch (\Exception $exception)
            {
                $data[$connection->getHost()] = false;
                $status = false;
            }
        }

        return new Status($status, $data);
    }

    public function getName()
    {
        return 'doctrine';
    }
} 