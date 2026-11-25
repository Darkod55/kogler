<?php

namespace App\Content;

/**
 * Who We Are facts shared with the brand pages.
 * One source for the Made in the USA and Quality copy.
 */
class CompanyStory
{
    /**
     * @return array{stat: string, stat_line: string, title: string, text: string}
     */
    public static function madeInUsa(): array
    {
        return [
            'stat' => '150+',
            'stat_line' => 'mattresses each day',
            'title' => 'Made in the USA',
            'text' => 'Our manufacturing facility in Cleveland, TN produces over 150 quality mattresses each day.',
        ];
    }

    /**
     * @return array{title: string, text: string}
     */
    public static function quality(): array
    {
        return [
            'title' => 'Quality',
            'text' => 'From the foam that goes into a mattress to the cable that connects a trailer, everything is tested against the realities of life on the road.',
        ];
    }
}
