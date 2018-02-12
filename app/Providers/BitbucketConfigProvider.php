<?php

namespace App\Providers;

class BitbucketConfigProvider
{
    protected static $config = [];

    public function __construct()
    {
        if (empty(static::$config) && file_exists(expandTilde("~/.bitbucket"))) {
            static::$config = parse_ini_file(expandTilde("~/.bitbucket"), true, INI_SCANNER_TYPED);
        }
    }

    public function hasOAuth2()
    {
        return (bool) isset(static::$config['auth']['client_id'], static::$config['auth']['client_secret']);
    }

    public function hasBasicAuth()
    {
        return (bool) isset(static::$config['auth']['username'], static::$config['auth']['password']);
    }

    public function getOAuth2Id()
    {
        if (isset(static::$config['auth']['client_id'])) {
            return static::$config['auth']['client_id'];
        }
    }

    public function getOAuth2Secret()
    {
        if (isset(static::$config['auth']['client_secret'])) {
            return static::$config['auth']['client_secret'];
        }
    }

    public function getBasicAuthUsername()
    {
        if (isset(static::$config['auth']['username'])) {
            return static::$config['auth']['username'];
        }
    }

    public function getBasicAuthPassword()
    {
        if (isset(static::$config['auth']['password'])) {
            return static::$config['auth']['password'];
        }
    }
}
