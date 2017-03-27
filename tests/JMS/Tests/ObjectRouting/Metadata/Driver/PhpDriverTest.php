<?php

namespace JMS\Tests\ObjectRouting\Metadata\Driver;

use JMS\ObjectRouting\Metadata\Driver\PhpDriver;
use Metadata\Driver\FileLocator;

class PhpDriverTest extends \PHPUnit_Framework_TestCase
{
    /** @var PhpDriver */
    private $driver;

    public function testLoad()
    {
        $metadata = $this->driver->loadMetadataForClass(new \ReflectionClass('JMS\Tests\ObjectRouting\Metadata\Driver\Fixture\BlogPost'));
        $this->assertCount(2, $metadata->routes);

        $routes = array(
            'view' => array('name' => 'blog_post_view', 'params' => array('slug' => 'slug')),
            'edit' => array('name' => 'blog_post_edit', 'params' => array('slug' => 'slug')),
        );
        $this->assertEquals($routes, $metadata->routes);
    }

    public function testLoadReturnsNullWhenNoRoutes()
    {
        $this->assertNull($this->driver->loadMetadataForClass(new \ReflectionClass('stdClass')));
    }

    protected function setUp()
    {
        $this->driver = new PhpDriver(new FileLocator(array('' => realpath(__DIR__.'/../../Resources/config'))));
    }
}