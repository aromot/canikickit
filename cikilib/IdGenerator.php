<?php

namespace CikiLib;

use Hidehalo\Nanoid\Client;

class IdGenerator
{
    public static function generate(int $size = 5): string
    {
        $nano = new Client();
        $alphabet = 'abcdefghijklmnopqrstuvwxyz0123456789';
        return $nano->formattedId($alphabet, $size);
    }
}