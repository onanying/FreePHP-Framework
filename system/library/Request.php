<?php

/**
 * Request类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Request
{

    // PARAM 变量
    private static $param;

    // 配置名
    private static $configPath = 'config.request_default_filter';

    // 获取数组元素
    private static function element($array, $item = null)
    {
        if (is_null($item)) {
            return $array;
        }
        return array_key_exists($item, $array) ? $array[$item] : null;
    }

    // 变量过滤
    private static function filterValue($array, $filter)
    {
        $isArray = is_array($array);
        $data    = $isArray ? $array : [$array];
        foreach ($data as $key => $value) {
            switch ($filter) {
                case 'htmlspecialchars':
                    $data[$key] = htmlspecialchars($value);
                    break;
                case 'strip_tags':
                    $data[$key] = strip_tags($value);
                    break;
                default:
                    break;
            }
        }
        return $isArray ? $data : $data[0];
    }

    // 获取 PARAM 变量
    public static function param($name = null, $filter = null)
    {
        if (!isset(self::$param)) {
            self::$param = $GLOBALS['route'] + $_GET + $_POST;
        }
        if (is_null($filter)) {
            $filter = Config::get(self::$configPath);
        }
        return self::filterValue(self::element(self::$param, $name), $filter);
    }

    // 获取 $_GET 变量
    public static function get($name = null, $filter = null)
    {
        is_null($filter) and $filter = Config::get(self::$configPath);
        return self::filterValue(self::element($_GET, $name), $filter);
    }

    // 获取 $_POST 变量
    public static function post($name = null, $filter = null)
    {
        is_null($filter) and $filter = Config::get(self::$configPath);
        return self::filterValue(self::element($_POST, $name), $filter);
    }

    // 获取 $_REQUEST 变量
    public static function request($name = null, $filter = null)
    {
        is_null($filter) and $filter = Config::get(self::$configPath);
        return self::filterValue(self::element($_REQUEST, $name), $filter);
    }

    // 获取路由变量
    public static function route($name = null)
    {
        return self::element($GLOBALS['route'], $name);
    }

    // 获取 $_SESSION 变量
    public static function session($name = null)
    {
        return Session::get($name);
    }

    // 获取 $_COOKIE 变量
    public static function cookie($name = null)
    {
        return self::element($_COOKIE, $name);
    }

    // 获取 $_FILES 变量
    public static function file($name = null)
    {
        return self::element($_FILES, $name);
    }

    // 获取 $_SERVER 变量
    public static function server($name = null)
    {
        return self::element($_SERVER, $name);
    }

    // 获取 $_ENV 变量
    public static function env($name = null)
    {
        return self::element($_ENV, $name);
    }

}