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
