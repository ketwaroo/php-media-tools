<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvPropEdit;

use Ketwaroo\ExternalCommand\OptionGroup;

/**
 * Description of EditOptionGroup
 *
 * @author Yaasir Ketwaroo
 */
class EditOptionGroup extends OptionGroup
{

    public function setEdit($selector)
    {
        return $this->addOption('edit', $selector);
    }

    public function setEditTrack($selector)
    {
        return $this->addOption('edit', 'tracl:' . $selector);
    }

    public function addFlag($flagName, $value)
    {
        return $this->addRepeatableOption('add', "{$flagName}=$value");
    }

    public function setFlag($flagName, $value)
    {
        return $this->addRepeatableOption('set', "{$flagName}=$value");
    }

    public function deleteFlag($flagName)
    {
        return $this->addRepeatableOption('delete', "{$flagName}");
    }

}
