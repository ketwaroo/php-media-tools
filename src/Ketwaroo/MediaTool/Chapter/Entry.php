<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Chapter;

use Ketwaroo\MediaTool\MediaTimestamp;

/**
 * Description of Entry
 *
 * @author Yaasir Ketwaroo
 */
class Entry implements \Serializable
{

    protected $title;
    protected $timestamp;

    public function __construct($title, MediaTimestamp $timestamp)
    {
        $this->setTimestamp($timestamp)
            ->setTitle($title);
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setTimestamp(MediaTimestamp $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 
     * @return MediaTimestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    
    public function serialize(): string
    {
        
    }

    public function unserialize(string $serialized): void
    {
        
    }


}
