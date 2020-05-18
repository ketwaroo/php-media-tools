<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Audio\Lame\Preset;

use Ketwaroo\ExternalCommand\CommandPreset;

/**
 * Description of Hq44K80Kbps
 *
 * @author Yaasir Ketwaroo
 */
class Hq44K96KbpsPreset extends CommandPreset
{

    protected function applyPreset()
    {
        $this->command->getDefaultOptionGroup()
            ->addOption('q', 0, '-') //highest quality
            ->addOption('V', 0, '-') //hq vbr
            ->addOption('b', 8, '-') //8 kbps min
            ->addOption('B', 96, '-') //96 kbps max
            ->addOption('resample', '44.1', '--') //44.1Khz
        ;
    }

}
