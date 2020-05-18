<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Video\X265\Preset;

use Ketwaroo\ExternalCommand\CommandPreset;

/**
 * Description of AnimePreset
 *
 * @author Yaasir Ketwaroo
 */
class AnimePreset extends CommandPreset
{

    protected function applyPreset()
    {
        /* @var $cmd \Ketwaroo\MediaTool\Video\X265\EncodeCommand */
        $cmd = $this->getCommand();

        $cmd
            ->setOptPreset('medium')
            ->setOptKeyint(240)
            ->setOptMinKeyint(0)
            ->setOptMerange(48) //56
            ->setOptMe(1)
            ->setOptSubme(2)
            ->setOptRd(3)
            ->setOptRcLookahead(25)
            ->setOptBframes(5)
            ->setOptRef(4)
            //->setOptBframeBias(50) // high values can cause crashes?
            ->setOptToggleScenecut(66)
            ->setOptQcomp(0.85) //0.79. high values can cause blockiness on extreme high motion clips
            ->setOptAqMode(1)
            ->setOptAqStrength(0.6)
            ->setOptPsyRd(0.0)
            ->setOptToggleWeightb(true)
            ->setOptToggleWeightp(true)            
            ->setOptToggleStrongIntraSmoothing(false)
            //->setOptToggleTskip(true)
            //->setOptToggleTskipFast(true)
            //->setOptToggleAmp(true)
            //->setOptToggleRect(true)
            // ->setOptToggleLimitModes(true)
            ->setOptToggleDeblock('-3:-3')
           // ->setOptToggleSlowFirstpass(true)
            ->setOptLookaheadSlices(0)
        ;
    }

}
