<?php
/**
 * Config
 * @package     Divalia
 * @author      Dony Wahyu Isp
 * @since       1.0.1-alpha
 **/
namespace Divalia;

/**
 * Class Config
 * @package Divalia
 */
class Config
{

    private static $config;

    /**
     * initialize method
     */
    public static function init()
    {
        self::$config = array(
            'path.assets' => '',
            'path.templates' => '',
            'mod_rewrite' => FALSE,
            'index' => '',
            'template.open_tag' => '{{',
            'template.close_tag' => '}}'
        );
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        self::$config[strtolower($key)] = $value;
    }

    /**
     * @param $key
     * @return string
     */
    public static function get($key)
    {

        if (isset(self::$config[strtolower($key)])) {
            return self::$config[strtolower($key)];
        } else {
            return '';
        }
        
    }

    /**
     * @param $key
     */
    public static function delete($key)
    {
        if (isset(self::$config[strtolower($key)])) {
            unset(self::$config[strtolower($key)]);
        }
    }
}

Config::init();
