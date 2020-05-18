<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix;

use Ketwaroo\ExternalCommand\CommandGroup;

/**
 * Description of MkvMerge
 *
 * @author Yaasir Ketwaroo
 */
class MkvMerge extends CommandGroup
{

    /**
     * 
     * @return MkvMerge\MergeCommand
     */
    public function newMergeCommand()
    {
        return $this->newCommand('Merge');
    }

    /**
     * 
     * @param string $filename
     * @return MkvMerge\Identify
     */
    public function indentify($filename)
    {
        $id = $this->getCommand('Identify');

        return $id->identify($filename);
    }

}
