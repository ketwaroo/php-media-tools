<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Chapter\Format;

use Ketwaroo\MediaTool\Chapter\AbstractFormat;
use Ketwaroo\MediaTool\Chapter\ChapterList;
use Ketwaroo\MediaTool\Chapter\Entry;
use Ketwaroo\Text;

/**
 * Description of MkvSimple
 *
 * @author Yaasir Ketwaroo
 */
class MkvSimple extends AbstractFormat
{

    public function render(ChapterList $chapter)
    {
        $r = [];

        foreach ($chapter as $k => $entry)
        {
            /* @var $entry Entry */

            $idxStr = str_pad($k + 1, 2, '0', STR_PAD_LEFT);

            $r[] = 'CHAPTER' . $idxStr . '=' . $entry->getTimestamp();
            $r[] = 'CHAPTER' . $idxStr . 'NAME=' . $this->sanitiseTitle($entry->getTitle());
        }

        return implode(PHP_EOL, $r);
    }

    protected function sanitiseTitle($title)
    {
        $rep = [
            '~<(div|h[1-6]|p)[^>]*?>(.*?)</\1>~s' => '|$2|',
            '~<br ?/?>~'                          => '|',
            '~[\t\r\n ]+~'                        => ' ',
        ];



        return implode('; ', array_filter(explode('|', trim(preg_replace(array_keys($rep), array_values($rep), $title)))));
    }

}
