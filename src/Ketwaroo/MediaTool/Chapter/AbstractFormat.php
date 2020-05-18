<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Chapter;

/**
 * Description of Format
 *
 * @author Yaasir Ketwaroo
 */
abstract class AbstractFormat
{

    abstract public function render(ChapterList $chapter);

    public function renderFile($filename, ChapterList $chapter)
    {
        file_put_contents($filename, $this->render($chapter));
        return $this;
    }

}
