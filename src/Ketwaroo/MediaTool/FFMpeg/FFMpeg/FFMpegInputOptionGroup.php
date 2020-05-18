<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFMpeg;
use Ketwaroo\ExternalCommand\OptionGroup;
/**
 * Description of FFMpegInputOptionGroup
 *
 * @author Yaasir Ketwaroo
 */
class FFMpegInputOptionGroup extends OptionGroup
{
    protected $inputFile;
    
    public function buildOptionGroupString()
    {
        $this->addOption('i',$this->getInputFile());
        return parent::buildOptionGroupString();
    }
    
    public function getInputFile()
    {
        return $this->inputFile;
    }

    public function setInputFile($inputFile)
    {
        $this->inputFile = $inputFile;
        return $this;
    }


}
