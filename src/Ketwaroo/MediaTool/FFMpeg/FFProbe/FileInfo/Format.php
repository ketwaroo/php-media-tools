<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of FileInfoFormat
 *
 * @author Yaasir Ketwaroo
 */
class Format extends Data
{

    public function getFilename()
    {
        return $this->filename;
    }

    public function getNumberOfStreams()
    {
        return intval($this->nb_streams);
    }

    public function getFormatName()
    {
        return $this->format_name;
    }

    public function getFormatLongName()
    {
        return $this->format_long_name;
    }

    public function getStartTime()
    {
        return $this->start_time;
    }

    public function getDuration()
    {
        return floatval($this->duration);
    }

    public function getSize()
    {
        return intval($this->size);
    }

    public function getBitRate()
    {
        return intval($this->bit_rate);
    }

}
