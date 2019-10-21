<?php
namespace Wormvc\Wormvc\Helpers;

defined('WPINC') OR exit('No direct script access allowed');

use \Wormvc\Wormvc\Helper;
use \Wormvc\Wormvc\Libraries\Inflector;

/**
 * Str Helper class
 *
 * @author		Eduardo Lazaro Rodriguez <eduzroco@gmail.com>
 * @author		Kenodo LTD <info@kenodo.com>
 * @copyright	2018 Kenodo LTD
 * @license		http://opensource.org/licenses/MIT	MIT License
 * @version     1.0.0
 * @link		https://www.wormvc.com 
 * @since		Version 1.0.0 
 */
class Str extends Helper
{
	/**
	 * Cuts a text given a string limit, keeping complete words
     *
	 * @param string $string
     * @param int $word_limit_count
	 * @return string
     */
	public static function limitWords($string, $word_limit_count)
	{
		$words = explode(' ', $string, ($word_limit_count + 1));
		if(count($words) > $word_limit_count) array_pop($words);
		return implode(' ', $words);
	}    

	/**
	 * In a post context, cuts a text fiven a string limit, keeping complete words [get_the_content()]
	 *
	 * @param string $content
     * @param int $word_limit_count
     * @return string
	 */
	public static function contentLimitWords($content, $word_limit_count)
	{
		$content = explode(' ', wp_strip_all_tags($content), $word_limit_count);
		if (count($content)>=$word_limit_count) {
			array_pop($content);
			$content = implode(" ",$content).'...';
		}
		else {
			$content = implode(" ",$content);
		}	
		$content = preg_replace('/\[.+\]/','', $content);
		$content = apply_filters('the_content', $content); 
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}

	/**
	 * Checks if a URL is valid
	 *
	 * @param string $url
	 * @return bool
	 */
	public static function isValidUrl ($url)
	{
		if($url == '') { return false; }
		$url = filter_var($url, FILTER_SANITIZE_URL);
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			return $url;
		}
        return false;
	}
    
	/**
	 * Checks if a string starts by a substring
	 *
	 * @param string $string
     * @param string $substring
     * @param bool $caseSensitive
	 * @return bool
	 */
    public static function startsWith($string, $subString, $caseSensitive = false)
    {
        if ($caseSensitive === false) {
            $string		= mb_strtolower($string);
            $subString  = mb_strtolower($subString);
        }

        if (mb_substr($string, 0, mb_strlen($subString)) == $subString) return true;
        return false;
    }

	/**
	 * Checks if a string ends by a substring
	 *
	 * @param string $string
     * @param string $substring
     * @param bool $caseSensitive
	 * @return bool
	 */
    public static function endsWith($string, $subString, $caseSensitive = false)
    {
        if ($caseSensitive === false) {
            $string		= mb_strtolower($string);
            $subString  = mb_strtolower($subString);
        }

        $strlen 			= strlen($string);
        $subStringLength 	= strlen($subString);

        if ($subStringLength > $strlen) return false;
        return substr_compare($string, $subString, $strlen - $subStringLength, $subStringLength) === 0;
    }
 
	/**
	 * Checks if a string contains a substring
	 *
	 * @param string $string
     * @param string $substring
     * @param bool $caseSensitive
	 * @return bool
	 */
    public static function contains($string, $substring, $caseSensitive = false)
    {
        if ($caseSensitive === false) {
            $string	= mb_strtolower($string);
            $substring    	= mb_strtolower($substring);
        }

        if (mb_substr_count($string, $substring) > 0) return true;
        return false;
    }
    
	/**
	 * Transforms a plural string into singular
	 *
	 * @param string $string
	 * @return string
	 */
    public static function toSingular($string)
    {
        return Inflector::singularize($string);
    }

    /**
	 * Transforms a singular string into plural
	 *
	 * @param string $string
	 * @return string
	 */
    public static function toPlural($string)
    {
        return Inflector::pluralize($string);
    }
    
    /**
	 * Transforms a singular string into plural
	 *
     * @param  number $count
     * @param  string $word
	 * @return string
	 */
    public static function reckon($number, $string)
    {
        return Inflector::reckon($string);
    }
}