<?php
/**
 * Created by PhpStorm.
 * User: INXX
 * Date: 2020/2/16
 * Time: 22:25
 */

function convertUnderline ( $str , $ucfirst = true)
{
    $prefix = config('database.prefix');
    $str = substr($str,strlen($prefix));
    $str = ucwords(str_replace('_', ' ', $str));
    $str = str_replace(' ','',lcfirst($str));
    return $ucfirst ? ucfirst($str) : $str;
}

function convertUnderlineAll ( $str , $ucfirst = true)
{
    $str = ucwords(str_replace('_', ' ', $str));
    $str = str_replace(' ','',lcfirst($str));
    return $ucfirst ? ucfirst($str) : $str;
}