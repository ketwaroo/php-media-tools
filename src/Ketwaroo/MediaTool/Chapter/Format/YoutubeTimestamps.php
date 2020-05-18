<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Chapter\Format;

use Ketwaroo\MediaTool\Chapter\ChapterList;
use Ketwaroo\MediaTool\Chapter\Entry;
use Ketwaroo\MediaTool\MediaTimestamp;

/**
 * Description of YoutubeTimestamps
 *
 * @author Yaasir Ketwaroo
 */
class YoutubeTimestamps extends MkvSimple
{

    public function render(ChapterList $chapter)
    {
        $r = [];

        foreach ($chapter as $k => $entry)
        {
            /* @var $entry Entry */

            $r[] = ' *' . $this->makeYoutubeTimestamp($entry->getTimestamp()) . "\t"
                . ' ' . $this->sanitiseTitle($entry->getTitle());
        }

        return implode(PHP_EOL, $r);
    }

    protected function makeYoutubeTimestamp(MediaTimestamp $timestamp)
    {
        $x = array_filter([
            empty($timestamp->getHour()) ? null : str_pad('' . $timestamp->getHour(), 2, '0', STR_PAD_LEFT),
            str_pad('' . $timestamp->getMinute(), 2, '0', STR_PAD_LEFT),
            str_pad('' . $timestamp->getSecond(), 2, '0', STR_PAD_LEFT),
        ]);

        return str_pad(implode(':', $x), 13, ' ', STR_PAD_LEFT);
    }

}
