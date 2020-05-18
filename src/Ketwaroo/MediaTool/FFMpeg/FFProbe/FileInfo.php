<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFProbe;

use Ketwaroo\ExternalCommand\Output;
use Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo\ChapterList;
use Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo\Chapter;
use Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo\StreamList;
use Ketwaroo\MediaTool\FFMpeg\FFProbe\FileInfo\Format;

/**
 * Description of FileInfo
 *
 * @author Yaasir Ketwaroo
 */
class FileInfo
{

    protected $originalOutput;
    protected $fileinfo = [];

    /**
     *  @var Format
     */
    protected $format;

    /**
     * @var StreamList 
     */
    protected $streams;

    /**
     * @var ChapterList 
     */
    protected $chapters;

    public function __construct(Output $probeOutput)
    {
        $this->originalOutput = $probeOutput;

        if (0 === $probeOutput->getExitCode())
        {
            $rep = [
                '~^(?:Unsupported codec with id \d+ for input stream \d+\n)+~' => '',
            ];
            $out = preg_replace(array_keys($rep), array_values($rep), $probeOutput->getOutputString());

            $this->fileinfo = json_decode(trim($out), true);
            $this->parseFileInfo();
        }
        else
        {
            throw new \InvalidArgumentException('Output has error code', $probeOutput->getExitCode());
        }
    }

    protected function parseFileInfo()
    {
        $this->format = new Format($this->fileinfo['format']);
        $streams      = [];
        foreach ($this->fileinfo['streams'] as $sdata)
        {
            $cls = __CLASS__ . '\\Stream' . ucfirst($sdata['codec_type']);

            if (!class_exists($cls))
            {
                $cls = __CLASS__ . '\\StreamGeneric';
            }
            $streams[] = new $cls($sdata);
        }

        $this->streams = new StreamList($streams);

        $chapters = [];
        foreach ($chapters as $c)
        {
            $chapters[] = new Chapter($c);
        }
        $this->chapters = new ChapterList($chapters);
    }

    /**
     * 
     * @return StreamList
     */
    public function getStreams()
    {
        return $this->streams;
    }

    /**
     * 
     * @return FileInfo\ChapterList
     */
    public function getChapters()
    {
        return $this->streams;
    }

    /**
     * 
     * @return Format
     */
    public function getFormatInfo()
    {
        return $this->format;
    }

    public function getFileName()
    {
        return $this->format->getFilename();
    }

}
