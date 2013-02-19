<?php

class CMFIOC extends CComponent implements ArrayAccess, IIOC
{
    private $components = array();

    /* yii related staff */

    public function setComponents($value)
    {
        if (! is_array($value)){
            throw new InvalidArgumentException("IOC container should be array");
        }
        $this->components= $value;
    }

    public function init() {

    }

    /* /yii related staff */
/*
* @param string $id  component alias
* @param mixed  $value The value of the component or a closure to defined an object
*/
    function offsetSet($id, $value)
    {
        $this->components[$id] = $value;
    }

    /**
     * @param  string $id component alias
     *
     * @return mixed  The value of the parameter or an object
     *
     * @throws InvalidArgumentException if no alias defined
     */

    function offsetGet($id)
    {
        if (!array_key_exists($id, $this->components)) {
            throw new InvalidArgumentException(sprintf('Component with alias "%s" is not configured.', $id));
        }
        return $this->components[$id] instanceof Closure ? $this->components[$id]($this) : $this->components[$id];
    }

    /**
     * Checks if a parameter or an object is set.
     *
     * @param  string $id component alias
     *
     * @return Boolean
     */
    function offsetExists($id)
    {
        $result = array_key_exists($id, $this->components);
        return $result;
    }

    /**
     * Unsets a parameter or an object.
     *
     * @param  string $id The unique identifier for the parameter or object
     */
    function offsetUnset($id)
    {
        unset($this->components[$id]);
    }



/*
  $a = 'iInterface';
  $с = new B();
  var_dump($с instanceof $a);
     */
    function Resolve($Type, $name, $ResolverOverride)
    {
        if ($this->offsetExists($Type)){
            //print 'creating :'.$Type.'<br/>';
            $theobject = new $this[$Type];
            //print_r($theobject);
            return $theobject;
        } else {
            throw new InvalidArgumentException(sprintf('Component with alias "%s" is not configured.', $Type));
        }
    }

    function RegisterType($Type, $CreatorClass, $lifetimemanager)
    {

        $this[$Type] = function() use ($CreatorClass) {
            //print_r($CreatorClass);
            return new $CreatorClass();
        };
    }

    function RegisterInstance($Type, $name, $instance, $lifetimemanager)
    {
        $this[$Type] = new $Type();

    }
}
