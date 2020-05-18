<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Audio\Lame;

use Ketwaroo\ExternalCommand\Command;

/**
 * Description of LameCommand
 *
 * @author Yaasir Ketwaroo
 */
class LameCommand extends Command
{

    protected $inputFile;
    protected $outputFile;

    protected function getCommand()
    {
        return 'lame';
    }

    protected function setupDefaults()
    {
        
    }

    protected function getCommandStringFormatter()
    {
        return '{command}{options}{joiner}{input}{joiner}{output}{piped_commands}';
    }

    protected function getCommandStringTranslationMap()
    {
        return array_merge(
            [
            '{input}'  => $this->getInputFile(),
            '{output}' => $this->getOutputFile(),
            ]
            , parent::getCommandStringTranslationMap()
        );
    }

    protected function getInputFile()
    {
        return $this->inputFile === static::piped_inout ? static::piped_inout : $this->escapeShellArg($this->inputFile);
    }

    protected function getOutputFile()
    {
        return $this->outputFile === static::piped_inout ? static::piped_inout : $this->escapeShellArg($this->outputFile);
    }

    public function setInputFile($inputFile)
    {
        $this->inputFile = $inputFile;
        return $this;
    }

    public function setOutputFile($outputFile)
    {
        $this->outputFile = $outputFile;
        return $this;
    }

}
