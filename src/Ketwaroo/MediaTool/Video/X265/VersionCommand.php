<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Video\X265;

use Ketwaroo\ExternalCommand\Command;

/**
 * Description of CommandVersion
 *
 * @author Yaasir Ketwaroo
 */
class VersionCommand extends Command
{

    protected function getCommand()
    {
        return 'x265';
    }

    protected function setupDefaults()
    {
        $this->getDefaultOptionGroup()->addOptionWithNoValue('version');
        return $this;
    }

}
