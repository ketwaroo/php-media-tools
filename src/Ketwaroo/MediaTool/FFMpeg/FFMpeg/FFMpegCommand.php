<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\FFMpeg\FFMpeg;

use Ketwaroo\ExternalCommand\Command;
use Ketwaroo\MediaTool\Video\X265\EncodeCommand as X256EncodeCommand;
use Ketwaroo\MediaTool\FFMpeg\FFMpeg;
use Ketwaroo\ExternalCommand\OptionGroup;

/**
 * Description of FFMpegCommand
 *
 * @author Yaasir Ketwaroo
 */
class FFMpegCommand extends Command {

    const optgroup_input = 'input';
    const optgroup_output = 'output';
    const optgroup_global = 'global';

    protected $outputFile;
    protected $inputFiles = [];
    protected $inputOptionGroupCount = 0;
    protected $useStdOut = false;
    protected $filters = [
        'video' => [],
        'audio' => [],
        'subtitle' => [],
    ];

    protected function getCommand() {
        return 'ffmpeg';
    }

    protected function setupDefaults() {
        $this->addInputOptionGroup();
        $this->addOptionGroup(static::optgroup_output, [], '-', ' ', ' ');
        $this->addOptionGroup(static::optgroup_global, [], '-', ' ', ' ');
    }

    /**
     * 
     * @param type $file
     * @return \Ketwaroo\ExternalCommand\OptionGroup
     */
    public function addInputOptionGroup($file = null) {
        /* @var $opt FFMpegInputOptionGroup */
        $opt = $this->addOptionGroup(
                $this->setupOptionGroup(
                        new FFMpegInputOptionGroup(static::optgroup_input . $this->inputOptionGroupCount)
                        , ['i']
                        , '-'
                        , ' '
                        , ' ')
        );
        $this->inputOptionGroupCount++;
        if (!empty($file)) {
            $opt->setInputFile($file);
        }
        return $opt;
    }

    protected function getCommandStringFormatter() {
        $cmd = '{command}{global_options}';

        for ($i = 0; $i < $this->inputOptionGroupCount; $i++) {
            $cmd .= '{input_options_' . $i . '}';
        }

        return $cmd . '{output_options}{joiner}{output_file}{piped_commands}';
    }

    protected function getCommandStringTranslationMap() {
        $tr = [
            '{global_options}' => $this->getGlobalOptionGroup(),
            '{output_options}' => $this->getOutputOptionGroup(),
            '{output_file}' => $this->getOutputFile(),
        ];

        for ($i = 0; $i < $this->inputOptionGroupCount; $i++) {
            $tr['{input_options_' . $i . '}'] = $this->getInputOptionGroup($i);
        }

        return array_merge(
                $tr
                , parent::getCommandStringTranslationMap()
        );
    }

    public function buildCommandString() {
        $this->getInputOptionGroup()
                ->setInputFile($this->getInputFile());
        return parent::buildCommandString();
    }

    /**
     * 
     * @return FFMpegInputOptionGroup
     */
    public function getInputOptionGroup($index = 0) {
        return $this->getOptionGroup(static::optgroup_input . $index);
    }

    /**
     * 
     * @return \Ketwaroo\ExternalCommand\OptionGroup
     */
    public function getOutputOptionGroup() {
        return $this->getOptionGroup(static::optgroup_output);
    }

    /**
     * 
     * @return \Ketwaroo\ExternalCommand\OptionGroup
     */
    public function getGlobalOptionGroup() {
        return $this->getOptionGroup(static::optgroup_global);
    }

    /**
     * 
     * @param type $inputFile
     * @return static
     */
    public function setInputFile($inputFile) {
        $this->inputFile = $inputFile;

        return $this;
    }

    protected function getInputFile() {
        return $this->inputFile;
    }

    /**
     * 
     * @param type $format
     * @return static
     */
    public function setOutputFormat($format) {
        $this->getOutputOptionGroup()
                ->addOption('f', $format);
        return $this;
    }

    /**
     * 
     * @param type $pixelFormat
     * @return static
     */
    public function setOutputPixelFormat($pixelFormat) {
        $this->getOutputOptionGroup()
                ->addOption('pix_fmt', $pixelFormat);
        return $this;
    }

    /**
     * 
     * @param type $framerate
     * @return static
     */
    public function setOutputFrameRate($framerate) {
        $this->getOutputOptionGroup()
                ->addOption('r', $framerate);
        return $this;
    }

    /**
     * Video sync method. For compatibility reasons old values can be specified as numbers. Newly added values will have to be specified as strings always.
     * 0,   passthrough Each frame is passed with its timestamp from the demuxer to the muxer. 
     * 1,   cfr         Frames will be duplicated and dropped to achieve exactly the requested constant frame rate. 
     * 2,   vfr         Frames are passed through with their timestamp or dropped so as to prevent 2 frames from having the same timestamp. 
     *      drop        As passthrough but destroys all timestamps, making the muxer generate fresh timestamps based on frame-rate. 
     * -1,  auto        Chooses between 1 and 2 depending on muxer capabilities. This is the default method. 
     * 
     * @param type $method
     * @return static
     */
    public function setOutputVsync($method) {
        $this->getOutputOptionGroup()
                ->addOption('vsync', $method);
        return $this;
    }

    /**
     * 
     * @return static
     */
    public function setOutputFormatYuv4MpegPipe() {
        $this->setOutputFormat(FFMpeg::outfmt_yuv4mpegpipe);
        return $this;
    }

    /**
     * 
     * @return static
     */
    public function setOutputFormatRawVideo() {
        $this->setOutputFormat(FFMpeg::outfmt_rawvideo);
        return $this;
    }

    protected function getOutputFile() {
        return $this->getUseStdOut() ? '-' : $this->escapeShellArg($this->outputFile);
    }

    /**
     * 
     * @param type $value
     * @return static
     */
    public function setUseStdOut($value = false) {
        $this->useStdOut = $value;
        return $this;
    }

    protected function getUseStdOut() {
        return $this->useStdOut;
    }

    /**
     * 
     * @param type $outputFile
     * @return static
     */
    public function setOutputFile($outputFile) {
        $this->outputFile = $outputFile;
        return $this;
    }

    /**
     * 
     * @param mixed $streamSpecifier int or string [avst]:\d+
     * @param type $inputFileId
     * @return static
     */
    public function selectStream($streamSpecifier, $inputFileId = '0') {
        $this->getOutputOptionGroup()
                ->addRepeatableOption('map', $inputFileId . ':' . $streamSpecifier);
        return $this;
    }

    /**
     * 
     * @return static
     */
    public function disableVideoStreams() {
        $this->getOutputOptionGroup()->addOptionWithNoValue('vn');
        return $this;
    }

    /**
     * 
     * @return static
     */
    public function disableAudioStreams() {
        $this->getOutputOptionGroup()->addOptionWithNoValue('an');
        return $this;
    }

    /**
     * 
     * @return static
     */
    public function disableSubtitleStreams() {
        $this->getOutputOptionGroup()->addOptionWithNoValue('sn');
        return $this;
    }

    /**
     * 
     * @param type $codec
     * @param string $streamSpecifier 
     * @return static
     */
    public function setCodec($codec, $streamSpecifier = '') {
        $this->getOutputOptionGroup()
                ->addOption('codec:' . $streamSpecifier, $codec);
        return $this;
    }

    /**
     * 
     * @param type $codec
     * @return static
     */
    public function setVideoCodec($codec) {
        $this->getOutputOptionGroup()
                ->addOption('vcodec', $codec);
        return $this;
    }

    /**
     * 
     * @param type $codec
     * @return static
     */
    public function setAudioCodec($codec) {
        $this->getOutputOptionGroup()
                ->addOption('acodec', $codec);
        return $this;
    }

    /**
     * 
     * @param type $rate
     * @return static
     */
    public function setAudioRate($rate) {
        $this->getOutputOptionGroup()
                ->addOption('ar', $rate);
        return $this;
    }

    /**
     * 
     * @param type $channels
     * @return static
     */
    public function setOutputAudioChannelCount($channels) {
        $this->getOutputOptionGroup()
                ->addOption('ac', $channels);
        return $this;
    }

    public function addX265ConversionCommand(X256EncodeCommand $x265Cmd) {
        $x265opt = clone ($x265Cmd->getDefaultOptionGroup());

        $x265opt
                ->setDefaultOptionJoiner(':')
                ->setDefaultOptionPrefix('')
                ->removeOption('output')
                ->removeOption('input')
                ->removeOption('y4m');

        $this->getOutputOptionGroup()
                ->addOption('c:v', 'libx265')
                ->addOption('x265-params', trim($x265opt->buildOptionGroupString()))
                ->addOption('format', 'hvec');

        return $this;
    }

    /**
     * 
     * @param type $timestring
     * @return static
     */
    public function setStartTime($timestring) {
        $this->getGlobalOptionGroup()
                ->addOption('ss', $timestring);
        return $this;
    }

    /**
     * 
     * @param type $timestring
     * @return static
     */
    public function setOutputStartTime($timestring) {
        $this->getOutputOptionGroup()
                ->addOption('ss', $timestring);
        return $this;
    }

    /**
     * 
     * @param type $timestring
     * @return static
     */
    public function setInputDuration($timestring) {
        $this->getGlobalOptionGroup()
                ->addOption('t', $timestring);
        return $this;
    }

    /**
     * 
     * @param type $timestring
     * @return static
     */
    public function setOutputDuration($timestring) {
        $this->getGlobalOptionGroup()
                ->addOption('t', $timestring);
        return $this;
    }

    /**
     * 
     * @param type $name
     * @param type $filterconfig
     * @return static
     */
    public function addVideoFilter($name, $filterconfig = null) {
        if (is_array($filterconfig)) {
            $filterconfig = $this->buildFilterConfing($filterconfig);
        }

        $this->filters['video'][] = $name . (empty($filterconfig) ? '' : "={$filterconfig}");

        $this->getOutputOptionGroup()
                ->addOption('filter:v', '"' . implode(', ', $this->filters['video']) . '"');

        $this->getOutputOptionGroup()
                ->getOption('filter:v')
                ->setIsRawValue(true); // filters need those for colons.
        return $this;
    }

    protected function buildFilterConfing(array $filterConfig) {
        $r = [];
        foreach ($filterConfig as $k => $v) {
            $r[] = $k . "='" . addcslashes($v, "'\\:") . "'";
        }
        return implode(':', $r);
    }

    /**
     * 
     * @param type $name
     * @param type $filterconfig
     * @return static
     */
    public function addAudioFilter($name, $filterconfig = '') {
        if (is_array($filterconfig)) {
            $filterconfig = $this->buildFilterConfing($filterconfig);
        }

        $this->filters['audio'][] = $name . (empty($filterconfig) ? '' : "={$filterconfig}");

        $this->getOutputOptionGroup()
                ->addOption('filter:a', '"' . implode(', ', $this->filters['audio']) . '"');
        $this->getOutputOptionGroup()
                ->getOption('filter:a')
                ->setIsRawValue(true); // filters need those.
        return $this;
    }

    /**
     * 
     * Method:
     * <table>
     * <tr><td>fast_bilinear</td><td>Select fast bilinear scaling algorithm.</td></tr>
     * <tr><td>bilinear</td><td>Select bilinear scaling algorithm.</td></tr>
     * <tr><td>bicubic</td><td>Select bicubic scaling algorithm.</td></tr>
     * <tr><td>experimental</td><td>Select experimental scaling algorithm.</td></tr>
     * <tr><td>neighbor</td><td>Select nearest neighbor rescaling algorithm.</td></tr>
     * <tr><td>area</td><td>Select averaging area rescaling algorithm.</td></tr>
     * <tr><td>bicublin</td><td>Select bicubic scaling algorithm for the luma component, bilinear for chroma components.</td></tr>
     * <tr><td>gauss</td><td>Select Gaussian rescaling algorithm.</td></tr>
     * <tr><td>sinc</td><td>Select sinc rescaling algorithm.</td></tr>
     * <tr><td>lanczos</td><td>Select Lanczos rescaling algorithm.</td></tr>
     * <tr><td>spline</td><td>Select natural bicubic spline rescaling algorithm.</td></tr>
     * <tr><td>print_info</td><td>Enable printing/debug logging.</td></tr>
     * <tr><td>accurate_rnd</td><td>Enable accurate rounding.</td></tr>
     * <tr><td>full_chroma_int</td><td>Enable full chroma interpolation.</td></tr>
     * <tr><td>full_chroma_inp</td><td>Select full chroma input.</td></tr>
     * <tr><td>bitexact</td><td>Enable bitexact output.</td></tr>
     * </table>
     * 
     * @param type $width
     * @param type $height
     * @param type $method
     * @return static
     */
    public function addVideoFilterResize($width, $height, $method = 'lanczos', $otherFlags = []) {
        $flags = implode('+', array_filter(array_unique(array_merge([$method, 'bitexact'], (array) $otherFlags))));
        $this->addVideoFilter('scale', trim("w={$width}:h={$height}:flags={$flags}"));
        return $this;
    }

    /**
     * quiet    -8  Show nothing at all; be silent. 
     * panic     0  Only show fatal errors which could lead the process to crash, such as and assert failure. This is not currently used for anything. 
     * fatal     8  Only show fatal errors. These are errors after which the process absolutely cannot continue after. 
     * error    16  Show all errors, including ones which can be recovered from. 
     * warning  24  Show all warnings and errors. Any message related to possibly incorrect or unexpected events will be shown. 
     * info     32  Show informative messages during processing. This is in addition to warnings and errors. This is the default value. 
     * verbose  40  Same as info, except more verbose. 
     * debug    48  Show everything, including debugging information. 
     * trace    56
     * 
     * @param int $level
     * @return static
     */
    public function setLogLevel($level) {
        $this->getGlobalOptionGroup()
                ->addOption('loglevel', $level);

        return $this;
    }

    /**
     * 
     * @return static
     */
    public function showStats() {
        $this->getGlobalOptionGroup()
                ->addOptionWithNoValue('stats');

        return $this;
    }

    /**
     * Set log level to `quiet` and show stats
     * @return static
     */
    public function showProgressOnly() {
        return $this->setLogLevel('quiet')
                        ->showStats();
    }

}
