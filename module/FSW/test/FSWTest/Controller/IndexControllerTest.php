<?php

namespace FSWTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AlbumControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include  __DIR__ . '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }
    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/fsw');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('FSW');
        $this->assertControllerName('FSW\Controller\FSW');
        $this->assertControllerClass('FSWController');
        $this->assertMatchedRouteName('fsw');
    }
}