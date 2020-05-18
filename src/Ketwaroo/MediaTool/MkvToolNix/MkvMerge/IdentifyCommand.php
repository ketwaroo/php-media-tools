<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvMerge;

use Ketwaroo\ExternalCommand\Command;

/**
 * Description of IdentifyCommand
 *
 * @author Yaasir Ketwaroo
 */
class IdentifyCommand extends Command
{

    protected function setupDefaults()
    {
        $this->getDefaultOptionGroup()
            ->addOption('identification-format', 'json');
    }

    /**
     * 
     * @param string $filename
     * @return \Ketwaroo\MediaTool\MkvToolNix\MkvMerge\Identify
     */
    public function identify($filename)
    {
        $this->getDefaultOptionGroup()->addOption('identify', $filename);

        $data = json_decode($this->execute()->getOutput()->getOutputString(), true);

        if (null === $data)
        {
            throw new \InvalidArgumentException('indentify format incorrect.');
        }
        return new Identify($data);
    }

    protected function getCommand()
    {
        return 'mkvmerge';
    }

}
