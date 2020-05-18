<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe;

use Ketwaroo\ExternalCommand\Command;

/**
 * Description of InfoCommand
 *
 * @author Yaasir Ketwaroo
 */
class InfoCommand extends Command
{

    protected $fileName;

    protected function getCommand()
    {
        return 'ffprobe';
    }

    protected function setupDefaults()
    {
        $this->addOptionGroup(static::DEFAULT_INPUT_GROUP_NAME, [], '-', ' ', ' ')
            ->addOption('loglevel', 'fatal')
            ->addOption('of', 'json')
            //->addOptionWithNoValue('count_frames')
            ->addOptionWithNoValue('show_format')
            ->addOptionWithNoValue('show_streams');
    }

    /**
     * 
     * @param type $filename
     * @return \Ketwaroo\MediaTool\FFMpeg\FFProbe\InfoCommand
     */
    public function setFileName($filename)
    {
        $this->fileName = $filename;
        return $this;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * 
     * @return static
     * @throws \InvalidArgumentException
     */
    public function execute()
    {
        if (!is_readable($this->getFileName()))
        {
            throw new \InvalidArgumentException('An input file is required. use setFileName().');
        }
        return parent::execute();
    }

    protected function getCommandStringFormatter()
    {
        return '{command}{joiner}{filename}{options}{piped_commands}';
    }

    protected function getCommandStringTranslationMap()
    {
        return array_merge(
            [
            '{filename}' => $this->escapeShellArg($this->getFileName())
            ]
            , parent::getCommandStringTranslationMap()
        );
    }

}
