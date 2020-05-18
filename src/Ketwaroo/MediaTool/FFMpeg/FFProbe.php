<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg;

use Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;
use Ketwaroo\ExternalCommand\CommandGroup;

/**
 * Description of FFProbe
 *
 * @author Yaasir Ketwaroo
 */
class FFProbe extends CommandGroup
{

    /**
     * 
     * @return FileInfo
     */
    public function getFileInfo($filename)
    {
        /* @var $i FFProbe\InfoCommand */
        $i   = $this->newCommand('Info');
        /* @var $out \Ketwaroo\ExternalCommand\Output */
        $out = $i->setFileName($filename)
            ->execute()
            ->getOutput();

        if (0 === $out->getExitCode())
        {

            return new FileInfo($out);
        }
        else
        {
            throw new \Exception("Error code " . $out->getExitCode()
            . "\nCommand: " . $out->getCommand()
            . "\nData: " . $out->getOutputString());
        }
    }

}
