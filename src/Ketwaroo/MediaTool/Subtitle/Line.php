<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Subtitle;

use Ketwaroo\MediaTool\MediaTimestamp;

/**
 * Description of Line
 *
 * @author Yaasir Ketwaroo
 */
class Line
{

    protected $start, $end, $text;

    public function __construct(MediaTimestamp $start, MediaTimestamp $end, $text)
    {
        $this->start = $start;
        $this->end   = $end;
        $this->text  = $text;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getText()
    {
        return $this->text;
    }

}
