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

use AFM\Bundle\SiteStatusCheckerBundle\Exception\InvalidTokenException;
use AFM\Bundle\SiteStatusCheckerBundle\Service\StatusChecker;
use AFM\Bundle\SiteStatusCheckerBundle\Status\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StatusCheckerController extends Controller
{
    public function checkAction($token)
    {
        /** @var StatusChecker $checker */
        $checker = $this->get('afm.site_status_checker.checker');

        try
        {
            $status = $checker->performStatusCheck($token);
        }
        catch(InvalidTokenException $exception)
        {
            return new Response("KO", 403);
        }
        catch(\Exception $exception)
        {
            return new Response("KO", 500);
        }

        return new Response($status ? "OK" : "KO", $status ? 200 : 500);
    }
} 