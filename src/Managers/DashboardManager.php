<?php

namespace Igorwanbarros\Autenticacao\Managers;

class DashboardManager implements \ArrayAccess, \IteratorAggregate
{
    protected $dashboards = [];


    /**
     * @param mixed $className
     * @param mixed $name
     * @param mixed $alias
     * @param mixed $method
     *
     * @return $this
     */
    public function add($alias, $name = null, $className = null, $method = null)
    {
        if (is_array($alias)) {
            $this->dashboards = array_merge($this->dashboards, $alias);

            return $this;
        }

        $this->dashboards[] = [
            'alias'     => $alias,
            'name'      => $name,
            'class'     => $className,
            'method'    => $method,
        ];

        return $this;
    }


    /**
     * @param string $column
     * @param string $indexKey
     *
     * @return array
     */
    public function lists($column = 'name', $indexKey = 'name')
    {
        return array_column($this->dashboards, $column, $indexKey);
    }


    public function toArray()
    {
        return $this->dashboards;
    }


    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->dashboards);
    }



    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_has($this->dashboards, $offset);
    }


    /**
     * @param mixed $offset
     *
     * @return null
     */
    public function offsetGet($offset)
    {
        return array_get($this->dashboards, $offset, []);
    }


    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return $this
     */
    public function offsetSet($offset, $value)
    {
        array_set($this->dashboards, $offset, $value);

        return $this;
    }


    /**
     * @param mixed $offset
     *
     * @return $this
     */
    public function offsetUnset($offset)
    {
        array_forget($this->dashboards, $offset);

        return $this;
    }
}