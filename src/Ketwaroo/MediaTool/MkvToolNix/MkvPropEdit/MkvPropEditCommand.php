<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvPropEdit;

use Ketwaroo\ExternalCommand\Command;
use Ketwaroo\MediaTool\MkvToolNix\MkvPropEdit\EditOptionGroup;

/**
 * Description of MkvPropEditCommand
 *
 * @author Yaasir Ketwaroo
 */
class MkvPropEditCommand extends Command
{

    protected $editOptioGroups = [];
    protected $file;

    protected function getCommand()
    {
        return 'mkvpropedit';
    }

    protected function setupDefaults()
    {
        
    }

    function getFile()
    {
        return $this->file;
    }

    function setFile($file)
    {
        $this->file = $file;
    }

    protected function getCommandStringFormatter()
    {
        return '{command}{options}{joiner}{file}{edit_options}{piped_commands}';
    }

    protected function getCommandStringTranslationMap()
    {
        return array_merge(
            parent::getCommandStringTranslationMap()
            , [
            '{file}'         => $this->escapeShellArg($this->getFile()),
            '{edit_options}' => implode('', $this->editOptioGroups),
        ]);
    }

    /**
     * 
     * @param string $selector
     * @return EditOptionGroup
     */
    public function addEditOptionGroup($selector)
    {
        $name = "edit-{$selector}";
        $opt  = new EditOptionGroup($name);
        $opt->setDefaultOptionJoiner(' ')
            ->setDefaultOptionPrefix('--')
            ->setJoiner(' ')
            ->setRequiredOptions([])
            ->setGroupJoin($this->getJoiner())
            ->setEdit($selector);


        $this->editOptioGroups[$name] = $opt;

        return $opt;
    }

}
