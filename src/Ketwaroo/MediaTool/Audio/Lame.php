<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Audio;
use Ketwaroo\ExternalCommand\CommandGroup;

/**
 * Description of Lame
 *
 * @author Yaasir Ketwaroo
 */
class Lame extends CommandGroup
{
    public function getCliVersion()
    {
        return $this->executeCommand('Version')
            ->getOutputString();
    }
    /**
     * 
     * @return Lame\ConversionCommand
     */
    public function getConversionCommand()
    {
        return $this->newCommand('Conversion');
    }
}
