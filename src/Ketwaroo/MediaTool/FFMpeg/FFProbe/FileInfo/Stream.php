<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of Stream
 *
 * @author Yaasir Ketwaroo
 */
abstract class Stream extends Data
{

    public function getIndex()
    {
        return $this->index;
    }

    public function getCodecName()
    {
        return $this->codec_name;
    }

    public function getCodecLongName()
    {
        return $this->codec_long_name;
    }

    public function getType()
    {
        return $this->codec_type;
    }

    public function getCodecTagSting()
    {
        return $this->codec_tag_string;
    }

    public function getCodecTag()
    {
        return $this->codec_tag;
    }

    public function getTags()
    {
        return empty($this->data['tags']) ? [] : $this->data['tags'];
    }

    public function getDisposition()
    {
        return empty($this->data['disposition']) ? [] : $this->data['disposition'];
    }

    public function getLanguage()
    {
        $tags = $this->getTags();
        return isset($tags['language']) ? $tags['language'] : static::lang_undefined;
    }

    public function getTitle()
    {
        $tags = $this->getTags();
        return isset($tags['title']) ? $tags['title'] : '';
    }

    /**
     * 
     * @return boolean
     */
    public function getIsDefault()
    {
        $disposition = $this->getDisposition();
        return isset($disposition['default']) ? boolval($disposition['default']) : false;
    }

}
