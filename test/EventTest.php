<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Kerios\Event\Event;

/**
 *
 */
class EventTest extends TestCase
{

    /**
     * @var Event
     */
    private $event = null;

    /**
     *
     */
    public function setUp()
    {
        $this->event = new Event('database.delete');
    }

    public function testSetName()
    {
        $this->event->setName('database.update');
        $name = $this->event->getName();
        $this->assertEquals('database.update',$name);
    }

}
