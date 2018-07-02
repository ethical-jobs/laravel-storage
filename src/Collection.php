<?php

namespace EthicalJobs\Storage;

use Illuminate\Support\Collection as BaseCollection;

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
     * @param string $key
     * @return mixed
     */
    public static function instance(string $key)
    {
        $collection = static::make();

        $class = $collection->get($key);

        if (class_exists($class)) {
            return resolve($class);
        }

        return null;
    }

    /**
     * Returns a collection of item instances
     *
     * @return Illuminate\Support\Collection
     */
    public static function instances() : BaseCollection
    {
        $instances = new BaseCollection;

        foreach (static::make()->all() as $key => $value) {
            if ($instance = static::instance($key)) {
                $instances->put($key, $instance);
            }
        }

        return $instances;
    }    
}
