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
 * @author Yaasir Ketwaroo
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
    public function current():mixed
    {
        return current($this->data);
    }

    /**
     * 
     * @return static
     */
    public function key():mixed
    {
        return key($this->data);
    }

    /**
     * 
     * @return static
     */
    public function next():void
    {
        next($this->data);
    }

	public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset):mixed
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value):void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset):void
    {
        unset($this->data[$offset]);
    }

    public function rewind():void
    {
        reset($this->data);
    }

    public function valid():bool
    {
        return $this->offsetExists($this->key());
    }

    public function count():int
    {
        return count($this->data);
    }
}
