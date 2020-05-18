<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo;

/**
 * Description of StreamList
 *
 * @author Yaasir Ketwaroo
 */
class StreamList extends DataList
{


    public function __construct(array $streams)
    {
        foreach ($streams as $s)
        {
            if ($s instanceof Stream)
            {
                $this->data[] = $s;
            }
        }
    }

    /**
     * 
     * @return static
     */
    public function findVideoStreams()
    {
        return $this->filterBy('getType', 'video');
    }

    /**
     * 
     * @return static
     */
    public function findAudioStreams()
    {
        return $this->filterBy('getType', 'audio');
    }

    /**
     * 
     * @return static
     */
    public function findSubtitles()
    {
        return $this->filterBy('getType', 'subtitle');
    }

    /**
     * 
     * @return static
     */
    public function findAttachments()
    {
        return $this->filterBy('getType', 'attachment');
    }

    /**
     * 
     * @return static
     */
    public function findByIndex($index)
    {
        return $this->filterBy('getIndex', $index);
    }

    /**
     * 
     * @return static
     */
    public function findByLanguage($lang)
    {
        return $this->filterBy('getLanguage', $lang);
    }

  }
