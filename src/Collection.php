<?php

namespace EthicalJobs\Storage;

/**
 * Collection abstract
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class Collection extends \Illuminate\Support\Collection
{
    /**
     * Create a new collection instance if the value isn't one already.
     *
     * @return static
     */
    public static function make($items = [])
    {
        return new static;
    }

    /**
     * Create an instance of a collection item
     *
     * @return mixed
     */
    public static function instance(string $key)
    {
        $collection = static::make();

        $class = $collection->get($key);

        if (class_exists($class)) {
            return new $class;
        }

        return null;
    }
}
