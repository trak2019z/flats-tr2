<?php

namespace App\Helpers;


use Cocur\Slugify\Slugify;

class Slugs
{
    private static $slugify = null;

    /**
     * @return Slugify
     */
    private static function Slugify()
    {
        if (self::$slugify === null)
            self::$slugify = new Slugify(['rulesets' => ['default', 'polish']]);

        return self::$slugify;
    }

    public static function create($text, $character='-')
    {
        return self::Slugify()->slugify($text, $character);
    }
}