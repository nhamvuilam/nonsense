<?php
//
// StringUtils.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Stdlib;

/**
 * String utility
 */
class StringUtils {
    /**
     * Truncate a long string
     *
     * @param string $text   Text to truncate
     * @param number $length OPTIONAL. Number of characters to return, default value is 100
     * @param string $suffix OPTIONAL. Suffix will be added to return text, default value is '...'
     * @param string $encode OPTIONAL. Text encoding, default value is UTF-8
     *
     * @return string
     */
    public static function truncate($text, $length = 100, $suffix = '...', $encode = 'UTF-8') {
        if (mb_strlen($text, $encode) > $length) {
            // Get character at position to truncate
            $last = mb_strrpos(mb_substr($text, 0, $length, $encode), ' ', 0, $encode);

            // Truncate and add suffix if any
            $output = mb_substr($text, 0, empty($last) ? $length : $last, $encode) . $suffix;
            return $output;
        }
        return $text;
    }
}