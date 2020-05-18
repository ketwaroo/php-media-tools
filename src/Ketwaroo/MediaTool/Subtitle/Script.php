<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Subtitle;

use Ketwaroo\MediaTool\MediaTimestamp;

/**
 * Description of Script
 *
 * @author Yaasir Ketwaroo
 */
class Script implements \ArrayAccess, \Iterator, \Countable
{

    use \Ketwaroo\Pattern\TraitImplementsArray;

    protected $lines;

    public function __construct()
    {
        $this->lines = new \ArrayIterator(array());
    }

    /**
     * 
     * @param MediaTimestamp $start
     * @param MediaTimestamp $end
     * @param string $text
     * @return static
     */
    public function createLine(MediaTimestamp $start, MediaTimestamp $end, $text)
    {
        $this->getIterator()->append(new Line($start, $end, $text));
        return $this;
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
        return $this->lines;
    }

}
