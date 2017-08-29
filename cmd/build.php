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
$build->getApi ('取得 API');
$build->indexHtml ('產生 Index 檔案');
$build->licenseHtml ('產生 License 檔案');
$build->searchHtml ('產生 Search 檔案');
$build->timelineHtml ('產生 Timeline 檔案');

$build->listHtml ('開發心得', URL_DEVS,      PATH_DEVS,      'devs',      '這裡有著 ' . OA_NAME . ' 的程式開發心得，其中包含了從大學開始學習的 C 語言、Java、大三學習的 php、MySQL、專題 Arduino 比賽心得，也有出社會後因為工作關係在前、後端領域甚至是 iOS App 的開發心得紀錄！');
$build->listHtml ('生活紀錄', URL_BLOGS,     PATH_BLOGS,     'blogs',     '自己的部落格系統自己寫，雖然 Coding 很熱血，但其實年紀越大，越會發現生活不只寫程式這件事而已，到處都有你我直得發現的美，讓我們一起來記錄吧。');
$build->listHtml ('開箱文章', URL_UNBOXINGS, PATH_UNBOXINGS, 'unboxings', '開箱！開箱！開箱！新玩具、新遊戲、新夥伴！一起來開箱聞一聞吧！');
$build->listHtml ('個人相簿', URL_ALBUMS,    PATH_ALBUMS,    'albums');

$build->sitemap ('產生 Sitemap 檔案');

if (DEV) {
  header ('Content-Type: application/json', 'true');
  echo json_encode (array ('status' => true, 'message' => 'Build 成功！'));
  exit();
}

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