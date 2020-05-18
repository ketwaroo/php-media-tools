<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Audio\Lame;

/**
 * Description of VersionCOmmand
 *
 * @author Yaasir Ketwaroo
 */
class VersionCommand extends LameCommand
{

    protected function setupDefaults()
    {
        $this->getDefaultOptionGroup()
            ->addOptionWithNoValue('version');
    }

}
