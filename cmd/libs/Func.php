<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

if (!function_exists ('arr2d21d')) {
  function arr2d21d ($arr) {
    $msgs = array ();
    foreach ($arr as $val)
      if (is_array ($val)) $msgs = array_merge ($msgs, $val);
      else array_push ($msgs, $val);
    return $msgs;
  }
}

if (!function_exists ('mergeArrRec')) {
  function mergeArrRec ($fs, &$rfs, $p = null) {
    if (!($fs && is_array ($fs))) return false;

    foreach ($fs as $k => $f)
      if (is_array ($f)) $k . mergeArrRec ($f, $rfs, ($p ? rtrim ($p, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR : '') . $k);
      else array_push ($rfs, ($p ? rtrim ($p, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR : '') . $f);
  }
}


if (!function_exists ('mapDir')) {
  function mapDir ($sDir, $dDir = 0, $hidden = false, $exts = array ()) {
    if ($fp = @opendir ($sDir)) {
      $fs = array (); $ndDir  = $dDir - 1; $sDir = rtrim ($sDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
      while (false !== ($f = readdir ($fp))) { if (trim ($f, '.') == '' || (($hidden === false) && ($f[0] === '.')) || is_link ($f) || ($f == 'cmd')) continue; if ((($dDir < 1) || ($ndDir > 0)) && @is_dir ($sDir . $f)) $fs[$f] = mapDir ($sDir . $f . DIRECTORY_SEPARATOR, $ndDir, $hidden, $exts); else if (!$exts || in_array (pathinfo ($f, PATHINFO_EXTENSION), $exts)) array_push ($fs, $f); else; }
      closedir ($fp);
      return $fs;
    }
    return false;
  }
}

if (!function_exists ('myReadFile')) {
  function myReadFile ($f) {
    if (!file_exists ($f)) return false;
    if (function_exists ('file_get_contents')) return file_get_contents ($f);
    if (!$fp = @fopen ($f, 'rb')) return false;
    $data = ''; flock ($fp, LOCK_SH); if (filesize ($f) > 0) $data =& fread ($fp, filesize ($f)); flock ($fp, LOCK_UN); fclose ($fp);
    return $data;
  }
}
if (!function_exists ('myWriteFile')) {
  function myWriteFile ($p, $d, $m = 'wb') {
    if (!$fp = @fopen ($p, $m)) return false;
    flock ($fp, LOCK_EX);
    fwrite ($fp, $d);
    flock ($fp, LOCK_UN);
    fclose ($fp);


    $o = umask (0);
    @chmod ($p, 0777);
    umask ($o);
    return true;
  }
}

if (!function_exists ('params')) {
  function params ($params, $keys) {
    $ks = $return = $result = array ();

    if (!$params) return $return;
    if (!$keys) return $return;

    foreach ($keys as $key)
      if (is_array ($key)) foreach ($key as $k) array_push ($ks, $k);
      else  array_push ($ks, $key);

    $key = null;

    foreach ($params as $param)
      if (in_array ($param, $ks)) if (!isset ($result[$key = $param])) $result[$key] = array (); else ;
      else if (isset ($result[$key])) array_push ($result[$key], $param); else ;

    foreach ($keys as $key)
      if (is_array ($key))  foreach ($key as $k) if (isset ($result[$k])) $return[$key[0]] = isset ($return[$key[0]]) ? array_merge ($return[$key[0]], $result[$k]) : $result[$k]; else;
      else if (isset ($result[$key])) $return[$key] = isset ($return[$key]) ? array_merge ($return[$key], $result[$key]) : $result[$key]; else;

    return $return;
  }
}

// ==================

if (!function_exists ('strCat')) {
  function strCat ($str, $len, $space = true, $removeHtmlTag = true) {
    return mb_strimwidth ($removeHtmlTag ? removeHtmlTag ($str, $space) : $str, 0, $len, '…','UTF-8');
  }
}

if (!function_exists ('avatarUrl')) {
  function avatarUrl ($uid, $w = 100, $h = 100) {
    $size = array ();
    array_push ($size, isset ($w) && $w ? 'width=' . $w : ''); array_push ($size, isset ($h) && $h ? 'height=' . $h : '');
    return 'https://graph.facebook.com/' . $uid . '/picture' . (($size = implode ('&', array_filter ($size))) ? '?' . $size : '');
  }
}
if (!function_exists ('datetime2Format')) {
  function datetime2Format ($d, $k = 'c') {
    return date ($k, strtotime ($d));
  }
}

if (!function_exists ('mkdir777')) {
  function mkdir777 ($path) {
    $oldmask = umask (0);
    @mkdir ($path, 0777, true);
    umask ($oldmask);
    return true;
  }
}

if (!function_exists ('deleteDir')) {
  function deleteDir ($dir, $is_root = true) {
    if (!file_exists ($dir)) return true;
    
    $dir = rtrim ($dir, DIRECTORY_SEPARATOR);
    if (!$currentDir = @opendir ($dir))
      return false;

    while (false !== ($filename = @readdir ($currentDir)))
      if (($filename != '.') && ($filename != '..'))
        if (is_dir ($dir . DIRECTORY_SEPARATOR . $filename)) if (substr ($filename, 0, 1) != '.') deleteDir ($dir . DIRECTORY_SEPARATOR . $filename); else;
        else unlink ($dir . DIRECTORY_SEPARATOR . $filename);

    @closedir ($currentDir);

    return $is_root ? @rmdir ($dir) : true;
  }
}

if (!function_exists ('typeOfImg')) {
  function typeOfImg ($t) {
    return 'image/' . (($t = pathinfo (MAIN_OG_URL)) && isset ($t['extension']) && $t['extension'] ? $t['extension'] : 'jpg');
  }
}
if (!function_exists ('removeHtmlTag')) {
  function removeHtmlTag ($text, $space = true) {
    return preg_replace ("/\s+/u", $space ? " " : "", preg_replace ("/&#?[a-z0-9]+;/iu", "", str_replace ('▼', '', str_replace ('▲', '', trim (strip_tags ($text))))));
  }
}

if (!function_exists ('urlFormat')) {
  function urlFormat ($str) {
    return preg_replace ('/[\/%]/u', ' ', $str);
  }
}

if (!function_exists ('pageUrlFormat')) {
  function pageUrlFormat ($id, $title) {
    return urlFormat ($id . '-' . $title . HTML);
  }
}
if (!function_exists ('pageUrl')) {
  function pageUrl ($url, $id, $title) {
    return $url . rawurlencode (pageUrlFormat ($id, $title));
  }
}
if (!function_exists ('pathArticle')) {
  function pagePath ($path, $id, $title) {
    return $path . pageUrlFormat ($id, $title);
  }
}

if (!function_exists ('columnArray')) {
  function columnArray ($objects, $key, $callback = null) {
    return array_map (function ($object) use ($key, $callback) {
      $t = !is_array ($object) ? is_object ($object) ? $object->$key : $object : $object[$key];
      return $callback && is_callable ($callback) ? $callback ($t) : $t;
    }, $objects);
  }
}
