<?php
/**
 * Simple stopwatch, useful for timing PHP code execution, includes split times
 *
 * Example use:
 *    $stopwatch = new stopwatch;
 *    ...
 *    // Pass whatever comment you like
 *    $stopwatch->lap("in my_func() at start");
 *     ...
 *    $stopwatch->lap("in my_func() in middle");
 *    ...
 *    $stopwatch->lap("in my_func() at end");
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
 * @author Hugh Prior    stopwatch@priorwebsites.com
 */
class stopwatch
{
    //properties
    var $start_time;
    var $stop_time;

    var $lap_times;

    /**
     * Initialise stopwatch by starting it going
     */
    function stopwatch()
    {
        $this->start();
        $this->lap_times = array();
    }

    /**
    /* get_microtime function taken from Everett Michaud on Zend.com
     */
    function get_microtime()
    {
        list($secs, $micros) = split(" ", microtime());
        $mt = $secs + $micros;

        return $mt;
    }

    /**
     * Set start time
     */
    function start()
    {
        $this->start_time = $this->get_microtime();
    }

    /**
     * Set end time
     */
    function stop()
    {
        $this->stop_time = $this->get_microtime();
    }

    /**
     * Get the elapsed time
     */
    function get_elapsed()
    {
        $time_now = $this->get_microtime();
        $elapsed = $time_now  -  $this->start_time;

        return $elapsed;
    }

    /**
     * Get the last split (lap) time
     */
    function get_last_split()
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
    function lap($comment="")
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

    function rendered($comment="")
    {
        $split = $this->get_last_split();
        $split = number_format($split, 2);

        $elapsed = $this->get_elapsed();
        $elapsed = number_format($elapsed, 2);

        print "\n<!--page rendered: $elapsed seconds-->\n";
        return;

    }

}
?>