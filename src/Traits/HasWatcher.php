<?php

namespace Pianzhou\EloquentChangeLog\Traits;

trait HasWatcher
{
    /**
     * Watch fields
     *
     * @return array
     */
    public function watches() : array
    {
        if (!property_exists($this, 'watches')) {
            return array_diff(array_keys($this->attributes), [
                $this->getCreatedAtColumn(),
                $this->getUpdatedAtColumn(),
            ]);
        }

        return $this->watches;
    }


    /**
     * Translate field name
     *
     * @param string $name
     * @return string
     */
    public function getTranslatedName(string $name)
    {
        return $name;
    }


    /**
     * Translate field value
     *
     * @param string $name
     * @param string $value
     * @return string
     */
    public function getTranslatedValue(string $name, string $value)
    {
        return $value;
    }
}
