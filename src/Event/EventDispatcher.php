<?php
namespace Kerios\Event;

use Kerios\Psr\EventManager\EventInterface;
use Kerios\Psr\EventManager\EventManagerInterface;
use Kerios\Event\Event;

/**
 *
 */
class EventDispatcher implements EventManagerInterface
{
    /**
     * @var array $listeners
     */
    private $listeners = [];

    /**
     * Attaches a listener to an event
     *
     * @param string $event the event to attach too
     * @param callable $callback a callable function
     * @param int $priority the priority at which the $callback executed
     * @return bool true on success false on failure
     */
    public function attach($event, $callback, $priority = 0)
    {
        $this->listeners[$event][] = [
           $callback, $priority];
        return true;
    }

    /**
     * Detaches a listener from an event
     *
     * @param string $event the event to attach too
     * @param callable $callback a callable function
     * @return bool true on success false on failure
     */
    public function detach($event, $callback)
    {
        $this->listeners[$event] = array_filter($this->getListeners($event) , function ($arr) use ($callback) {
            if ($arr[0] != $callback) {
              return $arr;
            }
        });
        return true;
    }

    /**
     * Clear all listeners for a given event
     *
     * @param  string $event
     * @return void
     */
    public function clearListeners($event)
    {
        $this->listeners[$event] = [];
        return;
    }

    /**
     * Trigger an event
     *
     * Can accept an EventInterface or will create one if not passed
     *
     * @param  string|EventInterface $event
     * @param  object|string $target
     * @param  array $argv
     * @return mixed
     */
    public function trigger($event, $target = null, $argv = [])
    {
        if (is_string($event)) {
            $event = new Event($event, $target, $argv);
        }

        // Sort listeners by priority
        $this->sort($event->getName());

        foreach ($this->getListeners($event->getName()) as $listener) {
            call_user_func_array($listener[0], [$event]);
        }
    }

    /**
     * @param  string $name
     * @return bool
     */
    private function sort(string $name)
    {
        return usort($this->listeners[$name], function ($a, $b) {
            return $a[1] > $b[1] ;
        });
    }

    /**
     * Return an Array of spicefied event
     *
     * @param  string $name
     * @return array
     */
    private function getListeners(string $name)
    {
        return $this->listeners[$name];
    }
}
