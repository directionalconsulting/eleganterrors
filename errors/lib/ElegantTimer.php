<?php
/**
 * Simple ElegantTimer, useful for timing PHP code execution, includes split times
 *
 * Example use:
 *    $ElegantTimer = new ElegantTimer;
 *    ...
 *    // Pass whatever comment you like
 *    $ElegantTimer->lap("in my_func() at start");
 *     ...
 *    $ElegantTimer->lap("in my_func() in middle");
 *    ...
 *    $ElegantTimer->lap("in my_func() at end");
 *
 * Example output:
 *     in my_func(), at start split time 0.00 seconds
 *     in my_func(), at start elapsed time 0.00 seconds
 *
 *     in my_func(), in middle complete split time 6.49 seconds
 *     in my_func(), in middle complete elapsed time 6.49 seconds
 *
 *   in my_func() at end split time 2.58 seconds
 *   in my_func() at end elapsed time 9.07 seconds
 *
  */
class ElegantTimer extends ElegantErrors {

    //properties
    var $start_time;
    var $stop_time;

    var $lap_times;

    /**
     * Initialise ElegantTimer by starting it going
     **/
    function __construct() {
//        parent::__construct();
        $this->lap_times = array();
        $this->start();
    }

    /**
     * Set start time
     */
    protected function start()
    {
        $this->start_time = $this->get_microtime();
    }

    /**
    /* get_microtime function taken from Everett Michaud on Zend.com
     */
    protected function get_microtime()
    {
        list($secs, $micros) = split(" ", microtime());
        $mt = $secs + $micros;

        return $mt;
    }


    /**
     * Set end time
     */
    protected function stop()
    {
        $this->stop_time = $this->get_microtime();
    }

    /**
     * Get the elapsed time
     */
    protected function get_elapsed()
    {
        $time_now = $this->get_microtime();
        $elapsed = $time_now  -  $this->start_time;

        return $elapsed;
    }

    /**
     * Get the last split (lap) time
     */
    protected function get_last_split()
    {
        $time_now = $this->get_microtime();
        $laps_done = sizeof($this->lap_times);
        if ($laps_done == 0) {
            $split = $time_now - $this->start_time;
        }
        else {
            $split_no = sizeof($this->lap_times) - 1;
            $split = $time_now - $this->lap_times[$split_no];
        }
        $this->lap_times[] = $time_now;

        return $split;
    }

    /**
     * Look at the times (i.e. print it!)
     */
    protected function lap($comment="")
    {
        $split = $this->get_last_split();
        $split = number_format($split, 2);

        $elapsed = $this->get_elapsed();
        $elapsed = number_format($elapsed, 2);

        print "$comment split time $split seconds<br>";
        print "$comment elapsed time $elapsed seconds<br>";
        print "<br>";
        flush();

        return true;

    }

    protected function rendered($comment="")
    {
        $split = $this->get_last_split();
        $split = number_format($split, 2);

        $elapsed = $this->get_elapsed();
        $elapsed = number_format($elapsed, 2);

        print "\n<!--page rendered: $elapsed seconds-->\n";
        flush();
    }

}
?>