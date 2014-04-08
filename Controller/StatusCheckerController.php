<?php

/*
 * This file is part of SiteStatusCheckerBundle
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace AFM\Bundle\SiteStatusCheckerBundle\Controller;

use AFM\Bundle\SiteStatusCheckerBundle\Service\StatusChecker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatusCheckerController extends Controller
{
    /**
     * @var StatusChecker
     */
    protected $statusChecker;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        $this->statusChecker = $container->get('afm.site_status_checker.checker');
    }

    public function checkAction($token)
    {
        try
        {
            $status = $this->statusChecker->performStatusCheck($token);
        }
        catch(\Exception $exception)
        {
            $status = false;
        }

        return new JsonResponse($status->getData(), $status ? 200 : 500);
    }
} 