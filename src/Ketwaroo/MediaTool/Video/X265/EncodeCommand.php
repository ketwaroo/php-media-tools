<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo\MediaTool\Video\X265;

use Ketwaroo\ExternalCommand\Command;

/**
 * Description of CommandEncode
 *
 * @author Yaasir Ketwaroo
 */
class EncodeCommand extends Command
{

    protected function setupDefaults()
    {
        $this->getDefaultOptionGroup()
            ->setRequiredOptions([
                'input',
                'output',
        ]);

        return $this;
    }

    protected function getCommand()
    {
        return 'x265';
    }

    /**
     * <code>--version</code>
     * 
     * Display version details
     * 
     * @return \Ketwaroo\ExternalCommand\Output
     */
    public function getCliVersion()
    {
        $this->getDefaultOptionGroup()
            ->addOptionWithNoValue('no-progress');
        return $this;
    }

    /**
     * <code>--log-level <integer|string></code>
     * 
     * <p>Logging level. Debug level enables per-frame QP, metric, and bitrate
     * logging. If a CSV file is being generated, frame level makes the log
     * be per-frame rather than per-encode. Full level enables hash and
     * weight logging. -1 disables all logging, except certain fatal
     * errors, and can be specified by the string “none”.</p>
     * <ol start="0">
     * <li>error</li>
     * <li>warning</li>
     * <li>info <strong>(default)</strong></li>
     * <li>debug</li>
     * <li>full</li>
     * </ol>
     * 
     * @return static
     */
    public function setOptLogLevel($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('log-level', $value);
        return $this;
    }

    /**
     * <code>--no-progress</code>
     * 
     * <p>Disable periodic progress reports from the CLI</p>
     * 
     * @return static
     */
    public function setOptNoProgress()
    {
        $this->getDefaultOptionGroup()
            ->addOptionWithNoValue('no-progress');
        return $this;
    }

    /**
     * <code>--csv <filename></code>
     * 
     * <p>Writes encoding results to a comma separated value log file. Creates
     * the file if it doesnt already exist. If <code>--csv-log-level</code> is 0,
     * it adds one line per run. If <code>--csv-log-level</code> is greater than
     * 0, it writes one line per frame. Default none</p>
     * <p>Several frame performance statistics are available when
     * <code>--csv-log-level</code> is greater than or equal to 2:</p>
     * <p><b>DecideWait ms</b> number of milliseconds the frame encoder had to
     * wait, since the previous frame was retrieved by the API thread,
     * before a new frame has been given to it. This is the latency
     * introduced by slicetype decisions (lookahead).</p>
     * <p><b>Row0Wait ms</b> number of milliseconds since the frame encoder
     * received a frame to encode before its first row of CTUs is allowed
     * to begin compression. This is the latency introduced by reference
     * frames making reconstructed and filtered rows available.</p>
     * <p><b>Wall time ms</b> number of milliseconds between the first CTU
     * being ready to be compressed and the entire frame being compressed
     * and the output NALs being completed.</p>
     * <p><b>Ref Wait Wall ms</b> number of milliseconds between the first
     * reference row being available and the last reference row becoming
     * available.</p>
     * <p><b>Total CTU time ms</b> the total time (measured in milliseconds)
     * spent by worker threads compressing and filtering CTUs for this
     * frame.</p>
     * <p><b>Stall Time ms</b> the number of milliseconds of the reported wall
     * time that were spent with zero worker threads, aka all compression
     * was completely stalled.</p>
     * <p><b>Avg WPP</b> the average number of worker threads working on this
     * frame, at any given time. This value is sampled at the completion of
     * each CTU. This shows the effectiveness of Wavefront Parallel
     * Processing.</p>
     * <p><b>Row Blocks</b> the number of times a worker thread had to abandon
     * the row of CTUs it was encoding because the row above it was not far
     * enough ahead for the necessary reference data to be available. This
     * is more of a problem for P frames where some blocks are much more
     * expensive than others.</p>
     * 
     * @param string $filename
     * @return static
     */
    public function setOptCsv($filename)
    {

        $this->getDefaultOptionGroup()
            ->addOption('csv', $filename);
        return $this;
    }

    /**
     * <code>--csv-log-level <integer></code>
     * 
     * <p>CSV logging level. Default 0
     * 0. summary
     * 1. frame level logging
     * 2. frame level logging with performance statistics</p>
     * 
     * @param type $level
     * @return static
     */
    public function setOptCsvLogLevel($level)
    {
        $this->getDefaultOptionGroup()
            ->addOption('csv_log_level', $level);
        return $this;
    }

    /**
     * <code>--ssim, --no-ssim</code>
     * 
     * <p>Calculate and report Structural Similarity values. It is
     * recommended to use <code>--tune</code> ssim if you are measuring ssim,
     * else the results should not be used for comparison purposes.
     * Default disabled</p>
     * 
     * @param type $toggle
     * @return static
     */
    public function setOptToggleSsim($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('ssim');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-ssim');
        }
        return $this;
    }

    /**
     * <code>--psnr, --no-psnr</code>
     * 
     * <p>Calculate and report Peak Signal to Noise Ratio.  It is recommended
     * to use <code>--tune</code> psnr if you are measuring PSNR, else the
     * results should not be used for comparison purposes.  Default
     * disabled</p>
     * 
     * @param type $toggle
     * @return static
     */
    public function setOptPsnr($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('psnr');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-psnr');
        }
        return $this;
    }

    /**
     * <code>--asm <integer:false:string>, --no-asm</code>
     * 
     * <p>x265 will use all detected CPU SIMD architectures by default. You can
     * disable all assembly by using <code>--no-asm</code> or you can specify
     * a comma separated list of SIMD architectures to use, matching these
     * strings: MMX2, SSE, SSE2, SSE3, SSSE3, SSE4, SSE4.1, SSE4.2, AVX, XOP, FMA4, AVX2, FMA3</p>
     * <p>Some higher architectures imply lower ones being present, this is
     * handled implicitly.</p>
     * <p>One may also directly supply the CPU capability bitmap as an integer.</p>
     * <p>Note that by specifying this option you are overriding x265’s CPU
     * detection and it is possible to do this wrong. You can cause encoder
     * crashes by specifying SIMD architectures which are not supported on
     * your CPU.</p>
     * <p>Default: auto-detected SIMD architectures</p>
     * 
     * @param type $toggleValue
     * @return static
     */
    public function setOptToggleAsm($toggleValue)
    {
        if (false === $toggleValue)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-asm');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOption('asm', $toggleValue);
        }
        return $this;
    }

    /**
     * <code>--frame-threads, -F <integer></code>
     * 
     * <p>Number of concurrently encoded frames. Using a single frame thread
     * gives a slight improvement in compression, since the entire reference
     * frames are always available for motion compensation, but it has
     * severe performance implications. Default is an autodetected count
     * based on the number of CPU cores and whether WPP is enabled or not.</p>
     * <p>Over-allocation of frame threads will not improve performance, it
     * will generally just increase memory use.</p>
     * <p><b>Values:</b> any value between 0 and 16. Default is 0, auto-detect</p>
     * 
     * @param type $value
     * @return static
     */
    public function setOptFrameThreads($value = 0)
    {
        $this->getDefaultOptionGroup()
            ->addOption('frame-threads', $value);
        return $this;
    }

    /**
     * <code>--pools <string>, --numa-pools <string></code>
     * 
     * <p>Comma seperated list of threads per NUMA node. If “none”, then no worker
     * pools are created and only frame parallelism is possible. If NULL or “”
     * (default) x265 will use all available threads on each NUMA node:</p>
     * <div><pre>'+'  is a special value indicating all cores detected on the node
     * '*'  is a special value indicating all cores detected on the node and all remaining nodes
     * '-'  is a special value indicating no cores on the node, same as '0'
     * </pre></div>
     * <p>example strings for a 4-node system:</p>
     * <div><pre>""        - default, unspecified, all numa nodes are used for thread pools
     * "*"       - same as default
     * "none"    - no thread pools are created, only frame parallelism possible
     * "-"       - same as "none"
     * "10"      - allocate one pool, using up to 10 cores on node 0
     * "-,+"     - allocate one pool, using all cores on node 1
     * "+,-,+"   - allocate one pool, using only cores on nodes 0 and 2
     * "+,-,+,-" - allocate one pool, using only cores on nodes 0 and 2
     * "-,*"     - allocate one pool, using all cores on nodes 1, 2 and 3
     * "8,8,8,8" - allocate four pools with up to 8 threads in each pool
     * "8,+,+,+" - allocate two pools, the first with 8 threads on node 0, and the second with all cores on node 1,2,3
     * </pre></div>
     * <p>A thread pool dedicated to a given NUMA node is enabled only when the
     * number of threads to be created on that NUMA node is explicitly mentioned
     * in that corresponding position with the –pools option. Else, all threads
     * are spawned from a single pool. The total number of threads will be
     * determined by the number of threads assigned to the enabled NUMA nodes for
     * that pool. The worker threads are be given affinity to all the enabled
     * NUMA nodes for that pool and may migrate between them, unless explicitly
     * specified as described above.</p>
     * <p>In the case that any threadpool has more than 64 threads, the threadpool
     * may be broken down into multiple pools of 64 threads each; on 32-bit
     * machines, this number is 32. All pools are given affinity to the NUMA
     * nodes on which the original pool had affinity. For performance reasons,
     * the last thread pool is spawned only if it has more than 32 threads for
     * 64-bit machines, or 16 for 32-bit machines. If the total number of threads
     * in the system doesn’t obey this constraint, we may spawn fewer threads
     * than cores which has been emperically shown to be better for performance.</p>
     * <p>If the four pool features: <code>--wpp</code>, <code>--pmode</code>,
     * <code>--pme</code> and <code>--lookahead-slices</code> are all disabled,
     * then <code>--pools</code> is ignored and no thread pools are created.</p>
     * <p>If “none” is specified, then all four of the thread pool features are
     * implicitly disabled.</p>
     * <p>Frame encoders are distributed between the available thread pools,
     * and the encoder will never generate more thread pools than
     * <code>--frame-threads</code>.  The pools are used for WPP and for
     * distributed analysis and motion search.</p>
     * <p>On Windows, the native APIs offer sufficient functionality to
     * discover the NUMA topology and enforce the thread affinity that
     * libx265 needs (so long as you have not chosen to target XP or
     * Vista), but on POSIX systems it relies on libnuma for this
     * functionality. If your target POSIX system is single socket, then
     * building without libnuma is a perfectly reasonable option, as it
     * will have no effect on the runtime behavior. On a multiple-socket
     * system, a POSIX build of libx265 without libnuma will be less work
     * efficient. See thread pools for more detail.</p>
     * <p>Default “”, one pool is created across all available NUMA nodes, with
     * one thread allocated per detected hardware thread
     * (logical CPU cores). In the case that the total number of threads is more
     * than the maximum size that ATOMIC operations can handle (32 for 32-bit
     * compiles, and 64 for 64-bit compiles), multiple thread pools may be
     * spawned subject to the performance constraint described above.</p>
     * <p>Note that the string value will need to be escaped or quoted to
     * protect against shell expansion on many platforms</p>
     * 
     * @param type $value
     * @return static
     */
    public function setOptPools($value = '*')
    {
        $this->getDefaultOptionGroup()
            ->addOption('pools', $value);
        return $this;
    }

    /**
     * <code>--wpp, --no-wpp</code>
     * 
     * <p>Enable Wavefront Parallel Processing. The encoder may begin encoding
     * a row as soon as the row above it is at least two CTUs ahead in the
     * encode process. This gives a 3-5x gain in parallelism for about 1%
     * overhead in compression efficiency.</p>
     * <p>This feature is implicitly disabled when no thread pool is present.</p>
     * <p>Default: Enabled</p>
     * 
     * @param type $toggle
     * @return static
     */
    public function setOptToggleWpp($toggle = true)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('wpp');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-wpp');
        }
        return $this;
    }

    /**
     * <code>--pmode, --no-pmode</code>
     * 
     * <p>Parallel mode decision, or distributed mode analysis. When enabled
     * the encoder will distribute the analysis work of each CU (merge,
     * inter, intra) across multiple worker threads. Only recommended if
     * x265 is not already saturating the CPU cores. In RD levels 3 and 4
     * it will be most effective if –rect is enabled. At RD levels 5 and
     * 6 there is generally always enough work to distribute to warrant the
     * overhead, assuming your CPUs are not already saturated.</p>
     * <p>–pmode will increase utilization without reducing compression
     * efficiency. In fact, since the modes are all measured in parallel it
     * makes certain early-outs impractical and thus you usually get
     * slightly better compression when it is enabled (at the expense of
     * not skipping improbable modes). This bypassing of early-outs can
     * cause pmode to slow down encodes, especially at faster presets.</p>
     * <p>This feature is implicitly disabled when no thread pool is present.</p>
     * <p>Default disabled</p>
     * 
     * @param type $toggle
     * @return static
     */
    public function setOptTogglePmode($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('pmode');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-pmode');
        }
        return $this;
    }

    /**
     * <code>--pme, --no-pme</code>
     * 
     * <p>Parallel motion estimation. When enabled the encoder will distribute
     * motion estimation across multiple worker threads when more than two
     * references require motion searches for a given CU. Only recommended
     * if x265 is not already saturating CPU cores. <code>--pmode</code> is
     * much more effective than this option, since the amount of work it
     * distributes is substantially higher. With –pme it is not unusual
     * for the overhead of distributing the work to outweigh the
     * parallelism benefits.</p>
     * <p>This feature is implicitly disabled when no thread pool is present.</p>
     * <p>–pme will increase utilization on many core systems with no effect
     * on the output bitstream.</p>
     * <p>Default disabled</p>
     *
     * param type $toggle
     * @return static
     */
    public function setOptTogglePme($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('pme');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('pme');
        }
        return $this;
    }

    /**
     * <code>--preset, -p <integer|string></code>
     * 
     * <p>Sets parameters to preselected values, trading off compression efficiency against
     * encoding speed. These parameters are applied before all other input parameters are
     * applied, and so you can override any parameters that these values control.  See
     * presets for more detail.</p>
     * <ol start="0">
     * <li>ultrafast</li>
     * <li>superfast</li>
     * <li>veryfast</li>
     * <li>faster</li>
     * <li>fast</li>
     * <li>medium <b>(default)</b></li>
     * <li>slow</li>
     * <li>slower</li>
     * <li>veryslow</li>
     * <li>placebo</li>
     * </ol>
     * 
     * @param type $value
     * @return static
     */
    public function setOptPreset($value = 'medium')
    {
        $this->getDefaultOptionGroup()
            ->addOption('preset', $value);
        return $this;
    }

    /**
     * <code>--tune, -t <string></code>
     * 
     * <p>Tune the settings for a particular type of source or situation. The changes will
     * be applied after <code>--preset</code> but before all other parameters. Default none.
     * See tunings for more detail.</p>
     * <p><b>Values:</b> psnr, ssim, grain, zero-latency, fast-decode.</p>
     * 
     * 
     * </div>
     * <div>
     * <h2>Input/Output File Options<a title="Permalink to this headline">¶</a></h2>
     * <p>These options all describe the input video sequence or, in the case of
     * <code>--dither</code>, operations that are performed on the sequence prior
     * to encode. All options dealing with files (names, formats, offsets or
     * frame counts) are only applicable to the CLI application.</p>
     * 
     * @param type $value
     * @return static
     */
    public function setOptTune($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('tune', $value);
        return $this;
    }

    /**
     * <code>--input <filename></code>
     * 
     * <p>Input filename, only raw YUV or Y4M supported. Use single dash for
     * stdin. This option name will be implied for the first “extra”
     * command line argument.</p>
     * 
     * @param type $filename
     * @return static
     */
    public function setInputFile($filename)
    {
        $this->getDefaultOptionGroup()
            ->removeOption('y4m')
            ->addOptionWithRawValueIf('input', [static::piped_inout], $filename);
        return $this;
    }

    /**
     * <code>--y4m</code>
     * 
     * <p>Parse input stream as YUV4MPEG2 regardless of file extension,
     * primarily intended for use with stdin (ie: <code>--input</code> -
     * <code>--y4m</code>).  This option is implied if the input filename has
     * a ”.y4m” extension</p>
     * 
     * @param type $filename
     * @return static
     */
    public function setInputAsYuv4Mpeg($filename)
    {
        $this->getDefaultOptionGroup()
            ->removeOption('input')
            ->addOptionWithRawValueIf('y4m', [static::piped_inout], $filename);

        return $this;
    }

    /**
     * <code>--input-depth <integer></code>
     * 
     * <p>YUV only: Bit-depth of input file or stream</p>
     * <p><b>Values:</b> any value between 8 and 16. Default is internal depth.</p>
     *
     * 
     * @param type $value
     * @return static
     */
    public function setOptInputDepth($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('input-depth', $value);
        return $this;
    }

    /**
     * <code>--dither</code>
     * 
     * <p>Enable high quality downscaling. Dithering is based on the diffusion
     * of errors from one row of pixels to the next row of pixels in a
     * picture. Only applicable when the input bit depth is larger than
     * 8bits and internal bit depth is 8bits. Default disabled</p>
     * 
     * @return static
     */
    public function setOptDither()
    {
        $this->getDefaultOptionGroup()
            ->addOptionWithNoValue('dither');
        return $this;
    }

    /**
     * <code>--input-res <wxh></code>
     * 
     * <p>YUV only: Source picture size [w x h]</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptInputRes($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('input-res', $value);
        return $this;
    }

    /**
     * <code>--input-csp <integer|string></code>
     * 
     * <p>Chroma Subsampling (YUV only):  Only 4:0:0(monochrome), 4:2:0, 4:2:2, and 4:4:4 are supported at this time.
     * The chroma subsampling format of your input must match your desired output chroma subsampling format
     * (libx265 will not perform any chroma subsampling conversion), and it must be supported by the
     * HEVC profile you have specified.</p>
     * <ol start="0">
     * <li>i400 (4:0:0 monochrome) - Not supported by Main or Main10 profiles</li>
     * <li>i420 (4:2:0 default)    - Supported by all HEVC profiles</li>
     * <li>i422 (4:2:2)            - Not supported by Main, Main10 and Main12 profiles</li>
     * <li>i444 (4:4:4)            - Supported by Main 4:4:4, Main 4:4:4 10, Main 4:4:4 12, Main 4:4:4 16 Intra profiles</li>
     * <li>nv12</li>
     * <li>nv16</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptInputCsp($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('input-csp', $value);
        return $this;
    }

    /**
     * <code>--fps <integer|float|numerator/denominator></code>
     * 
     * <p>YUV only: Source frame rate</p>
     * <p><b>Range of values:</b> positive int or float, or num/denom</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptFps($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('fps', $value);
        return $this;
    }

    /**
     * <code>--interlace <false|tff|bff>, --no-interlace</code>
     * 
     * <ol start="0">
     * <li>progressive pictures <b>(default)</b></li>
     * <li>top field first</li>
     * <li>bottom field first</li>
     * </ol>
     * <p>HEVC encodes interlaced content as fields. Fields must be provided to
     * the encoder in the correct temporal order. The source dimensions
     * must be field dimensions and the FPS must be in units of fields per
     * second. The decoder must re-combine the fields in their correct
     * orientation for display.</p>
     * 
     * @param type $value
     * @return static
     */
    public function setOptUseInterlace($value = false)
    {
        if (false !== $value)
        {
            $this->getDefaultOptionGroup()
                ->addOption('interlace', $value);
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-interlace');
        }
        return $this;
    }

    /**
     * <code>--seek <integer></code>
     * 
     * <p>Number of frames to skip at start of input file. Default 0</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptSeek($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('seek', $value);
        return $this;
    }

    /**
     * <code>--frames, -f <integer></code>
     * 
     * <p>Number of frames of input sequence to be encoded. Default 0 (all)
     * It may be left
     * unspecified, but when it is specified rate control can make use of
     * this information. It is also used to determine if an encode is
     * actually a stillpicture profile encode (single frame)</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptFrames($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('frames', $value);
        return $this;
    }

    /**
     * <code>--output, -o <filename></code>
     * 
     * <p>Bitstream output file name. If there are two extra CLI options, the
     * first is implicitly the input filename and the second is the output
     * filename, making the <code>--output</code> option optional.</p>
     * <p>The output file will always contain a raw HEVC bitstream, the CLI
     * does not support any container file formats.</p>
     * 
     * @patam string $value
     * @return static
     */
    public function setOutputFile($filename)
    {
        $this->getDefaultOptionGroup()
            ->addOptionWithRawValueIf('output', [static::piped_inout], $filename);

        return $this;
    }

    /**
     * <code>--output-depth, -D 8|10|12</code>
     * 
     * <p>Bitdepth of output HEVC bitstream, which is also the internal bit
     * depth of the encoder. If the requested bit depth is not the bit
     * depth of the linked libx265, it will attempt to bind libx265_main
     * for an 8bit encoder, libx265_main10 for a 10bit encoder, or
     * libx265_main12 for a 12bit encoder, with the same API version as the
     * linked libx265.</p>
     * <p>If the output depth is not specified but <code>--profile</code> is
     * specified, the output depth will be derived from the profile name.</p>
     * 
     * 
     * @param int $value
     * @return static
     */
    public function setOptOputputDepth($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('output-depth', $value);
        return $this;
    }

    /**
     * <code>--profile, -P <string></code>
     * 
     * <p>Enforce the requirements of the specified profile, ensuring the
     * output stream will be decodable by a decoder which supports that
     * profile.  May abort the encode if the specified profile is
     * impossible to be supported by the compile options chosen for the
     * encoder (a high bit depth encoder will be unable to output
     * bitstreams compliant with Main or MainStillPicture).</p>
     * <p>The following profiles are supported in x265.</p>
     * <p>8bit profiles:</p>
     * <p>main, main-intra, mainstillpicture (or msp for short)
     * main444-8 main444-intra main444-stillpicture
     * See note below on signaling intra and stillpicture profiles.</p>
     * <p>10bit profiles:</p>
     * <p>main10, main10-intra
     * main422-10, main422-10-intra
     * main444-10, main444-10-intra</p>
     * <p>12bit profiles:</p>
     * <p>main12, main12-intra
     * main422-12, main422-12-intra
     * main444-12, main444-12-intra</p>
     * 
     * <p>API users must call x265_param_apply_profile() after configuring
     * their param structure. Any changes made to the param structure after
     * this call might make the encode non-compliant.</p>
     * <p>The CLI application will derive the output bit depth from the
     * profile name if <code>--output-depth</code> is not specified.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptProfile($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('profile', $value);
        return $this;
    }

    /**
     * <code>--level-idc <integer|float></code>
     * 
     * <p>Minimum decoder requirement level. Defaults to 0, which implies
     * auto-detection by the encoder. If specified, the encoder will
     * attempt to bring the encode specifications within that specified
     * level. If the encoder is unable to reach the level it issues a
     * warning and aborts the encode. If the requested requirement level is
     * higher than the actual level, the actual requirement level is
     * signaled.</p>
     * <p>Beware, specifying a decoder level will force the encoder to enable
     * VBV for constant rate factor encodes, which may introduce
     * non-determinism.</p>
     * <p>The value is specified as a float or as an integer with the level
     * times 10, for example level <b>5.1</b> is specified as “5.1” or “51”,
     * and level <b>5.0</b> is specified as “5.0” or “50”.</p>
     * <p>Annex A levels: 1, 2, 2.1, 3, 3.1, 4, 4.1, 5, 5.1, 5.2, 6, 6.1, 6.2, 8.5</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptLevelIdc($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('level-idc', $value);
        return $this;
    }

    /**
     * <code>--high-tier, --no-high-tier</code>
     * 
     * <p>If <code>--level-idc</code> has been specified, the option adds the
     * intention to support the High tier of that level. If your specified
     * level does not support a High tier, a warning is issued and this
     * modifier flag is ignored. If <code>--level-idc</code> has been specified,
     * but not –high-tier, then the encoder will attempt to encode at the
     * specified level, main tier first, turning on high tier only if
     * necessary and available at that level.</p>
     * <p>If <code>--level-idc</code> has not been specified, this argument is
     * ignored.</p>
     * 
     * @param type $toggle
     * @return static
     */
    public function setOptToggleHighTier($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('high-tier');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-high-tier');
        }
        return $this;
    }

    /**
     * <code>--ref <1..16></code>
     * 
     * <p>Max number of L0 references to be allowed. This number has a linear
     * multiplier effect on the amount of work performed in motion search,
     * but will generally have a beneficial affect on compression and
     * distortion.</p>
     * <p>Note that x265 allows up to 16 L0 references but the HEVC
     * specification only allows a maximum of 8 total reference frames. So
     * if you have B frames enabled only 7 L0 refs are valid and if you
     * have <code>--b-pyramid</code> enabled (which is enabled by default in
     * all presets), then only 6 L0 refs are the maximum allowed by the
     * HEVC specification.  If x265 detects that the total reference count
     * is greater than 8, it will issue a warning that the resulting stream
     * is non-compliant and it signals the stream as profile NONE and level
     * NONE and will abort the encode unless
     * <code>--allow-non-conformance</code> it specified.  Compliant HEVC
     * decoders may refuse to decode such streams.</p>
     * <p>Default 3</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptRef($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('ref', $value);
        return $this;
    }

    /**
     * <code>--allow-non-conformance, --no-allow-non-conformance</code>
     * 
     * <p>Allow libx265 to generate a bitstream with profile and level NONE.
     * By default it will abort any encode which does not meet strict level
     * compliance. The two most likely causes for non-conformance are
     * <code>--ctu</code> being too small, <code>--ref</code> being too high,
     * or the bitrate or resolution being out of specification.</p>
     * <p>Default: disabled</p>
     * 
     * 
     * <div>
     * <p>Note</p>
     * <p><code>--profile</code>, <code>--level-idc</code>, and
     * <code>--high-tier</code> are only intended for use when you are
     * targeting a particular decoder (or decoders) with fixed resource
     * limitations and must constrain the bitstream within those limits.
     * Specifying a profile or level may lower the encode quality
     * parameters to meet those requirements but it will never raise
     * them. It may enable VBV constraints on a CRF encode.</p>
     * <p>Also note that x265 determines the decoder requirement profile and
     * level in three steps.  First, the user configures an x265_param
     * structure with their suggested encoder options and then optionally
     * calls x265_param_apply_profile() to enforce a specific profile
     * (main, main10, etc). Second, an encoder is created from this
     * x265_param instance and the <code>--level-idc</code> and
     * <code>--high-tier</code> parameters are used to reduce bitrate or other
     * features in order to enforce the target level. Finally, the encoder
     * re-examines the final set of parameters and detects the actual
     * minimum decoder requirement level and this is what is signaled in
     * the bitstream headers. The detected decoder level will only use High
     * tier if the user specified a High tier level.</p>
     * <p>The signaled profile will be determined by the encoder’s internal
     * bitdepth and input color space. If <code>--keyint</code> is 0 or 1,
     * then an intra variant of the profile will be signaled.</p>
     * <p>If <code>--total-frames</code> is 1, then a stillpicture variant will
     * be signaled, but this parameter is not always set by applications,
     * particularly not when the CLI uses stdin streaming or when libx265
     * is used by third-party applications.</p>
     * </div>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleAllowNonConformance($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('allow-non-conformance');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-allow-non-conformance');
        }
        return $this;
    }

    /**
     * <code>--rd <0..6></code>
     * 
     * <p>Level of RDO in mode decision. The higher the value, the more
     * exhaustive the analysis and the more rate distortion optimization is
     * used. The lower the value the faster the encode, the higher the
     * value the smaller the bitstream (in general). Default 3</p>
     * <p>Note that this table aims for accuracy, but is not necessarily our
     * final target behavior for each mode.</p>
     * <div><table>
     * <tr><th>Level</th>
     * <th>Description</th>
     * </tr>
     * <tr><td>0</td>
     * <td>sa8d mode and split decisions, intra w/ source pixels,
     * currently not supported</td>
     * </tr>
     * <tr><td>1</td>
     * <td>recon generated (better intra), RDO merge/skip selection</td>
     * </tr>
     * <tr><td>2</td>
     * <td>RDO splits and merge/skip selection</td>
     * </tr>
     * <tr><td>3</td>
     * <td>RDO mode and split decisions, chroma residual used for sa8d</td>
     * </tr>
     * <tr><td>4</td>
     * <td>Currently same as 3</td>
     * </tr>
     * <tr><td>5</td>
     * <td>Adds RDO prediction decisions</td>
     * </tr>
     * <tr><td>6</td>
     * <td>Currently same as 5</td>
     * </tr>
     * </table></div>
     * <p><b>Range of values:</b> 0: least .. 6: full RDO analysis</p>
     * 
     * 
     * <p>Options which affect the coding unit quad-tree, sometimes referred to as
     * the prediction quad-tree.</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptRd($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('rd', $value);
        return $this;
    }

    /**
     * <code>--ctu, -s <64|32|16></code>
     * 
     * <p>Maximum CU size (width and height). The larger the maximum CU size,
     * the more efficiently x265 can encode flat areas of the picture,
     * giving large reductions in bitrate. However this comes at a loss of
     * parallelism with fewer rows of CUs that can be encoded in parallel,
     * and less frame parallelism as well. Because of this the faster
     * presets use a CU size of 32. Default: 64</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptCtu($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('ctu', $value);
        return $this;
    }

    /**
     * <code>--min-cu-size <64|32|16|8></code>
     * 
     * <p>Minimum CU size (width and height). By using 16 or 32 the encoder
     * will not analyze the cost of CUs below that minimum threshold,
     * saving considerable amounts of compute with a predictable increase
     * in bitrate. This setting has a large effect on performance on the
     * faster presets.</p>
     * <p>Default: 8 (minimum 8x8 CU for HEVC, best compression efficiency)</p>
     * 
     * 
     * <div>
     * <p>Note</p>
     * <p>All encoders within a single process must use the same settings for
     * the CU size range. <code>--ctu</code> and <code>--min-cu-size</code> must
     * be consistent for all of them since the encoder configures several
     * key global data structures based on this range.</p>
     * </div>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptMinCuSize($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('min-cu-size', $value);
        return $this;
    }

    /**
     * <code>--limit-refs <0|1|2|3></code>
     * 
     * <p>When set to X265_REF_LIMIT_DEPTH (1) x265 will limit the references
     * analyzed at the current depth based on the references used to code
     * the 4 sub-blocks at the next depth.  For example, a 16x16 CU will
     * only use the references used to code its four 8x8 CUs.</p>
     * <p>When set to X265_REF_LIMIT_CU (2), the rectangular and asymmetrical
     * partitions will only use references selected by the 2Nx2N motion
     * search (including at the lowest depth which is otherwise unaffected
     * by the depth limit).</p>
     * <p>When set to 3 (X265_REF_LIMIT_DEPTH &amp;&amp; X265_REF_LIMIT_CU), the 2Nx2N
     * motion search at each depth will only use references from the split
     * CUs and the rect/amp motion searches at that depth will only use the
     * reference(s) selected by 2Nx2N.</p>
     * <p>For all non-zero values of limit-refs, the current depth will evaluate
     * intra mode (in inter slices), only if intra mode was chosen as the best
     * mode for atleast one of the 4 sub-blocks.</p>
     * <p>You can often increase the number of references you are using
     * (within your decoder level limits) if you enable one or
     * both of these flags.</p>
     * <p>Default 3.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptLimitRefs($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('limit-refs', $value);
        return $this;
    }

    /**
     * <code>--limit-modes, --no-limit-modes</code>
     * 
     * <p>When enabled, limit-modes will limit modes analyzed for each CU using cost
     * metrics from the 4 sub-CUs. When multiple inter modes like <code>--rect</code>
     * and/or <code>--amp</code> are enabled, this feature will use motion cost
     * heuristics from the 4 sub-CUs to bypass modes that are unlikely to be the
     * best choice. This can significantly improve performance when <code>rect</code>
     * and/or <code>--amp</code> are enabled at minimal compression efficiency loss.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleLimitModes($toggle = true)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('limit-modes');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-limit-modes');
        }
        return $this;
    }

    /**
     * <code>--rect, --no-rect</code>
     * 
     * <p>Enable analysis of rectangular motion partitions Nx2N and 2NxN
     * (50/50 splits, two directions). Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleRect($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('rect');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-rect');
        }
        return $this;
    }

    /**
     * <code>--amp, --no-amp</code>
     * 
     * <p>Enable analysis of asymmetric motion partitions (75/25 splits, four
     * directions). At RD levels 0 through 4, AMP partitions are only
     * considered at CU sizes 32x32 and below. At RD levels 5 and 6, it
     * will only consider AMP partitions as merge candidates (no motion
     * search) at 64x64, and as merge or inter candidates below 64x64.</p>
     * <p>The AMP partitions which are searched are derived from the current
     * best inter partition. If Nx2N (vertical rectangular) is the best
     * current prediction, then left and right asymmetrical splits will be
     * evaluated. If 2NxN (horizontal rectangular) is the best current
     * prediction, then top and bottom asymmetrical splits will be
     * evaluated, If 2Nx2N is the best prediction, and the block is not a
     * merge/skip, then all four AMP partitions are evaluated.</p>
     * <p>This setting has no effect if rectangular partitions are disabled.
     * Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleAmp($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('amp');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-amp');
        }
        return $this;
    }

    /**
     * <code>--early-skip, --no-early-skip</code>
     * 
     * <p>Measure 2Nx2N merge candidates first; if no residual is found,
     * additional modes at that depth are not analysed. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleEarlySkip($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('early-skip');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-early-skip');
        }
        return $this;
    }

    /**
     * <code>--fast-intra, --no-fast-intra</code>
     * 
     * <p>Perform an initial scan of every fifth intra angular mode, then
     * check modes +/- 2 distance from the best mode, then +/- 1 distance
     * from the best mode, effectively performing a gradient descent. When
     * enabled 10 modes in total are checked. When disabled all 33 angular
     * modes are checked.  Only applicable for <code>--rd</code> levels 4 and
     * below (medium preset and faster).</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleFastIntra($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('fast-intra');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-fast-intra');
        }
        return $this;
    }

    /**
     * <code>--b-intra, --no-b-intra</code>
     * 
     * <p>Enables the evaluation of intra modes in B slices. Default disabled.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleBIntra($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('b-intra');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-b-intra');
        }
        return $this;
    }

    /**
     * <code>--cu-lossless, --no-cu-lossless</code>
     * 
     * <p>For each CU, evaluate lossless (transform and quant bypass) encode
     * of the best non-lossless mode option as a potential rate distortion
     * optimization. If the global option <code>--lossless</code> has been
     * specified, all CUs will be encoded as lossless unconditionally
     * regardless of whether this option was enabled. Default disabled.</p>
     * <p>Only effective at RD levels 3 and above, which perform RDO mode
     * decisions.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleLosslessCu($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('cu-lossless');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-cu-lossless');
        }
        return $this;
    }

    /**
     * <code>--tskip-fast, --no-tskip-fast</code>
     * 
     * <p>Only evaluate transform skip for NxN intra predictions (4x4 blocks).
     * Only applicable if transform skip is enabled. For chroma, only
     * evaluate if luma used tskip. Inter block tskip analysis is
     * unmodified. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleTskipFast($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('tskip-fast');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-tskip-fast');
        }
        return $this;
    }

    /**
     * <code>--rd-refine, --no-rd-refine</code>
     * 
     * <p>For each analysed CU, calculate R-D cost on the best partition mode
     * for a range of QP values, to find the optimal rounding effect.
     * Default disabled.</p>
     * <p>Only effective at RD levels 5 and 6</p>
     * 
     * 
     * <p>Analysis re-use options, to improve performance when encoding the same
     * sequence multiple times (presumably at varying bitrates). The encoder
     * will not reuse analysis if the resolution and slice type parameters do
     * not match.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleRdRefine($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('rd-refine');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-rd-refine');
        }
        return $this;
    }

    /**
     * <code>--analysis-mode <string|int></code>
     * 
     * <p>Specify whether analysis information of each frame is output by encoder
     * or input for reuse. By reading the analysis data writen by an
     * earlier encode of the same sequence, substantial redundant work may
     * be avoided.</p>
     * <p>The following data may be stored and reused:
     * I frames   - split decisions and luma intra directions of all CUs.
     * P/B frames - motion vectors are dumped at each depth for all CUs.</p>
     * <p><b>Values:</b> off(0), save(1): dump analysis data, load(2): read analysis data</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptAnalysisMode($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('analysis-mode', $value);
        return $this;
    }

    /**
     * <code>--analysis-file <filename></code>
     * 
     * <p>Specify a filename for analysis data (see <code>--analysis-mode</code>)
     * If no filename is specified, x265_analysis.dat is used.</p>
     * 
     * 
     * <p>Options which affect the transform unit quad-tree, sometimes referred to
     * as the residual quad-tree (RQT).</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptAnalysisFile($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('analysis-file', $value);
        return $this;
    }

    /**
     * <code>--rdoq-level <0|1|2>, --no-rdoq-level</code>
     * 
     * <p>Specify the amount of rate-distortion analysis to use within
     * quantization:</p>
     * <p>At level 0 rate-distortion cost is not considered in quant</p>
     * <p>At level 1 rate-distortion cost is used to find optimal rounding
     * values for each level (and allows psy-rdoq to be effective). It
     * trades-off the signaling cost of the coefficient vs its post-inverse
     * quant distortion from the pre-quant coefficient. When
     * <code>--psy-rdoq</code> is enabled, this formula is biased in favor of
     * more energy in the residual (larger coefficient absolute levels)</p>
     * <p>At level 2 rate-distortion cost is used to make decimate decisions
     * on each 4x4 coding group, including the cost of signaling the group
     * within the group bitmap. If the total distortion of not signaling
     * the entire coding group is less than the rate cost, the block is
     * decimated. Next, it applies rate-distortion cost analysis to the
     * last non-zero coefficient, which can result in many (or all) of the
     * coding groups being decimated. Psy-rdoq is less effective at
     * preserving energy when RDOQ is at level 2, since it only has
     * influence over the level distortion costs.</p>
     * 
     * @param type $toggleValue
     * @return static
     */
    public function setOptToggleRdoqLevel($toggleValue)
    {
        if (false === $toggleValue)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-rdoq-level');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOption('rdoq-level', $toggleValue);
        }
        return $this;
    }

    /**
     * <code>--tu-intra-depth <1..4></code>
     * 
     * <p>The transform unit (residual) quad-tree begins with the same depth
     * as the coding unit quad-tree, but the encoder may decide to further
     * split the transform unit tree if it improves compression efficiency.
     * This setting limits the number of extra recursion depth which can be
     * attempted for intra coded units. Default: 1, which means the
     * residual quad-tree is always at the same depth as the coded unit
     * quad-tree</p>
     * <p>Note that when the CU intra prediction is NxN (only possible with
     * 8x8 CUs), a TU split is implied, and thus the residual quad-tree
     * begins at 4x4 and cannot split any futhrer.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptTuIntraDepth($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('tu-intra-depth', $value);
        return $this;
    }

    /**
     * <code>--tu-inter-depth <1..4></code>
     * 
     * <p>The transform unit (residual) quad-tree begins with the same depth
     * as the coding unit quad-tree, but the encoder may decide to further
     * split the transform unit tree if it improves compression efficiency.
     * This setting limits the number of extra recursion depth which can be
     * attempted for inter coded units. Default: 1. which means the
     * residual quad-tree is always at the same depth as the coded unit
     * quad-tree unless the CU was coded with rectangular or AMP
     * partitions, in which case a TU split is implied and thus the
     * residual quad-tree begins one layer below the CU quad-tree.</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptTuInterDepth($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('tu-inter-depth', $value);
        return $this;
    }

    /**
     * <code>--nr-intra <integer>, --nr-inter <integer></code>
     * 
     * <p>Noise reduction - an adaptive deadzone applied after DCT
     * (subtracting from DCT coefficients), before quantization.  It does
     * no pixel-level filtering, doesn’t cross DCT block boundaries, has no
     * overlap, The higher the strength value parameter, the more
     * aggressively it will reduce noise.</p>
     * <p>Enabling noise reduction will make outputs diverge between different
     * numbers of frame threads. Outputs will be deterministic but the
     * outputs of -F2 will no longer match the outputs of -F3, etc.</p>
     * <p><b>Values:</b> any value in range of 0 to 2000. Default 0 (disabled).</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptNrIntra($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('nr-intra', $value);
        return $this;
    }

    /**
     * @see setOptNrIntra()
     * @param int $value
     * @return static
     */
    public function setOptNrInter($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('nr-inter', $value);
        return $this;
    }

    /**
     * <code>--tskip, --no-tskip</code>
     * 
     * <p>Enable evaluation of transform skip (bypass DCT but still use
     * quantization) coding for 4x4 TU coded blocks.</p>
     * <p>Only effective at RD levels 3 and above, which perform RDO mode
     * decisions. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleTskip($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('tskip');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-tskip');
        }
        return $this;
    }

    /**
     * <code>--rdpenalty <0..2></code>
     * 
     * <p>When set to 1, transform units of size 32x32 are given a 4x bit cost
     * penalty compared to smaller transform units, in intra coded CUs in P
     * or B slices.</p>
     * <p>When set to 2, transform units of size 32x32 are not even attempted,
     * unless otherwise required by the maximum recursion depth.  For this
     * option to be effective with 32x32 intra CUs,
     * <code>--tu-intra-depth</code> must be at least 2.  For it to be
     * effective with 64x64 intra CUs, <code>--tu-intra-depth</code> must be
     * at least 3.</p>
     * <p>Note that in HEVC an intra transform unit (a block of the residual
     * quad-tree) is also a prediction unit, meaning that the intra
     * prediction signal is generated for each TU block, the residual
     * subtracted and then coded. The coding unit simply provides the
     * prediction modes that will be used when predicting all of the
     * transform units within the CU. This means that when you prevent
     * 32x32 intra transform units, you are preventing 32x32 intra
     * predictions.</p>
     * <p>Default 0, disabled.</p>
     * <p><b>Values:</b> 0:disabled 1:4x cost penalty 2:force splits</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptRdpenalty($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('rdpenalty', $value);
        return $this;
    }

    /**
     * <code>--max-tu-size <32|16|8|4></code>
     * 
     * <p>Maximum TU size (width and height). The residual can be more
     * efficiently compressed by the DCT transform when the max TU size
     * is larger, but at the expense of more computation. Transform unit
     * quad-tree begins at the same depth of the coded tree unit, but if the
     * maximum TU size is smaller than the CU size then transform QT begins
     * at the depth of the max-tu-size. Default: 32.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptMaxTuSize($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('max-tu-size', $value);
        return $this;
    }

    /**
     * <code>--max-merge <1..5></code>
     * 
     * <p>Maximum number of neighbor (spatial and temporal) candidate blocks
     * that the encoder may consider for merging motion predictions. If a
     * merge candidate results in no residual, it is immediately selected
     * as a “skip”.  Otherwise the merge candidates are tested as part of
     * motion estimation when searching for the least cost inter option.
     * The max candidate number is encoded in the SPS and determines the
     * bit cost of signaling merge CUs. Default 2</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptMaxMerge($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('max-merge', $value);
        return $this;
    }

    /**
     * <code>--me <integer|string></code>
     * 
     * <p>Motion search method. Generally, the higher the number the harder
     * the ME method will try to find an optimal match. Diamond search is
     * the simplest. Hexagon search is a little better. Uneven
     * Multi-Hexegon is an adaption of the search method used by x264 for
     * slower presets. Star is a three step search adapted from the HM
     * encoder: a star-pattern search followed by an optional radix scan
     * followed by an optional star-search refinement. Full is an
     * exhaustive search; an order of magnitude slower than all other
     * searches but not much better than umh or star.</p>
     * <ol start="0">
     * <li>dia</li>
     * <li>hex <b>(default)</b></li>
     * <li>umh</li>
     * <li>star</li>
     * <li>full</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptMe($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('me', $value);
        return $this;
    }

    /**
     * <code>--subme, -m <0..7></code>
     * 
     * <p>Amount of subpel refinement to perform. The higher the number the
     * more subpel iterations and steps are performed. Default 2</p>
     * <div>
     * <table border="1">
     * <tr><th>-m</th>
     * <th>HPEL iters</th>
     * <th>HPEL dirs</th>
     * <th>QPEL iters</th>
     * <th>QPEL dirs</th>
     * <th>HPEL SATD</th>
     * </tr>
     * <tr><td>0</td>
     * <td>1</td>
     * <td>4</td>
     * <td>0</td>
     * <td>4</td>
     * <td>false</td>
     * </tr>
     * <tr><td>1</td>
     * <td>1</td>
     * <td>4</td>
     * <td>1</td>
     * <td>4</td>
     * <td>false</td>
     * </tr>
     * <tr><td>2</td>
     * <td>1</td>
     * <td>4</td>
     * <td>1</td>
     * <td>4</td>
     * <td>true</td>
     * </tr>
     * <tr><td>3</td>
     * <td>2</td>
     * <td>4</td>
     * <td>1</td>
     * <td>4</td>
     * <td>true</td>
     * </tr>
     * <tr><td>4</td>
     * <td>2</td>
     * <td>4</td>
     * <td>2</td>
     * <td>4</td>
     * <td>true</td>
     * </tr>
     * <tr><td>5</td>
     * <td>1</td>
     * <td>8</td>
     * <td>1</td>
     * <td>8</td>
     * <td>true</td>
     * </tr>
     * <tr><td>6</td>
     * <td>2</td>
     * <td>8</td>
     * <td>1</td>
     * <td>8</td>
     * <td>true</td>
     * </tr>
     * <tr><td>7</td>
     * <td>2</td>
     * <td>8</td>
     * <td>2</td>
     * <td>8</td>
     * <td>true</td>
     * </tr>
     * </table></div>
     * <p>At –subme values larger than 2, chroma residual cost is included
     * in all subpel refinement steps and chroma residual is included in
     * all motion estimation decisions (selecting the best reference
     * picture in each list, and chosing between merge, uni-directional
     * motion and bi-directional motion). The ‘slow’ preset is the first
     * preset to enable the use of chroma residual.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptSubme($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('subme', $value);
        return $this;
    }

    /**
     * <code>--merange <integer></code>
     * 
     * <p>Motion search range. Default 57</p>
     * <p>The default is derived from the default CTU size (64) minus the luma
     * interpolation half-length (4) minus maximum subpel distance (2)
     * minus one extra pixel just in case the hex search method is used. If
     * the search range were any larger than this, another CTU row of
     * latency would be required for reference frames.</p>
     * <p><b>Range of values:</b> an integer from 0 to 32768</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptMerange($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('merange', $value);
        return $this;
    }

    /**
     * <code>--temporal-mvp, --no-temporal-mvp</code>
     * 
     * <p>Enable temporal motion vector predictors in P and B slices.
     * This enables the use of the motion vector from the collocated block
     * in the previous frame to be used as a predictor. Default is enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleTemporalMvp($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('temporal-mvp');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-temporal-mvp');
        }
        return $this;
    }

    /**
     * <code>--weightp, -w, --no-weightp</code>
     * 
     * <p>Enable weighted prediction in P slices. This enables weighting
     * analysis in the lookahead, which influences slice decisions, and
     * enables weighting analysis in the main encoder which allows P
     * reference samples to have a weight function applied to them prior to
     * using them for motion compensation.  In video which has lighting
     * changes, it can give a large improvement in compression efficiency.
     * Default is enabled</p>
     * 
     * @param type $toggle
     * @return static
     */
    public function setOptToggleWeightp($toggle)
    {
        if (false === $toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-weightp');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('weightp');
        }
        return $this;
    }

    /**
     * <code>--weightb, --no-weightb</code>
     * 
     * <p>Enable weighted prediction in B slices. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleWeightb($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('weightb');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-weightb');
        }
        return $this;
    }

    /**
     * <code>--strong-intra-smoothing, --no-strong-intra-smoothing</code>
     * 
     * <p>Enable strong intra smoothing for 32x32 intra blocks. This flag
     * performs bi-linear interpolation of the corner reference samples
     * for a strong smoothing effect. The purpose is to prevent blocking
     * or banding artifacts in regions with few/zero AC coefficients.
     * Default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleStrongIntraSmoothing($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('strong-intra-smoothing');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-strong-intra-smoothing');
        }
        return $this;
    }

    /**
     * <code>--constrained-intra, --no-constrained-intra</code>
     * 
     * <p>Constrained intra prediction. When generating intra predictions for
     * blocks in inter slices, only intra-coded reference pixels are used.
     * Inter-coded reference pixels are replaced with intra-coded neighbor
     * pixels or default values. The general idea is to block the
     * propagation of reference errors that may have resulted from lossy
     * signals. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleConstrainedIntra($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('constrained-intra');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-constrained-intra');
        }
        return $this;
    }

    /**
     * <code>--psy-rd <float></code>
     * 
     * <p>Influence rate distortion optimizated mode decision to preserve the
     * energy of the source image in the encoded image at the expense of
     * compression efficiency. It only has effect on presets which use
     * RDO-based mode decisions (<code>--rd</code> 3 and above). 1.0 is a
     * typical value. Default 2.0</p>
     * <p><b>Range of values:</b> 0 .. 5.0</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptPsyRd($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('psy-rd', $value);
        return $this;
    }

    /**
     * <code>--psy-rdoq <float></code>
     * 
     * <p>Influence rate distortion optimized quantization by favoring higher
     * energy in the reconstructed image. This generally improves perceived
     * visual quality at the cost of lower quality metric scores.  It only
     * has effect when <code>--rdoq-level</code> is 1 or 2. High values can
     * be beneficial in preserving high-frequency detail like film grain.
     * Default: 1.0</p>
     * <p><b>Range of values:</b> 0 .. 50.0</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptPsyRdoq($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('psy-rdoq', $value);
        return $this;
    }

    /**
     * <code>--open-gop, --no-open-gop</code>
     * 
     * <p>Enable open GOP, allow I-slices to be non-IDR. Default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleOpenGop($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('open-gop');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-open-gop');
        }
        return $this;
    }

    /**
     * <code>--keyint, -I <integer></code>
     * 
     * <p>Max intra period in frames. A special case of infinite-gop (single
     * keyframe at the beginning of the stream) can be triggered with
     * argument -1. Use 1 to force all-intra. When intra-refresh is enabled
     * it specifies the interval between which refresh sweeps happen. Default 250</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptKeyint($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('keyint', $value);
        return $this;
    }

    /**
     * <code>--min-keyint, -i <integer></code>
     * 
     * <p>Minimum GOP size. Scenecuts closer together than this are coded as I
     * or P, not IDR. Minimum keyint is clamped to be at least half of
     * <code>--keyint</code>. If you wish to force regular keyframe intervals
     * and disable adaptive I frame placement, you must use
     * <code>--no-scenecut</code>.</p>
     * <p><b>Range of values:</b> >=0 (0: auto)</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptMinKeyint($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('min-keyint', $value);
        return $this;
    }

    /**
     * <code>--scenecut <integer>, --no-scenecut</code>
     * 
     * <p>How aggressively I-frames need to be inserted. The higher the
     * threshold value, the more aggressive the I-frame placement.
     * <code>--scenecut</code> 0 or <code>--no-scenecut</code> disables adaptive
     * I frame placement. Default 40</p>
     * 
     * @param type $toggleValue
     * @return static
     */
    public function setOptToggleScenecut($toggleValue = 40)
    {
        if (false === $toggleValue)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-scenecut');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOption('scenecut', $toggleValue);
        }
        return $this;
    }

    /**
     * <code>--intra-refresh</code>
     * 
     * <p>Enables Periodic Intra Refresh(PIR) instead of keyframe insertion.
     * PIR can replace keyframes by inserting a column of intra blocks in
     * non-keyframes, that move across the video from one side to the other
     * and thereby refresh the image but over a period of multiple
     * frames instead of a single keyframe.</p>
     */
    public function setOptIntraRefresh()
    {
        $this->getDefaultOptionGroup()
            ->addOptionWithNoValue('intra-refresh');
        return $this;
    }

    /**
     * <code>--rc-lookahead <integer></code>
     * 
     * <p>Number of frames for slice-type decision lookahead (a key
     * determining factor for encoder latency). The longer the lookahead
     * buffer the more accurate scenecut decisions will be, and the more
     * effective cuTree will be at improving adaptive quant. Having a
     * lookahead larger than the max keyframe interval is not helpful.
     * Default 20</p>
     * <p><b>Range of values:</b> Between the maximum consecutive bframe count (<code>--bframes</code>) and 250</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptRcLookahead($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('rc-lookahead', $value);
        return $this;
    }

    /**
     * <code>--lookahead-slices <0..16></code>
     * 
     * <blockquote>
     * <div><p>Use multiple worker threads to measure the estimated cost of each frame
     * within the lookahead. The frame is divided into the specified number of
     * slices, and one-thread is launched  per slice. When <code>--b-adapt</code> is
     * 2, most frame cost estimates will be performed in batch mode (many cost
     * estimates at the same time) and lookahead-slices is ignored for batched
     * estimates; it may still be used for single cost estimations. The higher this
     * parameter, the less accurate the frame costs will be (since context is lost
     * across slice boundaries) which will result in less accurate B-frame and
     * scene-cut decisions. The effect on performance can be significant especially
     * on systems with many threads.</p>
     * <p>The encoder may internally lower the number of slices or disable</p>
     * </div></blockquote>
     * <p>slicing to ensure each slice codes at least 10 16x16 rows of lowres
     * blocks to minimize the impact on quality. For example, for 720p and
     * 1080p videos, the number of slices is capped to 4 and 6, respectively.
     * For resolutions lesser than 720p, slicing is auto-disabled.</p>
     * <p>If slices are used in lookahead, they are logged in the list of tools
     * as <em>lslices</em></p>
     * <blockquote>
     * <b>Values:</b> 0 - disabled. 1 is the same as 0. Max 16.</blockquote>
     * <dl>
     * <dt>Default: 8 for ultrafast, superfast, faster, fast, medium
     * 4 for slow, slower
     * disabled for veryslow, slower</dd>
     * </dl>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptLookaheadSlices($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('lookahead-slices', $value);
        return $this;
    }

    /**
     * <code>--b-adapt <integer></code>
     * 
     * <p>Set the level of effort in determining B frame placement.</p>
     * <p>With b-adapt 0, the GOP structure is fixed based on the values of
     * <code>--keyint</code> and <code>--bframes</code>.</p>
     * <p>With b-adapt 1 a light lookahead is used to choose B frame placement.</p>
     * <p>With b-adapt 2 (trellis) a viterbi B path selection is performed</p>
     * <p><b>Values:</b> 0:none; 1:fast; 2:full(trellis) <b>default</b></p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptBAdapt($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('b-adapt', $value);
        return $this;
    }

    /**
     * <code>--bframes, -b <0..16></code>
     * 
     * <p>Maximum number of consecutive b-frames. Use <code>--bframes</code> 0 to
     * force all P/I low-latency encodes. Default 4. This parameter has a
     * quadratic effect on the amount of memory allocated and the amount of
     * work performed by the full trellis version of <code>--b-adapt</code>
     * lookahead.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptBframes($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('bframes', $value);
        return $this;
    }

    /**
     * <code>--bframe-bias <integer></code>
     * 
     * <p>Bias towards B frames in slicetype decision. The higher the bias the
     * more likely x265 is to use B frames. Can be any value between -90
     * and 100 and is clipped to that range. Default 0</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptBframeBias($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('bframe-bias', $value);
        return $this;
    }

    /**
     * <code>--b-pyramid, --no-b-pyramid</code>
     * 
     * <p>Use B-frames as references, when possible. Default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleBPyramid($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('b-pyramid');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-b-pyramid');
        }
        return $this;
    }

    /**
     * <code>--bitrate <integer></code>
     * 
     * <p>Enables single-pass ABR rate control. Specify the target bitrate in
     * kbps. Default is 0 (CRF)</p>
     * <p><b>Range of values:</b> An integer greater than 0</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptBitrate($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('bitrate', $value);
        return $this;
    }

    /**
     * <code>--crf <0..51.0></code>
     * 
     * <p>Quality-controlled variable bitrate. CRF is the default rate control
     * method; it does not try to reach any particular bitrate target,
     * instead it tries to achieve a given uniform quality and the size of
     * the bitstream is determined by the complexity of the source video.
     * The higher the rate factor the higher the quantization and the lower
     * the quality. Default rate factor is 28.0.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptCrf($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('crf', $value);
        return $this;
    }

    /**
     * <code>--crf-max <0..51.0></code>
     * 
     * <p>Specify an upper limit to the rate factor which may be assigned to
     * any given frame (ensuring a max QP).  This is dangerous when CRF is
     * used in combination with VBV as it may result in buffer underruns.
     * Default disabled</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptCrfMax($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('crf-max', $value);
        return $this;
    }

    /**
     * <code>--crf-min <0..51.0></code>
     * 
     * <p>Specify an lower limit to the rate factor which may be assigned to
     * any given frame (ensuring a min compression factor).</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptCrfMin($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('crf-min', $value);
        return $this;
    }

    /**
     * <code>--vbv-bufsize <integer></code>
     * 
     * <p>Specify the size of the VBV buffer (kbits). Enables VBV in ABR
     * mode.  In CRF mode, <code>--vbv-maxrate</code> must also be specified.
     * Default 0 (vbv disabled)</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptVbvBufsize($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('vbv-bufsize', $value);
        return $this;
    }

    /**
     * <code>--vbv-maxrate <integer></code>
     * 
     * <p>Maximum local bitrate (kbits/sec). Will be used only if vbv-bufsize
     * is also non-zero. Both vbv-bufsize and vbv-maxrate are required to
     * enable VBV in CRF mode. Default 0 (disabled)</p>
     * <p>Note that when VBV is enabled (with a valid <code>--vbv-bufsize</code>),
     * VBV emergency denoising is turned on. This will turn on aggressive
     * denoising at the frame level when frame QP > QP_MAX_SPEC (51), drastically
     * reducing bitrate and allowing ratecontrol to assign lower QPs for
     * the following frames. The visual effect is blurring, but removes
     * significant blocking/displacement artifacts.</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptVbvMaxrate($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('vbv-maxrate', $value);
        return $this;
    }

    /**
     * <code>--vbv-init <float></code>
     * 
     * <p>Initial buffer occupancy. The portion of the decode buffer which
     * must be full before the decoder will begin decoding.  Determines
     * absolute maximum frame size. May be specified as a fractional value
     * between 0 and 1, or in kbits. In other words these two option pairs
     * are equivalent:</p>
     * <div><pre>--vbv-bufsize 1000 --vbv-init 900
     * --vbv-bufsize 1000 --vbv-init 0.9
     * </pre></div>
     * <p>Default 0.9</p>
     * <p><b>Range of values:</b> fractional: 0 - 1.0, or kbits: 2 .. bufsize</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptVbvInit($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('vbv-init', $value);
        return $this;
    }

    /**
     * <code>--qp, -q <integer></code>
     * 
     * <p>Specify base quantization parameter for Constant QP rate control.
     * Using this option enables Constant QP rate control. The specified QP
     * is assigned to P slices. I and B slices are given QPs relative to P
     * slices using param->rc.ipFactor and param->rc.pbFactor unless QP 0
     * is specified, in which case QP 0 is used for all slice types.  Note
     * that QP 0 does not cause lossless encoding, it only disables
     * quantization. Default disabled (CRF)</p>
     * <p><b>Range of values:</b> an integer from 0 to 51</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptQp($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('qp', $value);
        return $this;
    }

    /**
     * <code>--lossless, --no-lossless</code>
     * 
     * <p>Enables true lossless coding by bypassing scaling, transform,
     * quantization and in-loop filter processes. This is used for
     * ultra-high bitrates with zero loss of quality. Reconstructed output
     * pictures are bit-exact to the input pictures. Lossless encodes
     * implicitly have no rate control, all rate control options are
     * ignored. Slower presets will generally achieve better compression
     * efficiency (and generate smaller bitstreams). Default disabled.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleLossless($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('lossless');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-lossless');
        }
        return $this;
    }

    /**
     * <code>--aq-mode <0|1|2|3></code>
     * 
     * <p>Adaptive Quantization operating mode. Raise or lower per-block
     * quantization based on complexity analysis of the source image. The
     * more complex the block, the more quantization is used. This offsets
     * the tendency of the encoder to spend too many bits on complex areas
     * and not enough in flat areas.</p>
     * <ol start="0">
     * <li>disabled</li>
     * <li>AQ enabled <b>(default)</b></li>
     * <li>AQ enabled with auto-variance</li>
     * <li>AQ enabled with auto-variance and bias to dark scenes</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptAqMode($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('aq-mode', $value);
        return $this;
    }

    /**
     * <code>--aq-strength <float></code>
     * 
     * <p>Adjust the strength of the adaptive quantization offsets. Setting
     * <code>--aq-strength</code> to 0 disables AQ. Default 1.0.</p>
     * <p><b>Range of values:</b> 0.0 to 3.0</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptAqStrength($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('aq-strength', $value);
        return $this;
    }

    /**
     * <code>--qg-size <64|32|16></code>
     * 
     * <p>Enable adaptive quantization for sub-CTUs. This parameter specifies
     * the minimum CU size at which QP can be adjusted, ie. Quantization Group
     * size. Allowed range of values are 64, 32, 16 provided this falls within
     * the inclusive range [maxCUSize, minCUSize]. Experimental.
     * Default: same as maxCUSize</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptQgSize($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('qg-size', $value);
        return $this;
    }

    /**
     * <code>--cutree, --no-cutree</code>
     * 
     * <p>Enable the use of lookahead’s lowres motion vector fields to
     * determine the amount of reuse of each block to tune adaptive
     * quantization factors. CU blocks which are heavily reused as motion
     * reference for later frames are given a lower QP (more bits) while CU
     * blocks which are quickly changed and are not referenced are given
     * less bits. This tends to improve detail in the backgrounds of video
     * with less detail in areas of high motion. Default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleCutree($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('cutree');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-cutree');
        }
        return $this;
    }

    /**
     * <code>--pass <integer></code>
     * 
     * <p>Enable multi-pass rate control mode. Input is encoded multiple times,
     * storing the encoded information of each pass in a stats file from which
     * the consecutive pass tunes the qp of each frame to improve the quality
     * of the output. Default disabled</p>
     * <ol>
     * <li>First pass, creates stats file</li>
     * <li>Last pass, does not overwrite stats file</li>
     * <li>Nth pass, overwrites stats file</li>
     * </ol>
     * <p><b>Range of values:</b> 1 to 3</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptPass($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('pass', $value);
        return $this;
    }

    /**
     * <code>--stats <filename></code>
     * 
     * <p>Specify file name of of the multi-pass stats file. If unspecified
     * the encoder will use x265_2pass.log</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptStats($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('stats', $value);
        return $this;
    }

    /**
     * <code>--slow-firstpass, --no-slow-firstpass</code>
     * 
     * <p>Enable a slow and more detailed first pass encode in multi-pass rate
     * control mode.  Speed of the first pass encode is slightly lesser and
     * quality midly improved when compared to the default settings in a
     * multi-pass encode. Default disabled (turbo mode enabled)</p>
     * <p>When <b>turbo</b> first pass is not disabled, these options are
     * set on the first pass to improve performance:</p>
     * <ul>
     * <li><code>--fast-intra</code></li>
     * <li><code>--no-rect</code></li>
     * <li><code>--no-amp</code></li>
     * <li><code>--early-skip</code></li>
     * <li><code>--ref</code> = 1</li>
     * <li><code>--max-merge</code> = 1</li>
     * <li><code>--me</code> = DIA</li>
     * <li><code>--subme</code> = MIN(2, <code>--subme</code>)</li>
     * <li><code>--rd</code> = MIN(2, <code>--rd</code>)</li>
     * </ul>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleSlowFirstpass($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('slow-firstpass');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-slow-firstpass');
        }
        return $this;
    }

    /**
     * <code>--strict-cbr, --no-strict-cbr</code>
     * 
     * <p>Enables stricter conditions to control bitrate deviance from the
     * target bitrate in ABR mode. Bit rate adherence is prioritised
     * over quality. Rate tolerance is reduced to 50%. Default disabled.</p>
     * <p>This option is for use-cases which require the final average bitrate
     * to be within very strict limits of the target; preventing overshoots,
     * while keeping the bit rate within 5% of the target setting,
     * especially in short segment encodes. Typically, the encoder stays
     * conservative, waiting until there is enough feedback in terms of
     * encoded frames to control QP. strict-cbr allows the encoder to be
     * more aggressive in hitting the target bitrate even for short segment
     * videos. Experimental.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleStrictCbr($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('strict-cbr');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-strict-cbr');
        }
        return $this;
    }

    /**
     * <code>--cbqpoffs <integer></code>
     * 
     * <p>Offset of Cb chroma QP from the luma QP selected by rate control.
     * This is a general way to spend more or less bits on the chroma
     * channel.  Default 0</p>
     * <p><b>Range of values:</b> -12 to 12</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptCbqpoffs($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('cbqpoffs', $value);
        return $this;
    }

    /**
     * <code>--crqpoffs <integer></code>
     * 
     * <p>Offset of Cr chroma QP from the luma QP selected by rate control.
     * This is a general way to spend more or less bits on the chroma
     * channel.  Default 0</p>
     * <p><b>Range of values:</b>  -12 to 12</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptCrqpoffs($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('crqpoffs', $value);
        return $this;
    }

    /**
     * <code>--ipratio <float></code>
     * 
     * <p>QP ratio factor between I and P slices. This ratio is used in all of
     * the rate control modes. Some <code>--tune</code> options may change the
     * default value. It is not typically manually specified. Default 1.4</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptIpratio($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('ipratio', $value);
        return $this;
    }

    /**
     * <code>--pbratio <float></code>
     * 
     * <p>QP ratio factor between P and B slices. This ratio is used in all of
     * the rate control modes. Some <code>--tune</code> options may change the
     * default value. It is not typically manually specified. Default 1.3</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptPbratio($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('pbratio', $value);
        return $this;
    }

    /**
     * <code>--qcomp <float></code>
     * 
     * <p>qComp sets the quantizer curve compression factor. It weights the
     * frame quantizer based on the complexity of residual (measured by
     * lookahead).  Default value is 0.6. Increasing it to 1 will
     * effectively generate CQP</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptQcomp($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('qcomp', $value);
        return $this;
    }

    /**
     * <code>--qpstep <integer></code>
     * 
     * <p>The maximum single adjustment in QP allowed to rate control. Default
     * 4</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptQpstep($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('qpstep', $value);
        return $this;
    }

    /**
     * <code>--rc-grain, --no-rc-grain</code>
     * 
     * <p>Enables a specialised ratecontrol algorithm for film grain content. This
     * parameter strictly minimises QP fluctuations within and across frames
     * and removes pulsing of grain. Default disabled.
     * Enabled when :option:’–tune’ grain is applied. It is highly recommended
     * that this option is used through the tune grain feature where a combination
     * of param options are used to improve visual quality.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleRcGrain($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('rc-grain');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-rc-grain');
        }
        return $this;
    }

    /**
     * <code>--qblur <float></code>
     * 
     * <p>Temporally blur quants. Default 0.5</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptQblur($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('qblur', $value);
        return $this;
    }

    /**
     * <code>--cplxblur <float></code>
     * 
     * <p>temporally blur complexity. default 20</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptCplxblur($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('cplxblur', $value);
        return $this;
    }

    /**
     * <code>--zones <zone0>/<zone1>/...</code>
     * 
     * <p>Tweak the bitrate of regions of the video. Each zone takes the form:</p>
     * <p><start frame>,<end frame>,<option> where <option> is either q=<integer>
     * (force QP) or b=<float> (bitrate multiplier).</p>
     * <p>If zones overlap, whichever comes later in the list takes precedence.
     * Default none</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptZones($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('zones', $value);
        return $this;
    }

    /**
     * <code>--signhide, --no-signhide</code>
     * 
     * <p>Hide sign bit of one coeff per TU (rdo). The last sign is implied.
     * This requires analyzing all the coefficients to determine if a sign
     * must be toggled, and then to determine which one can be toggled with
     * the least amount of distortion. Default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleSignhide($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('signhide');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-signhide');
        }
        return $this;
    }

    /**
     * <code>--qpfile <filename></code>
     * 
     * <p>Specify a text file which contains frametypes and QPs for some or
     * all frames. The format of each line is:</p>
     * <p>framenumber frametype QP</p>
     * <p>Frametype can be one of [I,i,K,P,B,b]. <b>B</b> is a referenced B frame,
     * <b>b</b> is an unreferenced B frame.  <b>I</b> is a keyframe (random
     * access point) while <b>i</b> is an I frame that is not a keyframe
     * (references are not broken). <b>K</b> implies <b>I</b> if closed_gop option
     * is enabled, and <b>i</b> otherwise.</p>
     * <p>Specifying QP (integer) is optional, and if specified they are
     * clamped within the encoder to qpmin/qpmax.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptQpfile($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('qpfile', $value);
        return $this;
    }

    /**
     * <code>--scaling-list <filename></code>
     * 
     * <p>Quantization scaling lists. HEVC supports 6 quantization scaling
     * lists to be defined; one each for Y, Cb, Cr for intra prediction and
     * one each for inter prediction.</p>
     * <p>x265 does not use scaling lists by default, but this can also be
     * made explicit by <code>--scaling-list</code> <em>off</em>.</p>
     * <p>HEVC specifies a default set of scaling lists which may be enabled
     * without requiring them to be signaled in the SPS. Those scaling
     * lists can be enabled via <code>--scaling-list</code> <em>default</em>.</p>
     * <p>All other strings indicate a filename containing custom scaling
     * lists in the HM format. The encode will abort if the file is not
     * parsed correctly. Custom lists must be signaled in the SPS</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptScalingList($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('scaling-list', $value);
        return $this;
    }

    /**
     * <code>--lambda-file <filename></code>
     * 
     * <p>Specify a text file containing values for x265_lambda_tab and
     * x265_lambda2_tab. Each table requires MAX_MAX_QP+1 (70) float
     * values.</p>
     * <p>The text file syntax is simple. Comma is considered to be
     * white-space. All white-space is ignored. Lines must be less than 2k
     * bytes in length. Content following hash (#) characters are ignored.
     * The values read from the file are logged at <code>--log-level</code>
     * debug.</p>
     * <p>Note that the lambda tables are process-global and so the new values
     * affect all encoders running in the same process.</p>
     * <p>Lambda values affect encoder mode decisions, the lower the lambda
     * the more bits it will try to spend on signaling information (motion
     * vectors and splits) and less on residual. This feature is intended
     * for experimentation.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptLambdaFile($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('lambda-file', $value);
        return $this;
    }

    /**
     * <code>--deblock=<int>:<int>, --no-deblock</code>
     * 
     * <p>Toggle deblocking loop filter, optionally specify deblocking
     * strength offsets.</p>
     * <p><int>:<int> - parsed as tC offset and Beta offset
     * <int>,<int> - parsed as tC offset and Beta offset
     * <int>       - both tC and Beta offsets assigned the same value</p>
     * <p>If unspecified, the offsets default to 0. The offsets must be in a
     * range of -6 (lowest strength) to 6 (highest strength).</p>
     * <p>To disable the deblocking filter entirely, use –no-deblock or
     * –deblock=false. Default enabled, with both offsets defaulting to 0</p>
     * <p>If deblocking is disabled, or the offsets are non-zero, these
     * changes from the default configuration are signaled in the PPS.</p>
     * 
     * @param type $toggleValue
     * @return static
     */
    public function setOptToggleDeblock($toggleValue)
    {
        if (false === $toggleValue)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-deblock');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOption('deblock', $toggleValue);
        }
        return $this;
    }

    /**
     * <code>--sao, --no-sao</code>
     * 
     * <p>Toggle Sample Adaptive Offset loop filter, default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleSao($toggle = true)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('sao');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-sao');
        }
        return $this;
    }

    /**
     * <code>--sao-non-deblock, --no-sao-non-deblock</code>
     * 
     * <p>Specify how to handle depencency between SAO and deblocking filter.
     * When enabled, non-deblocked pixels are used for SAO analysis. When
     * disabled, SAO analysis skips the right/bottom boundary areas.
     * Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleSaoNonDeblock($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('sao-non-deblock');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-sao-non-deblock');
        }
        return $this;
    }

    /**
     * <code>--sar <integer|w:h></code>
     * 
     * <p>Sample Aspect Ratio, the ratio of width to height of an individual
     * sample (pixel). The user may supply the width and height explicitly
     * or specify an integer from the predefined list of aspect ratios
     * defined in the HEVC specification.  Default undefined (not signaled)</p>
     * <ol>
     * <li>1:1 (square)</li>
     * <li>12:11</li>
     * <li>10:11</li>
     * <li>16:11</li>
     * <li>40:33</li>
     * <li>24:11</li>
     * <li>20:11</li>
     * <li>32:11</li>
     * <li>80:33</li>
     * <li>18:11</li>
     * <li>15:11</li>
     * <li>64:33</li>
     * <li>160:99</li>
     * <li>4:3</li>
     * <li>3:2</li>
     * <li>2:1</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptSar($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('sar', $value);
        return $this;
    }

    /**
     * <code>--display-window <left,top,right,bottom></code>
     * 
     * <p>Define the (overscan) region of the image that does not contain
     * information because it was added to achieve certain resolution or
     * aspect ratio (the areas are typically black bars). The decoder may
     * be directed to crop away this region before displaying the images
     * via the <code>--overscan</code> option.  Default undefined (not
     * signaled).</p>
     * <p>Note that this has nothing to do with padding added internally by
     * the encoder to ensure the pictures size is a multiple of the minimum
     * coding unit (4x4). That padding is signaled in a separate
     * “conformance window” and is not user-configurable.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptDisplayWindow($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('display-window', $value);
        return $this;
    }

    /**
     * <code>--overscan <show|crop></code>
     * 
     * <p>Specify whether it is appropriate for the decoder to display or crop
     * the overscan area. Default unspecified (not signaled)</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptOverscan($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('overscan', $value);
        return $this;
    }

    /**
     * <code>--videoformat <integer|string></code>
     * 
     * <p>Specify the source format of the original analog video prior to
     * digitizing and encoding. Default undefined (not signaled)</p>
     * <ol start="0">
     * <li>component</li>
     * <li>pal</li>
     * <li>ntsc</li>
     * <li>secam</li>
     * <li>mac</li>
     * <li>undefined</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptVideoformat($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('videoformat', $value);
        return $this;
    }

    /**
     * <code>--range <full|limited></code>
     * 
     * <p>Specify output range of black level and range of luma and chroma
     * signals. Default undefined (not signaled)</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptRange($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('range', $value);
        return $this;
    }

    /**
     * <code>--colorprim <integer|string></code>
     * 
     * <p>Specify color primaries to use when converting to RGB. Default
     * undefined (not signaled)</p>
     * <ol>
     * <li>bt709</li>
     * <li>undef</li>
     * <li><b>reserved</b></li>
     * <li>bt470m</li>
     * <li>bt470bg</li>
     * <li>smpte170m</li>
     * <li>smpte240m</li>
     * <li>film</li>
     * <li>bt2020</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptColorprim($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('colorprim', $value);
        return $this;
    }

    /**
     * <code>--transfer <integer|string></code>
     * 
     * <p>Specify transfer characteristics. Default undefined (not signaled)</p>
     * <ol>
     * <li>bt709</li>
     * <li>undef</li>
     * <li><b>reserved</b></li>
     * <li>bt470m</li>
     * <li>bt470bg</li>
     * <li>smpte170m</li>
     * <li>smpte240m</li>
     * <li>linear</li>
     * <li>log100</li>
     * <li>log316</li>
     * <li>iec61966-2-4</li>
     * <li>bt1361e</li>
     * <li>iec61966-2-1</li>
     * <li>bt2020-10</li>
     * <li>bt2020-12</li>
     * <li>smpte-st-2084</li>
     * <li>smpte-st-428</li>
     * <li>arib-std-b67</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptTransfer($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('transfer', $value);
        return $this;
    }

    /**
     * <code>--colormatrix <integer|string></code>
     * 
     * <p>Specify color matrix setting i.e set the matrix coefficients used in
     * deriving the luma and chroma. Default undefined (not signaled)</p>
     * <ol start="0">
     * <li>GBR</li>
     * <li>bt709</li>
     * <li>undef</li>
     * <li><b>reserved</b></li>
     * <li>fcc</li>
     * <li>bt470bg</li>
     * <li>smpte170m</li>
     * <li>smpte240m</li>
     * <li>YCgCo</li>
     * <li>bt2020nc</li>
     * <li>bt2020c</li>
     * </ol>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptColormatrix($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('colormatrix', $value);
        return $this;
    }

    /**
     * <code>--chromaloc <0..5></code>
     * 
     * <p>Specify chroma sample location for 4:2:0 inputs. Consult the HEVC
     * specification for a description of these values. Default undefined
     * (not signaled)</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptChromaloc($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('chromaloc', $value);
        return $this;
    }

    /**
     * <code>--master-display <string></code>
     * 
     * <p>SMPTE ST 2086 mastering display color volume SEI info, specified as
     * a string which is parsed when the stream header SEI are emitted. The
     * string format is “G(%hu,%hu)B(%hu,%hu)R(%hu,%hu)WP(%hu,%hu)L(%u,%u)”
     * where %hu are unsigned 16bit integers and %u are unsigned 32bit
     * integers. The SEI includes X,Y display primaries for RGB channels
     * and white point (WP) in units of 0.00002 and max,min luminance (L)
     * values in units of 0.0001 candela per meter square. (HDR)</p>
     * <p>Example for a P3D65 1000-nits monitor, where G(x=0.264, y=0.690),
     * B(x=0.150, y=0.060), R(x=0.680, y=0.320), WP(x=0.3127, y=0.3290),
     * L(max=1000, min=0.0001):</p>
     * <blockquote>
     * G(13250,34500)B(7500,3000)R(34000,16000)WP(15635,16450)L(10000000,1)</blockquote>
     * <p>Note that this string value will need to be escaped or quoted to
     * protect against shell expansion on many platforms. No default.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptMasterDisplay($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('master-display', $value);
        return $this;
    }

    /**
     * <code>--max-cll <string></code>
     * 
     * <p>Maximum content light level (MaxCLL) and maximum frame average light
     * level (MaxFALL) as required by the Consumer Electronics Association
     * 861.3 specification.</p>
     * <p>Specified as a string which is parsed when the stream header SEI are
     * emitted. The string format is “%hu,%hu” where %hu are unsigned 16bit
     * integers. The first value is the max content light level (or 0 if no
     * maximum is indicated), the second value is the maximum picture
     * average light level (or 0). (HDR)</p>
     * <p>Example for MaxCLL=1000 candela per square meter, MaxFALL=400
     * candela per square meter:</p>
     * <blockquote>
     * –max-cll “1000,400”
     * </blockquote>
     * <p>Note that this string value will need to be escaped or quoted to
     * protect against shell expansion on many platforms. No default.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptMaxCll($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('max-cll', $value);
        return $this;
    }

    /**
     * <code>--min-luma <integer></code>
     * 
     * <p>Minimum luma value allowed for input pictures. Any values below min-luma
     * are clipped. Experimental. No default.</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptMinLuma($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('min-luma', $value);
        return $this;
    }

    /**
     * <code>--max-luma <integer></code>
     * 
     * <p>Maximum luma value allowed for input pictures. Any values above max-luma
     * are clipped. Experimental. No default.</p>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptMaxLuma($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('max-luma', $value);
        return $this;
    }

    /**
     * <code>--repeat-headers, --no-repeat-headers</code>
     * 
     * <p>If enabled, x265 will emit VPS, SPS, and PPS headers with every
     * keyframe. This is intended for use when you do not have a container
     * to keep the stream headers for you and you want keyframes to be
     * random access points. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleRepeatHeaders($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('repeat-headers');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-repeat-headers');
        }
        return $this;
    }

    /**
     * <code>--aud, --no-aud</code>
     * 
     * <p>Emit an access unit delimiter NAL at the start of each slice access
     * unit. If <code>--repeat-headers</code> is not enabled (indicating the
     * user will be writing headers manually at the start of the stream)
     * the very first AUD will be skipped since it cannot be placed at the
     * start of the access unit, where it belongs. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleAud($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('aud');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-aud');
        }
        return $this;
    }

    /**
     * <code>--hrd, --no-hrd</code>
     * 
     * <p>Enable the signalling of HRD parameters to the decoder. The HRD
     * parameters are carried by the Buffering Period SEI messages and
     * Picture Timing SEI messages providing timing information to the
     * decoder. Default disabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleHrd($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('hrd');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-hrd');
        }
        return $this;
    }

    /**
     * <code>--info, --no-info</code>
     * 
     * <p>Emit an informational SEI with the stream headers which describes
     * the encoder version, build info, and encode parameters. This is very
     * helpful for debugging purposes but encoding version numbers and
     * build info could make your bitstreams diverge and interfere with
     * regression testing. Default enabled</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleInfo($toggle = true)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('info');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-info');
        }
        return $this;
    }

    /**
     * <code>--hash <integer></code>
     * 
     * <p>Emit decoded picture hash SEI, so the decoder may validate the
     * reconstructed pictures and detect data loss. Also useful as a
     * debug feature to validate the encoder state. Default None</p>
     * <ol>
     * <li>MD5</li>
     * <li>CRC</li>
     * <li>Checksum</li>
     * </ol>
     * 
     * @patam int $value
     * @return static
     */
    public function setOptHash($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('hash', $value);
        return $this;
    }

    /**
     * <code>--temporal-layers,--no-temporal-layers</code>
     * 
     * <p>Enable a temporal sub layer. All referenced I/P/B frames are in the
     * base layer and all unreferenced B frames are placed in a temporal
     * enhancement layer. A decoder may chose to drop the enhancement layer
     * and only decode and display the base layer slices.</p>
     * <p>If used with a fixed GOP (<code>b-adapt</code> 0) and <code>bframes</code>
     * 3 then the two layers evenly split the frame rate, with a cadence of
     * PbBbP. You probably also want <code>--no-scenecut</code> and a keyframe
     * interval that is a multiple of 4.</p>
     * 
     * @param boolean $toggle
     * @return static
     */
    public function setOptToggleTemporalLayers($toggle = false)
    {
        if ($toggle)
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('temporal-layers');
        }
        else
        {
            $this->getDefaultOptionGroup()
                ->addOptionWithNoValue('no-temporal-layers');
        }
        return $this;
    }

    /**
     * <code>--recon, -r <filename></code>
     * 
     * <p>Output file containing reconstructed images in display order. If the
     * file extension is ”.y4m” the file will contain a YUV4MPEG2 stream
     * header and frame headers. Otherwise it will be a raw YUV file in the
     * encoder’s internal bit depth.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptRecon($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('recon', $value);
        return $this;
    }

    /**
     * <code>--recon-depth <integer></code>
     * 
     * <p>Bit-depth of output file. This value defaults to the internal bit
     * depth and currently cannot to be modified.</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptReconDepth($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('recon-depth', $value);
        return $this;
    }

    /**
     * <code>--recon-y4m-exec <string></code>
     * 
     * <p>If you have an application which can play a Y4MPEG stream received
     * on stdin, the x265 CLI can feed it reconstructed pictures in display
     * order.  The pictures will have no timing info, obviously, so the
     * picture timing will be determined primarily by encoding elapsed time
     * and latencies, but it can be useful to preview the pictures being
     * output by the encoder to validate input settings and rate control
     * parameters.</p>
     * <p>Example command for ffplay (assuming it is in your PATH):</p>
     * <p>–recon-y4m-exec “ffplay -i pipe:0 -autoexit”</p>
     * 
     * @patam type $value
     * @return static
     */
    public function setOptReconY4mExec($value)
    {
        $this->getDefaultOptionGroup()
            ->addOption('recon-y4m-exec', $value);
    }

}
