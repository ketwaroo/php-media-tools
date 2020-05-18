<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvMerge;

use Ketwaroo\ExternalCommand\Command;

/**
 * Description of MkvMergeCommand
 *
 * @author Yaasir Ketwaroo
 */
class MkvMergeCommand extends Command
{

    const global_options = 'global';

    protected $inputFileOptionGroups = [];

    protected function getCommand()
    {
        return 'mkvmerge';
    }

    protected function setupDefaults()
    {
        $this->addOptionGroup(static::global_options);
    }

    protected function getCommandStringFormatter()
    {
        return '{command}{global_options}{input_options}{piped_commands}';
    }

    protected function getCommandStringTranslationMap()
    {
        return array_merge(
            parent::getCommandStringTranslationMap()
            , [
            '{global_options}' => $this->getGlobalOptionGroup(),
            '{input_options}'  => implode($this->getJoiner(),$this->inputFileOptionGroups),
        ]);
    }

    public function addInputFileOptionGroup($name, $inputFile)
    {
        $opt = new InputOptionGroup($name);
        $opt->setDefaultOptionJoiner(' ')
            ->setDefaultOptionPrefix('--')
            ->setJoiner(' ')
            ->setRequiredOptions([])
            ->setGroupJoin($this->getJoiner())
            ->setInputFile($inputFile);


        $this->inputFileOptionGroups[$name] = $opt;

        return $opt;
    }

    public function getGlobalOptionGroup()
    {
        return $this->getOptionGroup(static::global_options);
    }



}
