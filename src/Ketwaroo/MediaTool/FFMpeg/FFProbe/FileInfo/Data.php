<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of Data
 *
 * @author Yaasir Ketwaroo
 */
abstract class Data
{

    const lang_undefined = 'und';
    const label_unnamed = '{unnamed}';

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

}
