<?php

namespace Application\Application\Service;

/**
 * Class BaseService
 *
 * @package Api\Application\Service
 */
class BaseService
{
    /**
     * Function to trim and strip relevant tags etc from a string and return
     *
     * @param $input
     *
     * @return string
     */
    public static function formatStringInput($input)
    {
        if (is_null($input)) {
            return null;
        }

        $input = strip_tags($input);
        $input = trim($input);

        return $input;
    }

    /**
     * Type casts the input to an integer and returns the value
     *
     * @param $input
     *
     * @return int
     */
    public static function formatIntegerInput($input)
    {
        if (is_null($input)) {
            return null;
        }

        $input = (int)$input;

        return $input;
    }

    /**
     * Type cast the input to a boolean and returns the value.
     *
     * @param $input
     *
     * @return bool
     */
    public static function formatBooleanInput($input)
    {
        $input = (bool)$input;

        return $input;
    }

}