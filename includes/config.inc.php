<?php
  
  ob_start();
  session_start();
  error_reporting(E_ALL);
  set_time_limit(0);
  ini_set('max_execution_time', 0);
  date_default_timezone_set('Africa/Kampala');
  
  // Set SMTP server settings
  ini_set("smtp_server","gracious.crystalwebhosting.com");
  ini_set("smtp_port","465");
  ini_set("sendmail_from","info@ugasolutions.co.ug");
  ini_set("smtp_ssl","ssl"); // Enable SSL/TLS encryption
  
  // Get the file name for the opened page
  $page = explode('/', $_SERVER['PHP_SELF']);
  $page = str_replace("_", " ", $page);
  $page = ucwords(str_replace('.php', '', array_pop($page)));
  
  define('PAGE', $page);
  
  /**
   * Allowed to change
   *
   * You may make any changes here that suite your system configurations
   */
  /*const URL               = 'https://ugasolutions.co.ug';
  const DB_HOST           = 'localhost';
  const DB_USER           = 'ugasolutions_admin';
  const DB_PASS           = '8seU8BZ*Uws32-';
  const DB_NAME           = 'ugasolutions_db';
  const FAVICON           = URL . '/assets/img/favicon.png';*/
  
  const URL               = 'http://localhost/vet/';
  const DB_HOST           = 'p:127.0.0.1';
  const DB_USER           = 'root';
  const DB_PASS           = '';
  const DB_NAME           = 'aaaavet';
  const FAVICON           = URL . 'assets/img/logo.png';
  
  const COLOR             = 'primary';
  const SECONDCOLOR       = "info";
  const COPYRIGHTYEAR     = "2019";
  const SYSTEM            = "VET INVENTORY SYSTEM";
  const DEVELOPER         = "Gramaxic";
  const DEVELOPER_EMAIL   = 'gramaxicltd@gmail.com';
  const DEVELOPER_WEBSITE = "https://gramaxic.com";
  const DEVELOPERPHONE    = "+256 777 088 750 / +256 707 240 543";
  const WEBSITE           = URL;
  const VERSION           = "2.3";
  const HEADTEACHER       = "Ssekiziyivu Godfrey";
  const TEST              = "TTZ6cm5RZWljU3BwTnYyckpKRnhCUT09";
  const PRIMARYCOLOR      = "#008000";
  const LIGHTPRIMARYCOLOR = "#00800055";
  
  function privileges()
  {
    // Use View, Update, Enable, Disable and Delete
    return ['Admin' => 'View,Update,Delete'];
  }
  
  /**
   * No more Changes allowed
   */
  
  spl_autoload_register(static function ($classname) {
    $path    = 'classes/';
    $subPath = '../classes/';
    
    $extension = '.class.php';
    
    $fullPath    = $path . $classname . $extension;
    $subFullPath = $subPath . $classname . $extension;
    
    if (file_exists($fullPath)) {
      include_once $fullPath;
    } else {
      include_once $subFullPath;
    }
  });
  
  if (!function_exists('str_contains')) {
    /**
     * Check if a string contains another string.
     *
     * @param string $haystack The string to search within.
     * @param string $needle   The substring to search for within the $haystack.
     *
     * @return bool Returns true if $haystack contains $needle, false otherwise.
     */
    function str_contains(string $haystack, string $needle) {
      return strpos($haystack, $needle) !== false;
    }
  }
  
  // Get user role by directory name
  $list = explode('/', $_SERVER['SCRIPT_NAME']);
  // Remove the page name.php from the array
  array_pop($list);
  // Get the last key which is a folder
  $lops = array_key_last($list);
  // Change the value to the key to small letters the first letter capital to match the role in the database
  if (isset($list[$lops])) {
    $dir = ucwords(strtolower($list[$lops]));
    define('ROLE', $dir);
  }
  
  function yearsCombo($startYear, $endYear)
  {
    $combo = '<div class="form-group">
                <select name="years" id="years" class="select2 custom-select">';
    if ($startYear < $endYear) {
      while ($startYear <= $endYear) {
        $combo .= '<option value="' . $startYear . '">' . $startYear . '</option>';
        $startYear++;
      }
    } else {
      while ($startYear >= $endYear) {
        $combo .= '<option value="' . $startYear . '">' . $startYear . '</option>';
        $startYear--;
      }
    }
    $combo .= "</select></div>";
    
    return $combo;
  }
  
  function yearsComboWithLabel($startYear, $endYear, $labelText)
  {
    $combo = '<div class="form-group">
                <label for="years">' . $labelText . '</label>
                <select name="years" id="years" class="select2 custom-select">';
    if ($startYear < $endYear) {
      while ($startYear <= $endYear) {
        $combo .= '<option value="' . $startYear . '">' . $startYear . '</option>';
        $startYear++;
      }
    } else {
      while ($startYear >= $endYear) {
        $combo .= '<option value="' . $startYear . '">' . $startYear . '</option>';
        $startYear--;
      }
    }
    $combo .= "</select></div>";
    
    return $combo;
  }
  
  function esc($data = null)
  {
    if ($data !== null) {
      return trim(addslashes(htmlspecialchars($data)));
    }
    return null;
  }
  
  $nWords = [
    "zero",
    "one",
    "two",
    "three",
    "four",
    "five",
    "six",
    "seven",
    "eight",
    "nine",
    "ten",
    "eleven",
    "twelve",
    "thirteen",
    "fourteen",
    "fifteen",
    "sixteen",
    "seventeen",
    "eightteen",
    "nineteen",
    "twenty",
    30 => "thirty",
    40 => "fourty",
    50 => "fifty",
    60 => "sixty",
    70 => "seventy",
    80 => "eigthy",
    90 => "ninety",
  ];
  
  function number_to_words($x)
  {
    global $nWords;
    if (!is_numeric($x)) {
      $w = 'Enter numbers please';
    } elseif (fmod($x, 1) != 0) {
      $w = 'Enter numbers please';
    } else {
      if ($x < 0) {
        $w = 'minus ';
        $x = -$x;
      } else {
        $w = '';
      }
      if ($x < 21) {
        $w .= $nWords[$x];
      } elseif ($x < 100) {
        $w .= $nWords[10 * floor($x / 10)];
        $r = fmod($x, 10);
        if ($r > 0) {
          $w .= ' ' . $nWords[$r];
        }
      } elseif ($x < 1000) {
        $w .= $nWords[floor($x / 100)] . ' hundred';
        $r = fmod($x, 100);
        if ($r > 0) {
          $w .= ' ' . number_to_words($r);
        }
      } elseif ($x < 1000000) {
        $w .= number_to_words(floor($x / 1000)) . ' thousand';
        $r = fmod($x, 1000);
        if ($r > 0) {
          $w .= ' ';
          if ($r < 100) {
            $w .= ' ';
          }
          $w .= number_to_words($r);
        }
      } elseif ($x < 1000000000) {
        $w .= number_to_words(floor($x / 1000000)) . ' million';
        $r = fmod($x, 1000000);
        if ($r > 0) {
          $w .= ' ';
          if ($r < 1000) {
            $w .= ' ';
          }
          $w .= number_to_words($r);
        }
      } elseif ($x < 1000000000000) {
        $w .= number_to_words(floor($x / 1000000000)) . ' billion';
        $r = fmod($x, 1000000000);
        if ($r > 0) {
          $w .= ' ';
          if ($r < 1000) {
            $w .= ' ';
          }
          $w .= number_to_words($r);
        }
      } elseif ($x < 1000000000000000) {
        $w .= number_to_words(floor($x / 1000000000000)) . ' trillion';
        $r = fmod($x, 1000000000000);
        if ($r > 0) {
          $w .= ' ';
          if ($r < 1000) {
            $w .= ' ';
          }
          $w .= number_to_words($r);
        }
      } elseif ($x < 1000000000000000000) {
        $w .= number_to_words(floor($x / 1000000000000000)) . ' quadrillion';
        $r = fmod($x, 1000000000000000);
        if ($r > 0) {
          $w .= ' ';
          if ($r < 1000) {
            $w .= ' ';
          }
          $w .= number_to_words($r);
        }
      } else {
        $w .= number_to_words(floor($x / 1000000000000000000)) . ' quintillion';
        $r = fmod($x, 1000000000000000000);
        if ($r > 0) {
          $w .= ' ';
          if ($r < 1000) {
            $w .= ' ';
          }
          $w .= number_to_words($r);
        }
      }
    }
    
    return $w;
  }
  
  function orderNumbering($number)
  {
    if ($number < 10) {
      $num = "00" . $number;
    } elseif ($number > 10 && $number < 100) {
      $num = "0" . $number;
    } else {
      $num = $number;
    }
    return $num;
  }
  
  // Audit Trails
  function activityType($activity)
  {
    if ($activity === 1 || $activity === "1") {
      $act = "Added Record";
    } else {
      if ($activity === 2 || $activity === "2") {
        $act = "Updated Record";
      } else {
        $act = "Deleted Record";
      }
    }
    return $act;
  }
  
  function nozeros($value)
  {
    if ($value >= 1000000000000) {
      $no = round(($value / 1000000000000000000), 3) . " Qt";
    } elseif ($value >= 1000000000000) {
      $no = round(($value / 1000000000000000), 3) . " Qd";
    } elseif ($value >= 1000000000000) {
      $no = round(($value / 1000000000000), 3) . " T";
    } elseif ($value >= 1000000000) {
      $no = round(($value / 1000000000), 3) . " B";
    } elseif ($value >= 1000000) {
      $no = round(($value / 1000000), 3) . " M";
    } elseif ($value >= 1000) {
      $no = round(($value / 1000), 3) . " Th";
    } else {
      $no = $value;
    }
    
    return $no;
  }
  
  // Add st, nd, rd, th to numbers
  function ordinal($number)
  {
    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
      return $number . 'th';
    } else {
      return $number . $ends[$number % 10];
    }
  }
  
  //Random Code Generator
  function randomCode($length)
  {
    $characters = "23456789ABCDEFHJKLMNPRTVWXYZ";
    $string     = "";
    for ($p = 0; $p < $length; $p++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    
    return $string;
  }
  
  // Reduce Words to a given amount then add ellipsis
  function reduceWords($words, $letter)
  {
    $new = strip_tags($words);
    if (strlen($new) > $letter) {
      $news = mb_substr($new, 0, $letter) . "... ";
    } else {
      $news = $words;
    }
    
    return $news;
  }
  
  function alert($type, $text)
  {
    echo '<div class="alert alert-' . strtolower($type) . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" onclick="window.location.href=(window.location)">&times;</button>
            <strong>' . ucwords($type) . '!</strong> ' . $text . '
          </div>';
  }
  
  /**
   * Delete Directory and it subs
   *
   * @param $dirname
   *
   * @return bool
   */
  function delete_directory($dirname)
  {
    if (is_dir($dirname)) {
      $dir_handle = opendir($dirname);
    }
    if (!$dir_handle) {
      return false;
    }
    while ($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
        if (!is_dir($dirname . "/" . $file)) {
          unlink($dirname . "/" . $file);
        } else {
          delete_directory($dirname . '/' . $file);
        }
      }
    }
    closedir($dir_handle);
    rmdir($dirname);
    
    return true;
  }
  
  /**
   * @param $zip
   * @param $dir
   */
  function createZip($zip, $dir)
  {
    if (is_dir($dir)) {
      if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
          // If file
          if (is_file($dir . $file)) {
            if ($file !== '' && $file !== '.' && $file !== '..') {
              $zip->addFile($dir . $file);
            }
          } else {
            // If directory
            if (is_dir($dir . $file)) {
              if ($file !== '' && $file !== '.' && $file !== '..') {
                // Add empty directory
                $zip->addEmptyDir($dir . $file);
                $folder = $dir . $file . '/';
                // Read data of the folder
                createZip($zip, $folder);
              }
            }
          }
        }
        closedir($dh);
      }
    }
  }
  
  // Make Short Date
  function dates($date)
  {
    return date('d M, Y', strtotime($date));
  }
  
  // Male long Date
  function datel($date)
  {
    return date('h:i A d M, Y', strtotime($date));
  }
  
  function phone($phone = null)
  {
    if ($phone !== null) {
      if (str_contains($phone, ", ")) {
        $phones = '';
        $nums = explode(", ", $phone);
        foreach ($nums as $num) {
          $phones .= '<a href="tel:' . str_replace(' ', '', esc($num)) . '">' . esc($num) . '</a>, ';
        }
        return rtrim($phones, ", ");
      } else {
        return '<a href="tel:' . str_replace(' ', '', esc($phone)) . '">' . esc($phone) . '</a>';
      }
    }
    return null;
  }
  
  function email($email = null)
  {
    if ($email !== null) {
      if (str_contains($email, ", ")) {
        $emails = '';
        $nums = explode(", ", $email);
        foreach ($nums as $num) {
          $emails .= '<a href="mailto:' . str_replace(' ', '', esc($num)) . '">' . esc($num) . '</a>, ';
        }
        return rtrim($emails, ", ");
      } else {
        return '<a href="mailto:' . str_replace(' ', '', esc($email)) . '">' . esc($email) . '</a>';
      }
    }
    return null;
  }
  
  function website($website)
  {
    return '<a href="' . str_replace(' ', '', esc($website)) . '" target="_blank">' . esc($website) . '</a>';
  }
  
  function dnd($expression)
  {
    echo '<pre>';
    echo print_r($expression);
    echo '</pre>';
    die();
  }
  
  // OTHER WEBSITE/SYSTEM VITALS
  $config = new Config();
  define('COMPANY', $config->get('COMPANY'));
  define('MOTTO', $config->get('MOTTO'));
  define('LOCATION', $config->get('LOCATION'));
  define('COMPANYEMAIL', $config->get('COMPANYEMAIL'));
  define('COMPANYPHONE', $config->get('COMPANYPHONE'));
  define('COMPANYPHONE2', $config->get('COMPANYPHONE2'));
  define('CURRENCY', $config->get('CURRENCY'));