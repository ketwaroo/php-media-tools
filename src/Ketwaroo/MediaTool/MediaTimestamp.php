<?php


namespace Ketwaroo\MediaTool;

/**
 * Description of Timestamp
 *
 * @author Yaasir Ketwaroo
 */
class MediaTimestamp {

    protected $hour = 0,
            $minute = 0,
            $second = 0,
            $millisecond = 0;
    protected $totalMilliseconds = 0;
    protected $isNegative = false;

    const millisec_per_hour = 3600000;
    const millisec_per_minute = 60000;
    const millisec_per_second = 1000;

    /**
     * 
     * @param string $timestamp
     * @throws \InvalidArgumentException
     */
    public function __construct($timestamp = '00.000') {
        if (!preg_match('~^\-?(?:\d+\:)?(?:\d\d\:)?\d\d(?:\.\d\d\d)?$~', $timestamp)) {
            throw new \InvalidArgumentException("{$timestamp} not valid video timestamp format of hh:mm:ss.lll");
        }

        $this->populateFromMillisec($this->stringToMilliseconds($timestamp));
    }

    /**
     * 
     * @param type $timestamp
     * @return type
     */
    protected function stringToMilliseconds($timestamp) {
        $tmp = explode(':', $timestamp);

        while (count($tmp) < 3) {
            array_unshift($tmp, 0);
        }

        $isNegative = min($tmp) < 0;

        list($hour, $minute, $secondMilli) = $tmp;

        $totalMilliseconds = intval(abs(floatval($secondMilli) * static::millisec_per_second));
        $totalMilliseconds += abs(intval($minute)) * static::millisec_per_minute;
        $totalMilliseconds += abs(intval($hour)) * static::millisec_per_hour;

        return (($isNegative) ? -1 : 1) * $totalMilliseconds;
    }

    /**
     * 
     * @param int $millisec
     */
    public function populateFromMillisec($millisec) {
        $millisec = intval($millisec);
        $this->totalMilliseconds = $millisec;
        $this->isNegative = $millisec < 0;
        $millisec = abs($millisec);
        $this->millisecond = $millisec % static::millisec_per_second;
        $this->hour = intval($millisec / static::millisec_per_hour);
        $this->minute = intval(($millisec % static::millisec_per_hour) / static::millisec_per_minute);
        $this->second = intval(($millisec % static::millisec_per_minute) / static::millisec_per_second);
    }

    /**
     * 
     * @param int $millisec
     * @return static
     */
    public static function fromMillisec($millisec) {
        $mt = new static;
        $mt->populateFromMillisec($millisec);
        return $mt;
    }

    /**
     * 
     * @param \Ketwaroo\MediaTool\MediaTimestamp $add
     * @return static
     */
    public function add(MediaTimestamp $add) {
        $new = clone $this;

        $new->populateFromMillisec($new->getTotalMilliseconds() + $add->getTotalMilliseconds());

        return $new;
    }

    /**
     * 
     * @param \Ketwaroo\MediaTool\MediaTimestamp $sub
     * @return static
     */
    public function subtract(MediaTimestamp $sub) {
        $new = clone $this;

        $new->populateFromMillisec($new->getTotalMilliseconds() - $sub->getTotalMilliseconds());

        return $new;
    }

    /**
     * 
     * @param type $mult
     * @return static
     */
    public function multiply($mult) {
        $new = clone $this;

        $new->populateFromMillisec($new->getTotalMilliseconds() * $mult);

        return $new;
    }

    /**
     * 
     * @param type $div
     * @return static
     */
    public function divide($div) {
        $new = clone $this;

        $new->populateFromMillisec($new->getTotalMilliseconds() / $div);

        return $new;
    }

    /**
     * 
     * @return string
     */
    public function __toString() {
        return ($this->isNegative ? '-' : '')
                . str_pad("{$this->hour}", 2, '0', STR_PAD_LEFT)
                . ':' . str_pad("{$this->minute}", 2, '0', STR_PAD_LEFT)
                . ':' . str_pad("{$this->second}", 2, '0', STR_PAD_LEFT)
                . '.' . str_pad("{$this->millisecond}", 3, '0', STR_PAD_LEFT);
    }

    /**
     * 
     * @return int
     */
    function getHour() {
        return $this->hour;
    }

    function getMinute() {
        return $this->minute;
    }

    function getSecond() {
        return $this->second;
    }

    function getMillisecond() {
        return $this->millisecond;
    }

    function getTotalMilliseconds() {
        return $this->totalMilliseconds;
    }

    function getIsNegative() {
        return $this->isNegative;
    }

}
