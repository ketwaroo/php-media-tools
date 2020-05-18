<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Subtitle\Format;

use Ketwaroo\MediaTool\Subtitle\AbstractFormat;
use Ketwaroo\MediaTool\Subtitle\Script;
use Ketwaroo\MediaTool\MediaTimestamp;

/**
 * Description of Srt
 *
 * @author Yaasir Ketwaroo
 */
class Srt extends AbstractFormat
{

    const EOL   = "\r\n";
    const ARROW = " --> ";

    public function render(Script $script)
    {
        $render = '';
        $i      = 1;
        foreach ($script as $line)
        {
            /* @var $line \Ketwaroo\MediaTool\Subtitle\Line */

            $render .= $i
                . static::EOL
                . $this->formatTimestamp($line->getStart())
                . static::ARROW
                . $this->formatTimestamp($line->getEnd())
                . static::EOL
                . $line->getText()
                . static::EOL 
                . static::EOL;
            $i++;
        }
        return mb_convert_encoding($render, "UTF-8", "auto");
    }

    protected function formatTimestamp(MediaTimestamp $t)
    {
        return str_replace('.', ',', strval($t));
    }

}
