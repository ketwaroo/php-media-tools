<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Chapter;

use Ketwaroo\MediaTool\MediaTimestamp;

/**
 * Description of List
 *
 * @author Yaasir Ketwaroo
 */
class ChapterList implements \ArrayAccess, \Iterator, \Countable, \Serializable
{

    use \Ketwaroo\Pattern\TraitImplementsArray;

    /**
     *
     * @var \ArrayIterator
     */
    protected $entries;

    public function __construct()
    {
        $this->entries = new \ArrayIterator(array());
    }

    public function addChapter($title, MediaTimestamp $timestamp)
    {

        $this->getIterator()->append(new Entry($title, $timestamp));
    }

    public function render(AbstractFormat $format, $file = null)
    {
        $rendered = $format->render($this);
        if (empty($file))
        {
            return $rendered;
        }
        return file_put_contents($file, $rendered);
    }

    public function getIterator()
    {
        return $this->entries;
    }

    public function serialize(): string
    {
        
    }

    public function unserialize(string $serialized): void
    {
        
    }

}
