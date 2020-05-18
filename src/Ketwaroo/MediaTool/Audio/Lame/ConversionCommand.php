<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Audio\Lame;

/**
 * Description of ConversionCommand
 *
 * @author Yaasir Ketwaroo
 */
class ConversionCommand extends LameCommand
{

    /**
     * 
     * @param bool|int $toggle false to disable, int to set interval.
     * @return \Ketwaroo\MediaTool\Audio\Lame\ConversionCommand
     */
    public function showProgress($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOption('disptime', max(1, intval($toggle)));
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->removeOption('disptime');
        }

        return $this;
    }

}
