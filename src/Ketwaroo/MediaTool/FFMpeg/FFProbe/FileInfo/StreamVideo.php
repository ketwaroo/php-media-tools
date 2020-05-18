<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of StreamVideo
 *
 * @author Yaasir Ketwaroo
 */
class StreamVideo extends Stream
{

    public function getWidthXheight($x = 'x')
    {
        return $this->getWidth() . $x . $this->getHeight();
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getAverageFrameRate()
    {
        return $this->avg_frame_rate;
    }

    /**
     * 
     * @return float
     */
    public function getFramerate()
    {
        list($num, $dem) = explode('/', $this->getAverageFrameRate());
        return round(intval($num) / intval($dem), 3);
    }
    
    public function getPixelFormat()
    {
        return $this->pix_fmt;
    }
    
    public function getBitsPerPixel()
    {
        return $this->bits_per_raw_sample;
    }

}
