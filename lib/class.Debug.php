<?php
/**
 * debug functions that can be used in any php application
 * Copyright (C) 2011 Tamara Temple
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @version 2011-06-19
 * @copyright Tamara Temple Development, 19 June, 2011
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package commoncode
 **/






/**
 * Debug - set up a class for debugging statements. Simple, but in OO!
 * 
 * @author Tamara Temple <tamara@tamaratemple.com>
 * @package commoncode
 */
class Debug
{
  /**
   * flag to indicate whether we're in a debugging session or not
   * 
   * This variable holds the state of whether we are in a debugging session or not. The Debug object
   * can set this on instantiation, or later through the on() pseudo-method.
   *
   * @var string
   **/
  private $debugflag = TRUE;
	
  /**
   * flag to indicate whether the print method should also emit HTML tags around the various parts.
   *
   * @var string
   **/
  private $nohtml = FALSE;
	
  /**
   * prefix to emit before debugging data
   * 
   * This variable is to be used to customize whatever code is needed to set up the debug data environment.
   * Typical possibilities include div or p opening with appropriat class specifications:
   *   '<p class="debug">' for example. 
   * 
   * If the nohtml flag is set to TRUE, the prefix and suffix will not be emitted.
   *
   * @var string
   **/
  private $prefix = '<p class="debug">';

  /**
   * suffix to emit after debugging data
   *
   * This is the companion variable to $prefix above. Set it to close whatever you've opened in the
   * prefix, such as '</p>' in the example above. If this is empty or not set, nothing will be emitted.
   * 
   * @var string
   **/
  private $suffix = '</p>';

  /**
   * log file for sending debug output to, as well as stdout
   * 
   * Should be a full path from /
   * If this is empty or not set, the error will be logged to the standard php logging facility.
   * If this is set to -1, no logging is performed.
   *
   * @var string
   **/
  private $errorlog = '';

  /**
   * flag to indicate whether debug output should be saved instead of printed.
   *
   * @var boolean
   **/
  private $hold = FALSE;

  /**
   * array holding debug output for later retrieval. Used if hold is true
   *
   * @var array
   **/
  private $heldmessages = array();

  /**
   * contructor - initialize object when called with $dbg = new Debug('prefix','suffix','errorlog')
   * 
   * @param bool (optional) debugflag - controls whether debugging is turned on or off. If omitted, set to true
   * @param bool (optional) nohtml - flag determining whether debug should emit html with it's messages, or just plain text.
   * @param string (optional) errorlog - full path name to error log file to receive debugging log messages
   * @param string (optional) prefix - the prefix to emit before the debugging data
   * @param string (optional) suffix - the suffix to emit after debugging data
   * @return object - returns the new Debug object
   * @author Tamara Temple
   */
  function __construct($debugflag=TRUE,$nohtml=FALSE,$errorlog=NULL,$hold=FALSE,$prefix=NULL,$suffix=NULL)
  {
    $this->debugflag = isset($debugflag)?$debugflag:TRUE;
    if ($debugflag) self::set_dbg_env();
    $this->nohtml = isset($nohtml)?$nohtml:FALSE;
    ini_set('html_errors',(($this->nohtml)?'off':'on'));
    $this->prefix = isset($prefix)?$prefix:'<p class="debug">';
    $this->suffix = isset($suffix)?$suffix:'</p>';
    $this->errorlog = isset($errorlog)&&
      ((is_dir(dirname($errorlog))&&is_writable($errorlog)) ||
       ($errorlog = "-1"))?$errorlog:NULL;
    $this->hold = isset($hold)?$hold:FALSE;
  }


  /**
   * anonymous calling function to enable simple pseudo-methods
   *
   * @method void on() - turns debugging on
   * @method void off() - turns debugging off
   * @method bool is_on() - returns state of debugflag
   * @method void setsurrounds(prefix,suffix) - sets the value of prefix and suffix
   * @method void setlog(errorlog) - sets the value of error log. Must be fully-qualified, writeable file, empty string to set logging to php's logger, or -1 to turn logging off
   * @method void nohtml(bool) - sets the nohtml flag to TRUE or FALSE
   * @method void hold(bool) - sets the internal hold flag to TRUE or FALSE
   * @method array getMessages() - returns the set of debug messages that have been held in queue
   * @return mixed
   * @author Tamara Temple
   **/
  public function __call($method, $params)
  {
    switch ($method) {
    case 'on':
      $this->debugflag=TRUE;
      self::set_dbg_env();
      break;
    case 'off':
      $this->debugflag=FALSE;
      self::clear_dbg_env();
      break;
    case 'is_on':
      return $this->debugflag;
      break;
    case 'setsurroundings':
      if (count($params) != 2)	throw new Exception(self::$errormessages[1001], 1001);
      if (is_string($params[0])) $this->prefix=$params[0];
      if (is_string($params[1])) $this->suffix=$params[1];
      break;
    case 'setlog':
      if (isset($params)) {
	if (is_string($params[0]) && is_dir(dirname($params[0])) && is_writable($params[0])) $this->errorlog = $params[0];
	if ($params[0] == "-1") $this->errorlog = $params;
	if ($params[0] == '') $this->errorlog = '';
      }
      break;
    case 'nohtml':
      if (empty($params)) return $this->nohtml;
      if (isset($params[0]) && is_bool($params[0])) $this->nohtml = $params[0];
      ini_set('html_errors',(($this->nohtml)?'off':'on'));
      break;
    case 'hold':
      if (empty($params)) return $this->hold;
      if (isset($params[0]) && is_bool($params[0])) $this->hold = $params[0];
      break;
    case 'debug':
    case 'debug_var':
      /* depricated functions, use p instead */
      error_log(self::$errormessages[1002]);
      call_user_func_array(array($this,'p'), $params);
      break;
    case 'getMessages':
      return $this->heldmessages;
      break;
    default:
      # code...
	break;
    }
  }



  /**
   * print function - print a message if DEBUG === TRUE
   *
   * @param string msg - the debugging message to emit
   * @param mixed (optional) var - a variable to show the contents of. If not a scalar, the output will be dumped from print_r instead
   * @param string file - name of file debug message comes from. This can easily be set with the magic constant __FILE__
   * @param string line - line of the file where the debug message is sent from. This can easily be set with the magic constant __LINE__
   * @return void
   * @author Tamara Temple <tamara@tamaratemple.com>
   *
   * CHANGED: made function a bit more useful by being the ONLY debug function to call, and to allow $var, $file, and $line to be optional parameters. If $var is an array, it will print out via print_r, otherwise it's just echoed as is. $file and $line are used to supply __FILE__ and __LINE__ parameters specifically. This is possibly prettier than making every debug call look like >> debug(basename(__FILE__).'@'.__LINE__.' '."message"); << as it will now read as: >> debug("message",'',__FILE__,__LINE__); << instead.
   * CHANGED name is now p instead of debug
   *
   *
   **/
  public function p($msg,$var='',$file='',$line='')
  {
    if (!$this->debugflag) return;
    if (!empty($file)) $file = basename($file);
    $out = 'DEBUG: ';
    if (!empty($file)) $out .= $file;
    if (!empty($line)) $out .= '@'.$line;
    $out .= ': '.$msg.PHP_EOL;
    if (FALSE === $var) {
      $out .= 'FALSE';
    } elseif (NULL === $var) {
      $out .= 'NULL';
    } elseif (0 === $var) {
      $out .= $var.' (zero)';
    } elseif (!empty($var)) {
      if (is_array($var) || is_object($var)) {
	if ($this->nohtml) {
	  $out .= print_r($var,true);
	} else {
	  $out .= '<pre>' . htmlspecialchars(print_r($var,true)) . '</pre>';				
	}
      } else {
	$out .= htmlspecialchars($var);
      }
      $out .= PHP_EOL;
    }
    if ($this->hold) {
      $this->heldmessages[] = $out; // hold message until later
    } else {
      if ($this->nohtml) {
	echo $out;
      } else {
	echo $this->prefix.PHP_EOL;
	echo $out;
	echo $this->suffix.PHP_EOL;
      }
    }

    if ($this->errorlog != "-1") {
      if (is_string($this->errorlog)){
	error_log($out,3,$this->errorlog);
      } else {
	error_log($out);
      }
    }
  }

  /**
   * set up the debug environment
   *
   * @return void
   * @author Tamara Temple <tamara@tamaratemple.com>
   **/
  function set_dbg_env()
  {
    // set these for development and testing
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors','on');
    ini_set('display_startup_errors','on');
    ini_set('html_errors',(($this->nohtml)?'off':'on'));
    ini_set('docref_root','http://www.php.net/manual/en/');
  }

  /**
   * reset debugging environment
   *
   * @return void
   * @author Tamara Temple <tamara@tamaratemple.com>
   **/
  function clear_dbg_env()
  {
    error_reporting(E_ALL & ~E_DEPRECATED);
    ini_set('display_errors','off');
    ini_set('display_startup_errors','off');
    ini_set('html_errors',(($this->nohtml)?'off':'on'));
    ini_set('docref_root','http://www.php.net/manual/en/');
  }


  /* set these up in the future hope of i18n */
  private static $errormessages = array(
					1001=>'setsurroundings must be called with two parameters',
					1002=>'debug and debug_var are depricated functions, use p instead',
					);

}
