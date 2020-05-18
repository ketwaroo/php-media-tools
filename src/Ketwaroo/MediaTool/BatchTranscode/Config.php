<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\BatchTranscode;

/**
 * Description of TraitWithConfig
 *
 * @author Yaasir Ketwaroo
 */
abstract class Config
{
    
    protected $matcher;
    protected $config = [];

    public function getConfig($label, $default = NULL)
    {
        return isset($this->config[$label]) ? $this->config[$label] : $default;
    }

    public function setConfig($label, $value)
    {
        $this->config[$label] = $value;
        return $this;
    }

    public function unsetConfig($label)
    {
        unset($this->config[$label]);
        return $this;
    }

}
