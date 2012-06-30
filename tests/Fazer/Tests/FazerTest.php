<?php

namespace Fazer\Tests;

use Fazer\Fazer;
use Silex\WebTestCase;
use Fazer\TodoList;

class FazerTest extends WebTestCase
{
    /**
     * needed method to create app
     * 
     * @return array|mixed|\Symfony\Component\HttpKernel\HttpKernel
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../src/app.php';
        $app['debug'] = true;
        unset($app['exception_handler']);
        require __DIR__.'/../../../config/dev.php';
        require __DIR__.'/../../../src/controllers.php';
        return $app;
    }
    
    public function testBisect()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/add');
        
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('body:contains("test")'));
    }
}