<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvMerge;

/**
 * Description of MergeCommand
 *
 * @author Yaasir Ketwaroo
 */
class MergeCommand extends MkvMergeCommand
{

    protected function setupDefaults()
    {
        parent::setupDefaults();
        $this->getGlobalOptionGroup()
            ->setRequiredOptions(['output']);
    }

    /**
     * 
     * @param type $filename
     * @return static
     */
    public function setOutputFile($filename)
    {
        $this->getGlobalOptionGroup()
            ->addOption('output', $filename);
        return $this;
    }

}
