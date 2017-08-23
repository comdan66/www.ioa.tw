<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

include_once PATH_CMD_LIBS . 'Minify' . DIRECTORY_SEPARATOR . 'CSSMin.php';
include_once PATH_CMD_LIBS . 'Minify' . DIRECTORY_SEPARATOR . 'JSMin.php';
include_once PATH_CMD_LIBS . 'Minify' . DIRECTORY_SEPARATOR . 'HTMLMin.php';

class Minify {
  private static $list = array ();

  private static function asset () {
    $list = array_filter (func_get_args ());

    if (isset (self::$list[$key = implode ('_', $list)]))
      return self::$list[$key];

    $format = array_shift ($list);
    $asset_path = PATH_ASSET;

    if (DEV) return self::$list[$key] = array_map (function ($t) { return '/' . $t; }, $list);

    if (!(in_array ($format, array ('css', 'js')) && file_exists ($asset_path) && is_writable ($asset_path) && (count ($list) == count (array_filter ($list, function ($t) { return is_readable (PATH . $t); })))))
      return self::$list[$key] = $list;

    $content = "\xEF\xBB\xBF" . implode ("\n", array_map (function ($t) {
        $bom = pack ('H*','EFBBBF');
        return preg_replace ("/^$bom/", '', myReadFile (PATH . $t));
      }, $list));

    $class = $format == 'js' ? 'JSMin' : 'CSSMin';
    $content = $class::minify ($content);

    if (!myWriteFile ($asset_path . ($name = md5 ($content) . '.' . $format), $content))
      return self::$list[$key] = $list;

    return self::$list[$key] = array (URL_ASSET . $name);
  }
  public static function css ($args = array ()) {
    if (!$list = array_filter ($args)) return array ();
    return call_user_func_array ('self::asset', array_merge (array ('css'), $list));
  }
  public static function js ($args = array ()) {
    if (!$list = array_filter ($args)) return array ();
    return call_user_func_array ('self::asset', array_merge (array ('js'), $list));
  }
}
