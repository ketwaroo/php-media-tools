<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFMpeg;

use Ketwaroo\MediaTool\FFMpeg\FFMpeg;

/**
 * Description of ExtractAudio
 *
 * @author Yaasir Ketwaroo
 */
class ExtractAudioCommand extends FFMpegCommand
{

    /**
     * 
     * Formula:
     *  {CH} - out channel number placeholder.
     *  {LR} - in channel L or R.
     */
    const formula_downmix_stereo              = 'c{CH}=1.25*FC+1.0*F{LR}+1.0*B{LR}+0.33LFE';
    const formula_downmix_stereo_experimental = 'c{CH}=1.5*FC+BC+TC+TFC+TBC+1.5*F{LR}+B{LR}+S{LR}+TF{LR}+TB{LR}+D{LR}+W{LR}+0.25*LFE';

    protected function setupDefaults()
    {
        parent::setupDefaults();

        $this->disableVideoStreams()
            ->disableSubtitleStreams();
    }

    public function usePcmWavFormatOutput()
    {
        $this->setOutputFormat('wav')
            ->setAudioCodec(FFMpeg::codec_audio_pcm);
        return $this;
    }

    /**
     * 
     * Formula:
     *  {CH} - out channel number placeholder.
     *  {LR} - in channel L or R.
     * 
     * @param string $formula
     * @return \Ketwaroo\MediaTool\FFMpeg\FFMpeg\ExtractAudioCommand
     */
    public function addAudioFilterDownmixToStereo($formula = self::formula_downmix_stereo)
    {

        $opts = [
            'stereo',
        ];

        foreach ([0 => 'L', 1 => 'R'] as $ch => $lr)
        {
            $opts[] = strtr($formula, [
                '{CH}' => $ch,
                '{LR}' => $lr,
            ]);
        }

        $this->addAudioFilter('pan', implode('|', $opts));

        return $this;
    }

}
