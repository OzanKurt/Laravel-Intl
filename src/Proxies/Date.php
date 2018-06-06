<?php

namespace Propaganistas\LaravelIntl\Proxies;

use Illuminate\Support\Traits\Macroable;
use Jenssegers\Date\Date as Carbon;
use JsonSerializable;
use Punic\Calendar;

class Date extends Carbon implements JsonSerializable
{
    use Macroable;

    /**
     * The custom Carbon JSON serializer.
     *
     * @var callable|null
     */
    protected static $serializer;

    /**
     * Formats the date to a short date string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toShortDateString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDate($this, 'short');
    }

    /**
     * Formats the date to a medium date string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toMediumDateString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDate($this, 'medium');
    }

    /**
     * Formats the date to a long date string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toLongDateString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDate($this, 'long');
    }

    /**
     * Formats the date to a full date string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toFullDateString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDate($this, 'full');
    }

    /**
     * Formats the date to a short time string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toShortTimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatTime($this, 'short');
    }

    /**
     * Formats the date to a medium time string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toMediumTimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatTime($this, 'medium');
    }

    /**
     * Formats the date to a long time string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toLongTimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatTime($this, 'long');
    }

    /**
     * Formats the date to a full time string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toFullTimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatTime($this, 'full');
    }

    /**
     * Formats the date to a short datetime string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toShortDatetimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDatetime($this, 'short');
    }

    /**
     * Formats the date to a medium datetime string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toMediumDatetimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDatetime($this, 'medium');
    }

    /**
     * Formats the date to a long datetime string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toLongDatetimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDatetime($this, 'long');
    }

    /**
     * Formats the date to a full datetime string.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function toFullDatetimeString()
    {
        if (static::hasMacro(__FUNCTION__)) {
            return $this->__call(__FUNCTION__, []);
        }

        return Calendar::formatDatetime($this, 'full');
    }

    /**
     * Get the short date format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getShortDateFormat()
    {
        return Calendar::getDateFormat('short');
    }

    /**
     * Get the medium date format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getMediumDateFormat()
    {
        return Calendar::getDateFormat('medium');
    }

    /**
     * Get the long date format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getLongDateFormat()
    {
        return Calendar::getDateFormat('long');
    }

    /**
     * Get the full date format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getFullDateFormat()
    {
        return Calendar::getDateFormat('full');
    }

    /**
     * Get the short time format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getShortTimeFormat()
    {
        return Calendar::getTimeFormat('short');
    }

    /**
     * Get the medium time format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getMediumTimeFormat()
    {
        return Calendar::getTimeFormat('medium');
    }

    /**
     * Get the long time format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getLongTimeFormat()
    {
        return Calendar::getTimeFormat('long');
    }

    /**
     * Get the full time format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getFullTimeFormat()
    {
        return Calendar::getTimeFormat('full');
    }

    /**
     * Get the short datetime format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getShortDatetimeFormat()
    {
        return Calendar::getDatetimeFormat('short');
    }

    /**
     * Get the medium datetime format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getMediumDatetimeFormat()
    {
        return Calendar::getDatetimeFormat('medium');
    }

    /**
     * Get the long datetime format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getLongDatetimeFormat()
    {
        return Calendar::getDatetimeFormat('long');
    }

    /**
     * Get the full datetime format.
     *
     * @return string
     * @throws \Punic\Exception
     */
    public function getFullDatetimeFormat()
    {
        return Calendar::getDatetimeFormat('full');
    }

    /**
     * Prepare the object for JSON serialization.
     *
     * @return array|string
     */
    public function jsonSerialize()
    {
        if (static::$serializer) {
            return call_user_func(static::$serializer, $this);
        }

        $carbon = $this;

        return call_user_func(function () use ($carbon) {
            return get_object_vars($carbon);
        });
    }

    /**
     * JSON serialize all Carbon instances using the given callback.
     *
     * @param  callable $callback
     * @return void
     */
    public static function serializeUsing($callback)
    {
        static::$serializer = $callback;
    }
}