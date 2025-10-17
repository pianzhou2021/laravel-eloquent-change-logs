<?php

namespace Pianzhou\EloquentChangeLog;

class Config
{
    /**
     * Get configuration value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public static function get($name, $default = null)
    {
        return \Illuminate\Support\Facades\Config::get("eloquent-change-log.{$name}", $default);
    }

    /**
     * Get migration configuration
     *
     * @return array
     */
    public static function migration(): array
    {
        return self::get('migration', []);
    }
}