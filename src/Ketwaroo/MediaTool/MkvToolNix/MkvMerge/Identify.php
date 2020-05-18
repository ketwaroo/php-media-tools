<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvMerge;

/**
 * Description of Identify
 *
 * @author Yaasir Ketwaroo
 */
class Identify
{

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Remaps the track number to the mkvmerge specific track id.
     * 
     * @param type $trackNumber
     * @return int|boolean track Id from track number or false if not found
     */
    public function mapTrackNumberToId($trackNumber)
    {
        if (empty($this->data['tracks']))
        {
            return false;
        }

        foreach (array_keys($this->data['tracks']) as $i)
        {

            if (!empty($this->data['tracks'][$i]['properties'])
                && intval($trackNumber) === intval($this->data['tracks'][$i]['properties']['number']))
            {
                return intval($this->data['tracks'][$i]['id']);
            }
        }

        return false;
    }

}
