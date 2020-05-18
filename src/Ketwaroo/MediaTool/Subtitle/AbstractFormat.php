<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Subtitle;

/**
 * Description of Format
 *
 * @author Yaasir Ketwaroo
 */
abstract class AbstractFormat
{
    abstract public function render(Script $script);
}
