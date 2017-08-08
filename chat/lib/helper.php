<?php

/**
 * Created by PhpStorm.
 * User: glrh11
 * Date: 17-8-8
 * Time: 下午5:46
 */
class Helper
{
    static public function time13()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (int)((floatval($s1) + floatval($s2)) * 1000);
    }
}