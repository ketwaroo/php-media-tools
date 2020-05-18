<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Video\X265\Preset;

use Ketwaroo\ExternalCommand\CommandPreset;

/**
 * Description of SecondPassPreset
 *
 * @author Yaasir Ketwaroo
 */
class SecondPassPreset extends CommandPreset
{

    protected function applyPreset()
    {
        /* @var $cmd \Ketwaroo\MediaTool\Video\X265\EncodeCommand */
        $cmd = $this->getCommand();

        $cmd->setOptPass(2);
    }

}
