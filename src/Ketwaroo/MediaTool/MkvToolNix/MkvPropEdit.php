<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix;
use Ketwaroo\ExternalCommand\CommandGroup;
/**
 * Description of MkvPropEdit
 *
 * @author Yaasir Ketwaroo
 */
class MkvPropEdit extends CommandGroup
{
    /**
     * 
     * @param string $file
     * @return MkvPropEdit\MkvPropEditCommand
     */
    public function newPropEditCommand($file)
    {
        /* @var $cmd MkvPropEdit\MkvPropEditCommand */
        $cmd = $this->newCommand('MkvPropEdit');
        $cmd->setFile($file);
        
        return $cmd;
    }
}
