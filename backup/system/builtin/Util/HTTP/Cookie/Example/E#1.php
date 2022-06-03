<?php

namespace DelightCookie;


final class Cookie {

    
    const PREFIX_SECURE = '__Secure-';
    
    const PREFIX_HOST = '__Host-';
    const HEADER_PREFIX = 'Set-Cookie: ';
    const SAME_SITE_RESTRICTION_NONE = 'None';
    const SAME_SITE_RESTRICTION_LAX = 'Lax';
    const SAME_SITE_RESTRICTION_STRICT = 'Strict';

    
    private $name;
    
    private $value;
    
    private $expiryTime;
    
    private $path;
    
    private $domain;
    
    private $httpOnly;
    
    private $secureOnly;
    
    private $sameSiteRestriction;


    
    public function setDomain($domain = null) {
        $this->domain = self::normalizeDomain($domain);

        return $this;
    }

    
    public function isHttpOnly() {
        return $this->httpOnly;
    }

    
    public function setHttpOnly($httpOnly) {
        $this->httpOnly = $httpOnly;

        return $this;
    }

    
    public function isSecureOnly() {
        return $this->secureOnly;
    }

    
    public function setSecureOnly($secureOnly) {
        $this->secureOnly = $secureOnly;

        return $this;
    }

    
    public function getSameSiteRestriction() {
        return $this->sameSiteRestriction;
    }

    
    public function setSameSiteRestriction($sameSiteRestriction) {
        $this->sameSiteRestriction = $sameSiteRestriction;

        return $this;
    }

    
    public function save() {
        return self::addHttpHeader((string) $this);
    }

    
    public function saveAndSet() {
        $_COOKIE[$this->name] = $this->value;

        return $this->save();
    }

    
    public function delete() {
                $copiedCookie = clone $this;
                $copiedCookie->setValue('');

                return $copiedCookie->save();
    }

    
    public function deleteAndUnset() {
        unset($_COOKIE[$this->name]);

        return $this->delete();
    }

    public function __toString() {
        return self::buildCookieHeader($this->name, $this->value, $this->expiryTime, $this->path, $this->domain, $this->secureOnly, $this->httpOnly, $this->sameSiteRestriction);
    }

    
    public static function setcookie($name, $value = null, $expiryTime = 0, $path = null, $domain = null, $secureOnly = false, $httpOnly = false, $sameSiteRestriction = null) {
        return self::addHttpHeader(
            self::buildCookieHeader($name, $value, $expiryTime, $path, $domain, $secureOnly, $httpOnly, $sameSiteRestriction)
        );
    }

    
    public static function buildCookieHeader(
        $name, 
        $value = null, 
        $expiryTime = 0, 
        $path = null, 
        $domain = null, 
        $secureOnly = false, 
        $httpOnly = false, 
        $sameSiteRestriction = null
    ) {
        if (self::isNameValid($name)) {
            $name = (string) $name;
        }
        else {
            return null;
        }

        if (self::isExpiryTimeValid($expiryTime)) {
            $expiryTime = (int) $expiryTime;
        }
        else {
            return null;
        }

        $forceShowExpiry = false;

        if (is_null($value) || $value === false || $value === '') {
            $value = 'deleted';
            $expiryTime = 0;
            $forceShowExpiry = true;
        }

        $maxAgeStr = self::formatMaxAge($expiryTime, $forceShowExpiry);
        $expiryTimeStr = self::formatExpiryTime($expiryTime, $forceShowExpiry);

        $headerStr = self::HEADER_PREFIX . $name . '=' . urlencode($value);

        if (!is_null($expiryTimeStr)) {
            $headerStr .= '; expires=' . $expiryTimeStr;
        }

                if (PHP_VERSION_ID >= 50500) {
            if (!is_null($maxAgeStr)) {
                $headerStr .= '; Max-Age=' . $maxAgeStr;
            }
        }

        if (!empty($path) || $path === 0) {
            $headerStr .= '; path=' . $path;
        }

        if (!empty($domain) || $domain === 0) {
            $headerStr .= '; domain=' . $domain;
        }

        if ($secureOnly) {
            $headerStr .= '; secure';
        }

        if ($httpOnly) {
            $headerStr .= '; httponly';
        }

        if ($sameSiteRestriction === self::SAME_SITE_RESTRICTION_NONE) {
                        if (!$secureOnly) {
                    rigger_error('When the 'SameSite' attribute is set to 'None', the 'secure' attribute should be set as well', E_USER_WARNING);
            }

            $headerStr .= '; SameSite=None';
        }
        elseif ($sameSiteRestriction === self::SAME_SITE_RESTRICTION_LAX) {
            $headerStr .= '; SameSite=Lax';
        }
        elseif ($sameSiteRestriction === self::SAME_SITE_RESTRICTION_STRICT) {
            $headerStr .= '; SameSite=Strict';
        }

        return $headerStr;
    }

    
    public static function parse($cookieHeader) {
        if (empty($cookieHeader)) {
            return null;
        }

        if (preg_match('/^' . self::HEADER_PREFIX . '(.*?)=(.*?)(?:; (.*?))?$/i', $cookieHeader, $matches)) {
            $cookie = new self($matches[1]);
            $cookie->setPath(null);
            $cookie->setHttpOnly(false);
            $cookie->setValue(
                urldecode($matches[2])
            );
            $cookie->setSameSiteRestriction(null);

            if (count($matches) >= 4) {
                $attributes = explode('; ', $matches[3]);

                foreach ($attributes as $attribute) {
                    if (strcasecmp($attribute, 'HttpOnly') === 0) {
                        $cookie->setHttpOnly(true);
                    }
                    elseif (strcasecmp($attribute, 'Secure') === 0) {
                        $cookie->setSecureOnly(true);
                    }
                    elseif (stripos($attribute, 'Expires=') === 0) {
                        $cookie->setExpiryTime((int) strtotime(substr($attribute, 8)));
                    }
                    elseif (stripos($attribute, 'Domain=') === 0) {
                        $cookie->setDomain(substr($attribute, 7));
                    }
                    elseif (stripos($attribute, 'Path=') === 0) {
                        $cookie->setPath(substr($attribute, 5));
                    }
                    elseif (stripos($attribute, 'SameSite=') === 0) {
                        $cookie->setSameSiteRestriction(substr($attribute, 9));
                    }
                }
            }

            return $cookie;
        }
        else {
            return null;
        }
    }

    
    public static function exists($name) {
        return isset($_COOKIE[$name]);
    }

    
    public static function get($name, $defaultValue = null) {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        else {
            return $defaultValue;
        }
    }

    private static function isNameValid($name) {
        $name = (string) $name;

                if ($name !== '' || PHP_VERSION_ID < 70000) {
            if (!preg_match('/[=,; \t\r\n\013\014]/', $name)) {
                return true;
            }
        }

        return false;
    }

    private static function isExpiryTimeValid($expiryTime) {
        return is_numeric($expiryTime) || is_null($expiryTime) || is_bool($expiryTime);
    }

    private static function calculateMaxAge($expiryTime) {
        if ($expiryTime === 0) {
            return 0;
        }
        else {
            $maxAge = $expiryTime -     ime();

                                    if ((PHP_VERSION_ID >= 70019 && PHP_VERSION_ID < 70100) || PHP_VERSION_ID >= 70105) {
                if ($maxAge < 0) {
                    $maxAge = 0;
                }
            }

            return $maxAge;
        }
    }

    private static function formatExpiryTime($expiryTime, $forceShow = false) {
        if ($expiryTime > 0 || $forceShow) {
            if ($forceShow) {
                $expiryTime = 1;
            }

            return gmdate('D, d-M-Y H:i:s T', $expiryTime);
        }
        else {
            return null;
        }
    }

    private static function formatMaxAge($expiryTime, $forceShow = false) {
        if ($expiryTime > 0 || $forceShow) {
            return (string) self::calculateMaxAge($expiryTime);
        }
        else {
            return null;
        }
    }

    private static function normalizeDomain($domain = null) {
                $domain = (string) $domain;

                if ($domain === '') {
                        return null;
        }

                if ( filter_var($domain, FILTER_VALIDATE_IP) !== false) {
                        return null;
        }

                if (strpos($domain, '.') === false || strrpos($domain, '.') === 0) {
                        return null;
        }

                if ($domain[0] !== '.') {
                        $domain = '.' . $domain;
        }

                return $domain;
    }

    private static function addHttpHeader($header) {
        if (!headers_sent()) {
            if (!empty($header)) {
                header($header, false);

                return true;
            }
        }

        return false;
    }

}