<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of StreamAudio
 *
 * @author Yaasir Ketwaroo
 */
class StreamAudio extends Stream
{

    public function getSampleRate()
    {
        return $this->sample_rate;
    }

    public function getChannels()
    {
        return $this->channels;
    }

}
