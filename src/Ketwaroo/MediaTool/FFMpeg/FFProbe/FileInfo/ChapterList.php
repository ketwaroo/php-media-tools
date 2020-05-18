<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of ChapterList
 *
 * @author Yaasir Ketwaroo
 */
class ChapterList extends DataList
{


    public function __construct(array $chapters)
    {
        foreach ($chapters as $s)
        {
            if ($s instanceof ChapterList)
            {
                $this->data[] = $s;
            }
        }
    }
    
    public function  findByTitle($title)
    {
        return $this->filterBy('getTitle', $title);
    }

}
