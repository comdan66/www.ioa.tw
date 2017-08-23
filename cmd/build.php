<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

include_once 'libs' . DIRECTORY_SEPARATOR . 'Define.php';
$startT = microtime (true);

if (!(isset ($_POST['bucket']) && ($_POST['bucket'] = trim ($_POST['bucket'])) && isset ($_POST['access']) && ($_POST['access'] = trim ($_POST['access'])) && isset ($_POST['secret']) && ($_POST['secret'] = trim ($_POST['secret'])) && isset ($_POST['upload']) && in_array ($_POST['upload'], array ('1', '2')))) {
  header ('Content-Type: application/json', 'true');
  echo json_encode (array ('status' => false, 'message' => '參數錯誤！'));
  exit();
}

$potoco = isset ($_POST['potoco']) && ($_POST['potoco'] = strtolower (trim ($_POST['potoco']))) && in_array ($_POST['potoco'], array ('https', 'http')) ? $_POST['potoco'] : 'http';
$bucket = $_POST['bucket'];
$access = $_POST['access'];
$secret = $_POST['secret'];
$upload = $_POST['upload'];

define ('DEV', $upload !== '2');
define ('URL', $potoco . '://' . $bucket . '/');

include_once PATH_CMD_LIBS . 'Define2' . PHP;
include_once PATH_CMD_LIBS . 'Load' . PHP;
include_once PATH_CMD_LIBS . 'Build' . PHP;
include_once PATH_CMD_LIBS . 'Func' . PHP;
include_once PATH_CMD_LIBS . 'Minify' . PHP;
include_once PATH_CMD_LIBS . 'Pagination' . PHP;
include_once PATH_CMD_LIBS . 'Sitemap' . PHP;

$build = new Build ();

$build->clean ('清除上次的紀錄');
$build->init ('初始化目錄');
$build->indexHtml ('產生 Index 檔案');
// $build->aboutHtml ('產生 About 檔案');
// $build->contactHtml ('產生 Contact 檔案');
// $build->articlesHtml ('產生 Article 檔案');
// $build->worksHtml ('產生 Work 檔案');
// $build->sitemap ('產生 Sitemap 檔案');

// if (DEV) {
//   header ('Content-Type: application/json', 'true');
//   echo json_encode (array ('status' => true, 'message' => 'Build 成功！'));
//   exit();
// }

// $option = array (
//     'bucket' => $bucket,
//     'access' => $access,
//     'secret' => $secret,
//     'protocol' => $potoco,
//     'usname' => false,
//     'minify' => !DEV,
//   );

// include_once '_oa' . PHP;

if (!CLI) {
  header ('Content-Type: application/json', 'true');
  echo json_encode (array ('status' => true, 'message' => '花費 ' . round (microtime (true) - $startT, 4) . ' 秒'));
  exit();
}