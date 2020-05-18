<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of Chapter
 *
 * @author Yaasir Ketwaroo
 */
class Chapter extends Data
{

    public function getId()
    {
        return $this->id;
    }

//                "id": 2078178978,
//            "time_base": "1/1000000000",
//            "start": 843926000000,
//            "start_time": "843.926000",
//            "end": 1356000000000,
//            "end_time": "1356.000000",
//            "tags": {
//                "title": "Part 2"
//            }
    public function getStartMicroSeconds()
    {
        return $this->start;
    }

    public function getEndMicroSeconds()
    {
        return $this->end;
    }

    public function getStartTime()
    {
        return $this->start_time;
    }

    public function getEndTime()
    {
        return $this->end_time;
    }

    public function getTitle()
    {
        return isset($this->tags['title']) ? $this->tags['title'] : static::label_unnamed;
    }

}
