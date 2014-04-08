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

interface CheckerInterface
{
    /**
     * Return whether the checks performed correctly or not
     *
     * @return Status
     */
    public function getStatus();
} 