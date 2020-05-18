<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\MkvToolNix\MkvMerge;

use Ketwaroo\ExternalCommand\OptionGroup;

/**
 * Description of InputOptionGroup
 *
 * @author Yaasir Ketwaroo
 */
class InputOptionGroup extends OptionGroup
{

    protected $inputFile;

    public function buildOptionGroupString()
    {

        return parent::buildOptionGroupString() . $this->getJoiner() . $this->getInputFile();
    }

    protected function getInputFile()
    {
        return $this->escapeShellArg($this->inputFile);
    }

    public function setInputFile($inputFile)
    {
        $this->inputFile = $inputFile;
        return $this;
    }

    /**
     * 
     * @return static
     */
    public function disableVideo()
    {
        return $this->addOptionWithNoValue('no-video');
    }

    /**
     * 
     * @return static
     */
    public function disableAudio()
    {
        return $this->addOptionWithNoValue('no-audio');
    }

    /**
     * 
     * @return static
     */
    public function disableSubtitles()
    {
        return $this->addOptionWithNoValue('no-subtitles');
    }

    /**
     * 
     * @return static
     */
    public function disableButtons()
    {
        return $this->addOptionWithNoValue('no-subtitles');
    }

    /**
     * 
     * @return static
     */
    public function disableTrackTags()
    {
        return $this->addOptionWithNoValue('no-track-tags');
    }

    /**
     * 
     * @return static
     */
    public function disableChapters()
    {
        return $this->addOptionWithNoValue('no-chapterss');
    }

    /**
     * 
     * @return static
     */
    public function disableGlobalTags()
    {
        return $this->addOptionWithNoValue('no-global-tags');
    }

    /**
     * 
     * @param int $trackId
     * @param bool $flag
     * @return static
     */
    public function setDefaultTrack($trackId = 0, $flag = null)
    {
        $value = $trackId . ((null === $flag) ? '' : (':' . ($flag ? 'true' : 'false')));

        return $this->addOption('default-track', $value);
    }

    /**
     * 
     * @param string $language ISO639-2 or ISO639-1
     * @param int $trackId
     * @return static
     */
    public function setLanguage($language, $trackId = 0)
    {
        return $this->addOption('language', "{$trackId}:{$language}");
    }
    
    /**
     * 
     * @param string $name
     * @param int $trackId
     * @return static
     */
    public function setTrackName($name, $trackId = 0)
    {
        return $this->addOption('track-name', "{$trackId}:{$name}");
    }

}
