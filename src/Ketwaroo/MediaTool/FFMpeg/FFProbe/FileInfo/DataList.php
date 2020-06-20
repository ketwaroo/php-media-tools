<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of List
 *
 * @author Yaasir Ketwaroo<ketwaroo.yaasir@gmail.com>
 */
abstract class DataList  implements \ArrayAccess, \Iterator, \Countable
{
    
    protected $data=[];

   protected function filterBy($getter, $filter, $getterParams = [])
    {
        $match = [];
        foreach ($this->data as $s)
        {
            if (method_exists($s, $getter))
            {
                $value = call_user_func_array([$s, $getter], $getterParams);
            }
            else
            {
                $value = $s->{$getter}; // __get will return null if not exists.
            }

            if (
                (is_object($s) && $value == $filter)
                || (is_string($value) && fnmatch($filter, $value))
                || ($value === $filter)
            )
            {
                $match[] = $s;
            }
        }

        return new static($match);
    }

    /**
     * 
     * @return static
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * 
     * @return static
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * 
     * @return static
     */
    public function next()
    {
        return next($this->data);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function rewind()
    {
        reset($this->data);
    }

    public function valid()
    {
        return $this->offsetExists($this->key());
    }

    public function count()
    {
        return count($this->data);
    }
}
