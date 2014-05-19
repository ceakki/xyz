<?php
  
  // Declare inetrval
  declare(ticks=1);
  
  // Mark start time
  $GLOBALS['tick_stamp'] = time();
  $GLOBALS['tick_time']  = microtime(True);
  $GLOBALS['tick_slow']  = 0.01;
  
  // The handler function
  function tick_handler() {
    // Report every 0.01 seconds
    if($GLOBALS['tick_time'] < (microtime(True) - $GLOBALS['tick_slow'])) {
      // Trace
      $trace = debug_backtrace();
      file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . "tick_" . $GLOBALS['tick_stamp'] . ".log", "TICK: " . date('D, d m Y H:i:s:') . substr(str_replace(".", "", strstr(microtime(True), ".")), 0, 3) . ": " . $trace[0]['file'] . "[" . $trace[0]['line'] . "]\r\n", FILE_APPEND);
    }
    // Update timer
    $GLOBALS['tick_time'] = microtime(true);
  }
  
  // Register the function
  register_tick_function('tick_handler');
  
