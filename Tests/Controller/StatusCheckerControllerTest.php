<?php

/*
 * This file is part of SiteStatusCheckerBundle
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace AFM\Bundle\SiteStatusCheckerBundle\Tests\Controller;

use AFM\Bundle\SiteStatusCheckerBundle\Tests\AppKernel;
use AFM\Bundle\SiteStatusCheckerBundle\Tests\AppKernelInvalid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

class StatusCheckerControllerTest extends WebTestCase
{
    public function testStatusTokenIncorrect()
    {
        $client = static::createClient();

        $client->request("GET", "/status/check/my_token");
        $response = $client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testStatusTokenCorrectValidStatus()
    {
        $client = static::createClient();

        $client->request("GET", "/status/check/my_secure_token");
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("", $response->getContent());
    }

    public function testStatusTokenCorrectInvalidStatus()
    {
        $client = static::createClient(array('environment' => 'test_invalid'));

        $client->request("GET", "/status/check/my_secure_token");
        $response = $client->getResponse();

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals("", $response->getContent());
    }

    protected static function getPhpUnitXmlDir()
    {
        return __DIR__ . '/../../';
    }

    protected static function createKernel(array $options = array())
    {
        return new AppKernel(isset($options['environment']) ? $options['environment'] : "test", true);
    }
}