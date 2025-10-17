<?php

namespace Pianzhou\EloquentChangeLog\Contracts;

interface Watcher
{
    /**
     * Get the list of attributes to watch.
     */
    public function watches() : array;

    /**
     * Get the translated name for a given attribute.
     */
    public function getTranslatedName(string $name);

    /**
     * Get the translated value for a given attribute and value.
     */
    public function getTranslatedValue(string $name, string $value);
}