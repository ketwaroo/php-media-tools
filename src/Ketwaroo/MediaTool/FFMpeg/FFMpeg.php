<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg;

use Ketwaroo\ExternalCommand\CommandGroup;

/**
 * Description of FFMpeg
 *
 * @author Yaasir Ketwaroo
 */
class FFMpeg extends CommandGroup
{


    const pixfmt_yuv420p      = 'yuv420p';
    const pixfmt_yuv420p10le  = 'yuv420p10le';
    const outfmt_yuv4mpegpipe = 'yuv4mpegpipe';
    const outfmt_rawvideo     = 'rawvideo';
    const codec_audio_pcm     = 'pcm_s16le';

    /**
     * 
     * @return FFMpeg\ExtractAudioCommand
     */
    public function getExtractAudioCommand()
    {
        return $this->newCommand('ExtractAudio');
    }

    /**
     * 
     * @return FFMpeg\ExtractVideoCommand
     */
    public function getExtractVideoCommand()
    {
        return $this->newCommand('ExtractVideo');
    }

}
