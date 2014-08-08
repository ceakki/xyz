<?php

  /**
   * Route
   *
   * URL based routing.
   *
   */
  class Route {

    /**
     * $routes
     *
     * Array that holds all the routes.
     */
    public static $routes = Array();


    /**
     * $route
     *
     * File of the regex that matched. 
     */
    public static $route = false;


    /**
     * $path
     *
     * Array of the URL path folders.
     */
    public static $path = Array();


    /**
     * $params
     *
     * Array of query string parameters.
     */
    public static $params = Array();


    /**
     * $trim
     *
     * String to trim from the begining of the URL path.
     *
     * @syntax  Route::trim('/route');
     */
    public static $trim = '';


    /**
     * Route::set_route()
     *
     * Handler for the routes variable.
     *
     * @syntax  Route::set_route($regex = '', $file = '');
     * @param   string  $regex    Regular expression to amtch against URL.
     * @param   string  $file     File to include on a match.
     */
    static public function set_route($regex = '', $file = '') {
      self::$routes[$regex] = $file;
    }


    /**
     * Route::__construct()
     *
     * Class constructor. This does all the magick.
     *
     * @syntax  Route::__construct();
     * @return  string  File of the regex that matched.
     */
    function __construct() {
      // Parse URL path
      $path = ltrim($_SERVER['REDIRECT_URL'], self::$trim);
      self::$path = explode('/', trim($path, '/'));

      // parse QUERY_STRING
      parse_str($_SERVER['QUERY_STRING'], self::$params);

      // route
      $url = $path . '?' . $_SERVER['QUERY_STRING'];
      foreach(self::$routes AS $regex => $file) {
        if(preg_match($regex, $url)) {
          self::$route = $file;
          break;
        }
      }
    }
  }


  /**
   * Example usage
   */

  // Configuration
  Route::$trim = '/route';
  Route::set_route('/^list/', 'list.php');


  // Routing
  new Route();

  
  // Debug
  echo '<pre>';
  var_dump(Route::$path);
  var_dump(Route::$params);
  var_dump(Route::$route);
