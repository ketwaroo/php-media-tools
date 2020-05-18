<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Video;

use Ketwaroo\ExternalCommand\CommandGroup;


/**
 * Description of x265
 *
 * @todo Most of the option setters are generated from parsing online documentation.
 *          need to correct in some cases.
 * @todo add remove opt
 * @author Yaasir Ketwaroo
 */
class X265  extends CommandGroup
{

    /**
     * 
     * @return X265\EncodeCommand
     */
    public function newEncodeCommand()
    {
        return $this->newCommand('Encode');
    }
    
    public function getCliVersion()
    {
        return $this->executeCommand('Version')->getOutputString();
    }

}
