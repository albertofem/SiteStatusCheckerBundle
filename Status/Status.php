<?php

/*
 * This file is part of SiteStatusCheckerBundle
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace AFM\Bundle\SiteStatusCheckerBundle\Status;

class Status
{
    /**
     * @var bool
     */
    protected $status = false;

    /**
     * @var array
     */
    protected $data;

    public function __construct($status, $data)
    {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }
} 