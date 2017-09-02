<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class Load {
  private $d4Metas = array ();
  private $d4Links = array ();
  private $pais = array ();

  public function __construct ($pais) {
    $this->pais = $pais;
    $this->d4Metas = array (
      array ('_k' => 'c',     'charset' => 'utf-8'),
      array ('_k' => 'hct',   'http-equiv' => 'Content-type',                     'content' => 'text/html; charset=utf-8'),
      array ('_k' => 'hcl',   'http-equiv' => 'Content-Language',                 'content' => 'zh-tw'),

      array ('_k' => 'nv',    'name' => 'google-site-verification',               'content' => 'oP5AjoCz_SS0W6OeLiynUxpE7hnFdhWVZ6zDxRiJQqY'),
      array ('_k' => 'nv',    'name' => 'viewport',                               'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui'),
      array ('_k' => 'nr',    'name' => 'robots',                                 'content' => DEV ? 'noindex,nofollow' : 'index,follow'),
      array ('_k' => 'nk',    'name' => 'keywords',                               'content' => MAIN_KEYWORDS),
      array ('_k' => 'nd',    'name' => 'description',                            'content' => strCat (MAIN_DESCRIPTION, 150)),
      array ('_k' => 'nmtc',  'name' => 'msapplication-TileColor',                'content' => '#3db990'),
      array ('_k' => 'nmti',  'name' => 'msapplication-TileImage',                'content' => URL_IMG_FAVICON . 'ms-icon-144x144.png'),
      array ('_k' => 'nt',    'name' => 'theme-color',                            'content' => '#3db990'),
      array ('_k' => 'pou',   'property' => 'og:url',                             'content' => PAGE_URL_INDEX),
      array ('_k' => 'poi',   'property' => 'og:title',                           'content' => MAIN_TITLE),
      array ('_k' => 'pod',   'property' => 'og:description',                     'content' => strCat (MAIN_DESCRIPTION, 200, false)),
      array ('_k' => 'pos',   'property' => 'og:site_name',                       'content' => MAIN_TITLE),
      array ('_k' => 'pfm',   'property' => 'fb:admins',                          'content' => FB_ADMIN_ID),
      array ('_k' => 'pda',   'property' => 'fb:app_id',                          'content' => FB_APP_ID),
      array ('_k' => 'pol',   'property' => 'og:locale',                          'content' => 'zh_TW'),
      array ('_k' => 'pola',  'property' => 'og:locale:alternate',                'content' => 'en_US'),
      array ('_k' => 'pot',   'property' => 'og:type',                            'content' => 'article'),
      array ('_k' => 'paa',   'property' => 'article:author',                     'content' => FB_URL),
      array ('_k' => 'pap',   'property' => 'article:publisher',                  'content' => FB_URL),
      array ('_k' => 'pam',   'property' => 'article:modified_time',              'content' => date ('c')),
      array ('_k' => 'papt',  'property' => 'article:published_time',             'content' => date ('c')),
      array ('_k' => 'poil',  'property' => 'og:image',        'tag' => 'larger', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE),
      array ('_k' => 'poitl', 'property' => 'og:image:type',   'tag' => 'larger', 'content' => typeOfImg (MAIN_OG_URL)),
      array ('_k' => 'poiwl', 'property' => 'og:image:width',  'tag' => 'larger', 'content' => 1200),
      array ('_k' => 'poihl', 'property' => 'og:image:height', 'tag' => 'larger', 'content' => 630));
    
    $this->d4Links = array (
      array ('_k' => 'ras57x57',   'rel' => 'apple-touch-icon', 'sizes' => '57x57',                          'href' => URL_IMG_FAVICON . 'apple-icon-57x57.png'),
      array ('_k' => 'ras60x60',   'rel' => 'apple-touch-icon', 'sizes' => '60x60',                          'href' => URL_IMG_FAVICON . 'apple-icon-60x60.png'),
      array ('_k' => 'ras72x72',   'rel' => 'apple-touch-icon', 'sizes' => '72x72',                          'href' => URL_IMG_FAVICON . 'apple-icon-72x72.png'),
      array ('_k' => 'ras76x76',   'rel' => 'apple-touch-icon', 'sizes' => '76x76',                          'href' => URL_IMG_FAVICON . 'apple-icon-76x76.png'),
      array ('_k' => 'ras114x114', 'rel' => 'apple-touch-icon', 'sizes' => '114x114',                        'href' => URL_IMG_FAVICON . 'apple-icon-114x114.png'),
      array ('_k' => 'ras120x120', 'rel' => 'apple-touch-icon', 'sizes' => '120x120',                        'href' => URL_IMG_FAVICON . 'apple-icon-120x120.png'),
      array ('_k' => 'ras144x144', 'rel' => 'apple-touch-icon', 'sizes' => '144x144',                        'href' => URL_IMG_FAVICON . 'apple-icon-144x144.png'),
      array ('_k' => 'ras152x152', 'rel' => 'apple-touch-icon', 'sizes' => '152x152',                        'href' => URL_IMG_FAVICON . 'apple-icon-152x152.png'),
      array ('_k' => 'ras180x180', 'rel' => 'apple-touch-icon', 'sizes' => '180x180',                        'href' => URL_IMG_FAVICON . 'apple-icon-180x180.png'),
      array ('_k' => 'ris192x192', 'rel' => 'icon',             'sizes' => '192x192', 'type' => 'image/png', 'href' => URL_IMG_FAVICON . 'android-icon-192x192.png'),
      array ('_k' => 'ris32x32',   'rel' => 'icon',             'sizes' => '32x32',   'type' => 'image/png', 'href' => URL_IMG_FAVICON . 'favicon-32x32.png'),
      array ('_k' => 'ris96x96',   'rel' => 'icon',             'sizes' => '96x96',   'type' => 'image/png', 'href' => URL_IMG_FAVICON . 'favicon-96x96.png'),
      array ('_k' => 'ris16x16',   'rel' => 'icon',             'sizes' => '16x16',   'type' => 'image/png', 'href' => URL_IMG_FAVICON . 'favicon-16x16.png'),
      array ('_k' => 'rm',         'rel' => 'manifest',                                                      'href' => URL_IMG_FAVICON . 'manifest.json'),
      array ('_k' => 'rc',         'rel' => 'canonical',                                                     'href' => PAGE_URL_INDEX),
      array ('_k' => 'ra',         'rel' => 'alternate',                                                     'href' => PAGE_URL_INDEX, 'hreflang' => 'zh-Hant'),
      array ('_k' => 'rs',         'rel' => 'stylesheet',                             'type' => 'text/css',  'href' => 'https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700')
    );
  }
  private function _view ($__o__p__ = '', $__o__d__ = array ()) {
    $__o__d__ = array_merge ($__o__d__, $this->pais);

    if (!$__o__p__) return '';
    extract ($__o__d__); ob_start ();
    if (((bool)@ini_get ('short_open_tag') === FALSE) && (false == TRUE)) echo eval ('?>' . preg_replace ("/;*\s*\?>/u", "; ?>", str_replace ('<?=', '<?php echo ', file_get_contents ($__o__p__))));
    else include $__o__p__;
    $buffer = ob_get_contents ();
    @ob_end_clean ();
    return $buffer;
  }
  private function _filter ($d4s = array (), $news = array ()) {
    $tmp = array ();

    foreach ($d4s as $d4)
      $tmp[$d4['_k']] = $d4;

    foreach ($news as $new)
      if (isset ($new['_k'])) $tmp[$new['_k']] = $new;
      else array_push($tmp, $new);

    return $tmp;
  }
  public function meta () {
    return implode (DEV ? "\n" : '', array_map (function ($attrs) {
        return '<meta ' . implode (' ', array_filter (array_map (function ($attr, $value) { return $attr !== '_k' ? $attr . '="' . $value . '"' : null; }, array_keys ($attrs), $attrs))) . ' />';
      }, $this->_filter ($this->d4Metas, func_get_args ())));
  }
  public function link () {
    return implode (DEV ? "\n" : '', array_map (function ($attrs) {
        return '<link ' . implode (' ', array_filter (array_map (function ($attr, $value) { return $attr !== '_k' ? $attr . '="' . $value . '"' : null; }, array_keys ($attrs), $attrs))) . ' />';
      }, $this->_filter ($this->d4Links, func_get_args ())));
  }
  public function title ($str = '') {
    return '<title>' . ($str ? $str . ' - ' : '') . MAIN_TITLE . '</title>';
  }
  public function css () {
    return implode (DEV ? "\n" : '', array_map (function ($path) {
      return '<link href="' . $path . '" rel="stylesheet" type="text/css" />';
    }, Minify::css (array_merge (array (
      'css/icon' . CSS,
      'css/public' . CSS
    ), func_get_args ()))));
  }
  public function js () {
    return implode (DEV ? "\n" : '', array_map (function ($path) {
      return '<script src="' . $path . '" language="javascript" type="text/javascript" ></script>';  
    }, Minify::js (array_merge (array (
      'js/public' . JS
    ), func_get_args ()))));
  }
  public function jsonLd ($jsonLd = array ()) {
    return $jsonLd ? '<script type="application/ld+json">' . json_encode ($jsonLd, DEV ? JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES : JSON_UNESCAPED_SLASHES) . '</script>' : '';
  }
  public function scope () {
    return implode (DEV ? "\n" : '', array_map (function ($scope) {
      return '<div class="_s" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="' . $scope['href'] . '"><span itemprop="title">' . $scope['title'] . '</span></a></div>';
    }, array_filter (func_get_args (), function ($scope) {
      return isset ($scope['href']) && isset ($scope['title']) && $scope['href'] && $scope['title'];
    })));
  }
  public function frame ($parma = array ()) {
    return HTMLMin::minify ($this->_view (VIEW_PATH_FRAME, $parma));
  }
  public function __call ($name, $arguments) {
    if (!(file_exists (VIEWS_PATH . $name . PHP) && is_readable (VIEWS_PATH . $name . PHP)))
      return null;

    return $this->_view (VIEWS_PATH . $name . PHP, isset ($arguments[0]) ? $arguments[0] : array ());
  }
}