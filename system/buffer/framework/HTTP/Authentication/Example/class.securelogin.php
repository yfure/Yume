<?

/*--------------
| Secure Login |
--------------*/

/**
 * This can authenticate handle user authentication done via HTTP or HTML FORM by storing the authentication credentials in cookies or session variables.
 * It can store the authentication credentials encoded with MD5 or with an user defined function.
 * It can logout an user by deleting the credentials cookies or session variables
 * This class only handle the login and logout action , you will have to check the user yourself.
 *
 * @author Nguyen Quoc Bao <quocbao.coder@gmail.com>
 * @version 1.0
 */
class securelogin {
    /*----------
    | Variable |
    ----------*/
    /**
     * Object Handler
     * - setcookie : Set cookie function handler
     * - header : Header function handler
     * - encode : Password Hashing function handler
     * - checklogin : Check login handler
     *
     * @var array
     */
    var $handler = array(
        'setcookie' => false , 
        'header' => false,
        'encode' => false , 
        'checklogin' => false
    );
    /**
     * Allow the class to get information from PHP_AUTH_USER and PHP_AUTH_PW
     *
     * @var unknown_type
     */
    var $use_auth = false;
    /**
     * Save login information to Cookie
     *
     * @var bool
     */
    var $use_cookie = true;
    /**
     * Save login information to Session (Session must be started before)
     *
     * @var bool
     */
    var $use_session = true;
    /**
     * Allow the class to get information from a html form
     *
     * @var bool
     */
    var $use_post = true;
    /**
     * Realm text
     *
     * @var string
     */
    var $auth_text = "Please enter your username and password";
    /**
     * Expire time , in second (for cookie mode only)
     *
     * @var int
     */
    var $expire = 3600;
    /**
     * Login username
     *
     * @var string
     */
    var $username = null;
    /**
     * Login pass hash
     *
     * @var string
     */
    var $passhash = null;
    /**
     * Cookie index
     * @var array
     **/
    var $cookie_index = array(
        'user' => 'auth_user' , 
        'pass' => 'auth_pass'
    );
    /**
     * Post index
     * @var array
     **/
    var $post_index = array(
        'user' => 'auth_user' , 
        'pass' => 'auth_pass'
    );
    /**
     * Session index
     * @var array
     **/
    var $session_index = array(
        'user' => 'auth_user' , 
        'pass' => 'auth_pass'
    );
    /*----------
    | Function |
    ----------*/
    /**
     * Check login information
     *
     * @param bool $check_login Auto check user login information
     * @return bool
     */
    function haslogin($check_login=false) {
        if (!isset($_SERVER['PHP_AUTH_USER']))
        {
            if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']))
            {
                $_SERVER['HTTP_AUTHORIZATION'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            }
        
            if (isset($_SERVER['HTTP_AUTHORIZATION']) && strtolower(substr($_SERVER['HTTP_AUTHORIZATION'] , 0 , 6)) == "basic ")
            {
                $arrays = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
                if (count($arrays) > 1)
                {
                    $_SERVER['PHP_AUTH_USER'] = $arrays[0];
                    $_SERVER['PHP_AUTH_PW'] = $arrays[1];
                }
            }
        }
        
        if ($this->use_auth && isset($_SERVER['PHP_AUTH_USER']) && trim($_SERVER['PHP_AUTH_USER']) != "")
        {
            $this->username = $_SERVER['PHP_AUTH_USER'];
            $this->passhash = $this->_encode(@$_SERVER['PHP_AUTH_PW']);
            $this->username = $this->_stripslashes($this->username);
            $this->passhash = $this->_stripslashes($this->passhash);
        } else if ($this->use_post && isset($_POST[$this->post_index['user']]) && trim($_POST[$this->post_index['user']]) != "")
        {
            $this->username = $_POST[$this->post_index['user']];
            $this->passhash = $this->_encode(@$_POST[$this->post_index['pass']]);
            $this->username = $this->_stripslashes($this->username);
            $this->passhash = $this->_stripslashes($this->passhash);
        } else if ($this->use_cookie && isset($_COOKIE[$this->cookie_index['user']]) && trim($_COOKIE[$this->cookie_index['user']]) != "")
        {
            $this->username = $_COOKIE[$this->cookie_index['user']];
            $this->passhash = @$_COOKIE[$this->cookie_index['pass']];
            $this->username = $this->_stripslashes($this->username);
            $this->passhash = $this->_stripslashes($this->passhash); //no need to encode cookie pass
        } else if ($this->use_session && isset($_SESSION[$this->session_index['user']])) {
            $this->username = $_SESSION[$this->session_index['user']];
            $this->passhash = @$_SESSION[$this->session_index['pass']];
        }
        if (!($this->username === null) && $check_login) return $this->checklogin($this->username , $this->passhash);
        return !($this->username === null);
    }
    /**
     * Check user login information
     * You can only use it when checklogin handler is set
     *
     * @param string $user
     * @param string $passhash
     * @return bool
     */
    function checklogin($user=null,$passhash=null) {
        if ($user === null) 
        {
            $user = $this->username;
        }
        if ($passhash === null) 
        {
            $passhash = $this->passhash;
        }
        if (isset($this->handler['checklogin'])) 
        {
            return @call_user_func($this->handler['checklogin'],$user,$passhash);
        } else return false;
    }
    /**
     * Save login information
     *
     */
    function savelogin() {
        if ($this->use_cookie) {
            $this->_setcookie($this->cookie_index['user'] , $this->username , time() + $this->expire);
            $this->_setcookie($this->cookie_index['pass'] , $this->passhash , time() + $this->expire);
        }
        if ($this->use_session) {
            $_SESSION[$this->session_index['user']] = $this->username;
            $_SESSION[$this->session_index['pass']] = $this->passhash;
        }
    }
    
    function expire($time)
    {
        $this->expire = $time;
        if ($this->use_session)
        {
            session_cache_limiter('private');
            session_cache_expire($time / 60);
        }
    }
    
    /**
     * Get actual IP
     * @return string
     **/
    function ip()
    {
        global $REMOTE_ADDR;
        global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED;
        global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM;
        // Get some server/environment variables values
        if (empty($REMOTE_ADDR)) {
            if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR'])) {
                $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
            }
            else if (!empty($_ENV) && isset($_ENV['REMOTE_ADDR'])) {
                $REMOTE_ADDR = $_ENV['REMOTE_ADDR'];
            }
            else if (@getenv('REMOTE_ADDR')) {
                $REMOTE_ADDR = getenv('REMOTE_ADDR');
            }
        } // end if
        if (empty($HTTP_X_FORWARDED_FOR)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])) {
                $HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR'];
            }
            else if (@getenv('HTTP_X_FORWARDED_FOR')) {
                $HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');
            }
        } // end if
        if (empty($HTTP_X_FORWARDED)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])) {
                $HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])) {
                $HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED'];
            }
            else if (@getenv('HTTP_X_FORWARDED')) {
                $HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED');
            }
        } // end if
        if (empty($HTTP_FORWARDED_FOR)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $HTTP_FORWARDED_FOR = $_SERVER['HTTP_FORWARDED_FOR'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED_FOR'])) {
                $HTTP_FORWARDED_FOR = $_ENV['HTTP_FORWARDED_FOR'];
            }
            else if (@getenv('HTTP_FORWARDED_FOR')) {
                $HTTP_FORWARDED_FOR = getenv('HTTP_FORWARDED_FOR');
            }
        } // end if
        if (empty($HTTP_FORWARDED)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED'])) {
                $HTTP_FORWARDED = $_SERVER['HTTP_FORWARDED'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED'])) {
                $HTTP_FORWARDED = $_ENV['HTTP_FORWARDED'];
            }
            else if (@getenv('HTTP_FORWARDED')) {
                $HTTP_FORWARDED = getenv('HTTP_FORWARDED');
            }
        } // end if
        if (empty($HTTP_VIA)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_VIA'])) {
                $HTTP_VIA = $_SERVER['HTTP_VIA'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_VIA'])) {
                $HTTP_VIA = $_ENV['HTTP_VIA'];
            }
            else if (@getenv('HTTP_VIA')) {
                $HTTP_VIA = getenv('HTTP_VIA');
            }
        } // end if
        if (empty($HTTP_X_COMING_FROM)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_X_COMING_FROM'])) {
                $HTTP_X_COMING_FROM = $_SERVER['HTTP_X_COMING_FROM'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_X_COMING_FROM'])) {
                $HTTP_X_COMING_FROM = $_ENV['HTTP_X_COMING_FROM'];
            }
            else if (@getenv('HTTP_X_COMING_FROM')) {
                $HTTP_X_COMING_FROM = getenv('HTTP_X_COMING_FROM');
            }
        } // end if
        if (empty($HTTP_COMING_FROM)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_COMING_FROM'])) {
                $HTTP_COMING_FROM = $_SERVER['HTTP_COMING_FROM'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_COMING_FROM'])) {
                $HTTP_COMING_FROM = $_ENV['HTTP_COMING_FROM'];
            }
            else if (@getenv('HTTP_COMING_FROM')) {
                $HTTP_COMING_FROM = getenv('HTTP_COMING_FROM');
            }
        } // end if
    
        // Gets the default ip sent by the user
        if (!empty($REMOTE_ADDR)) {
            $direct_ip = $REMOTE_ADDR;
        }
    
        // Gets the proxy ip sent by the user
        $proxy_ip     = '';
        if (!empty($HTTP_X_FORWARDED_FOR)) {
            $proxy_ip = $HTTP_X_FORWARDED_FOR;
        } else if (!empty($HTTP_X_FORWARDED)) {
            $proxy_ip = $HTTP_X_FORWARDED;
        } else if (!empty($HTTP_FORWARDED_FOR)) {
            $proxy_ip = $HTTP_FORWARDED_FOR;
        } else if (!empty($HTTP_FORWARDED)) {
            $proxy_ip = $HTTP_FORWARDED;
        } else if (!empty($HTTP_VIA)) {
            $proxy_ip = $HTTP_VIA;
        } else if (!empty($HTTP_X_COMING_FROM)) {
            $proxy_ip = $HTTP_X_COMING_FROM;
        } else if (!empty($HTTP_COMING_FROM)) {
            $proxy_ip = $HTTP_COMING_FROM;
        } // end if... else if...
    
        // Returns the true IP if it has been found, else FALSE
        if (empty($proxy_ip)) {
            // True IP without proxy
            return $direct_ip;
        } else {
            $is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs);
            if ($is_ip && (count($regs) > 0)) {
                // True IP behind a proxy
                return $regs[0];
            } else {
                // Can't define IP: there is a proxy but we don't have
                // information about the true IP
                return FALSE;
            }
        } // end if... else...
    }
    
    /**
     * Clear login information
     *
     */
    function clearlogin() {
        if ($this->use_auth)
        {
            //there was a problem with clearing PHP_AUTH_USER and PHP_AUTH_PW
            unset($_SERVER['PHP_AUTH_USER']);
            unset($_SERVER['PHP_AUTH_PW']);
            unset($_SERVER['HTTP_AUTHORIZATION']);
            unset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
        }
        if ($this->use_cookie)
        {
            $this->_setcookie($this->cookie_index['user'] , null , time() - $this->expire);
            $this->_setcookie($this->cookie_index['pass'] , null , time() - $this->expire);
            unset($_COOKIE[$this->cookie_index['user']]);
            unset($_COOKIE[$this->cookie_index['pass']]);
        }
        if ($this->use_session && isset($_SESSION))
        {
            unset($_SESSION[$this->session_index['user']]);
            unset($_SESSION[$this->session_index['pass']]);
        }
    }
    /**
     * Send deny HTTP Header
     *
     */
    function deny() {
        $this->_header('HTTP/1.1 404 Not Found');
        $this->_header('status: 404 Not Found');
    }
    /**
     * Send HTTP Authentication header
     *
     */
    function auth($realm="") {
        if ($realm == "") $realm = $this->auth_text;
        
        $this->_header('WWW-Authenticate: Basic realm="' . $realm . '"');
        $this->_header('HTTP/1.1 401 Unauthorized');
        $this->_header('status: 401 Unauthorized');
    }
    /**
     * encode() handler
     * Encode user password
     *
     * @access private
     * @param string $string
     * @return string
     */
    function _encode($string) {
        if ($this->handler['encode']) {
            return @call_user_func($this->handler['encode'],$string);
        } else return md5($string);
    }
    /**
     * setcookie() handler
     * Set a user cookie
     *
     * @access private
     * @param string $name
     * @param string $var
     * @param string $time
     * @param string $path
     * @param string $domain
     * @param int $sec
     * @return bool
     */
    function _setcookie($name,$var,$time,$path='',$domain='',$sec='') {
        if ($this->handler['setcookie']) {
            return @call_user_func($this->handler['setcookie'],$name,$var,$time,$path,$domain,$sec);
        } else return setcookie($name,$var,$time,$path,$domain,$sec);
    }
    /**
     * header() handler
     * Send a http header
     *
     * @access private
     * @param string $text
     * @param bool $replace
     * @return bool
     */
    function _header($text,$replace=false) {
        if ($this->handler['header']) {
            return @call_user_func($this->handler['header'],$text,$replace);
        } else return @header($text,$replace);
    }
    /**
     * Stripslashes function alias
     *
     * @access private
     * @param string $text
     * @return string
     */
    function _stripslashes($text) {
        if( get_magic_quotes_gpc() )
        {
            $text = stripslashes($text);
        }
        return $text;
    }
    
}

?>