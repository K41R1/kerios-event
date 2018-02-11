<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use Kerios\Event\EventDispatcher;

/**
 *
 */
class EventDispatcherTest extends TestCase
{
    /**
     * @var EventDispatcher
     */
    private $em;

    public function setUp()
    {
        $this->em = new EventDispatcher();
    }

    public function testAttachEvent()
    {
        $this->em->attach('database.update', function () {
          echo "database updated 1"."\n";
        });
        $this->em->attach('database.update', function () {
          echo "database updated 2"."\n";
        });

        $this->em->attach('database.update', function () {
          echo "database updated 3"."\n";
        });
        $this->em->trigger('database.update');
        $this->expectOutputString("database updated 1\ndatabase updated 2\ndatabase updated 3\n");
    }

    public function testAttachEventWithParams()
    {
        $this->em->attach('database.delete', function ($event) {
          echo $event->getName();
        });
        $this->em->trigger('database.delete');
        $this->expectOutputString("database.delete");
    }

    public function testDetachEvent()
    {
        $c = function () {
          echo "string ";
        };
        $this->em->attach('user.create', $c);
        $this->em->attach('user.create', $c);
        $this->em->attach('user.create', function () {
          echo "user was created"."\n";
        });
        $this->em->detach('user.create', $c);
        $this->em->trigger('user.create');
        $this->expectOutputString("user was created\n");
    }

    public function testWithPriority()
    {
      $this->em->attach("user.delete", function () {
        echo "this is the last";
      }, 100);
      $this->em->attach("user.delete", function () {
        echo "this is the second";
      }, 50);
      $this->em->attach("user.delete", function () {
        echo "this is the first";
      }, 10);
      $this->em->trigger('user.delete');
      $this->expectOutputString("this is the firstthis is the secondthis is the last");
    }


    public function testClearListeners()
    {
      $this->em->attach("user.delete", function () {
        echo "this is the last";
      }, 100);
      $this->em->attach("user.delete", function () {
        echo "this is the second";
      }, 50);
      $this->em->attach("user.delete", function () {
        echo "this is the first";
      }, 10);
      $this->em->clearListeners('user.delete');
      $this->em->trigger('user.delete');
      $this->expectOutputString("");
    }
}
