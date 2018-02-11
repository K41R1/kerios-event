<?php
namespace Kerios\Event;

use Kerios\Psr\EventManager\EventInterface;

/**
 *
 */
class Event implements EventInterface
{
    /**
     * @var null|string|object $target
     */
    private $target;

    /**
     * @var array $params
     */
    private $params;

    /**
     * @var bool $flag
     */
    private $flag;

    /**
     * @var string $name
     */
    private $name = null;

    /**
     * @param string $name
     * @param null|string|object $target
     * @param array  $params
     */
    public function __construct(string $name = null, $target = null, array $params = [])
    {
        $this->name = $name;
        $this->target = $target;
        $this->params = $params;
    }

    /**
     * Get event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get target/context from which event was triggered
     *
     * @return null|string|object
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Get parameters passed to the event
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get a single parameter by name
     *
     * @param  string $name
     * @return mixed
     */
    public function getParam($name)
    {
        if ($this->params[$name]) {
            return $this->params[$name];
        }
        return null;
    }

    /**
     * Set the event name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
        return;
    }

    /**
     * Set the event target
     *
     * @param  null|string|object $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return;
    }

    /**
     * Set event parameters
     *
     * @param  array $params
     * @return void
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return;
    }

    /**
     * Indicate whether or not to stop propagating this event
     *
     * @param  bool $flag
     */
    public function stopPropagation($flag)
    {
        $this->flag = $flag;
        return;
    }

    /**
     * Has this event indicated event propagation should stop?
     *
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->flag;
    }
}
