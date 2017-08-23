<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class Build {
  private $sitemapInfos = array ();

  public function __construct () { }

  public function error ($e) {
    header ('Content-Type: application/json', 'true');
    echo json_encode (array ('status' => false, 'message' => $e));
    exit();
  }

  public function clean ($title) {
    $ps = array (PATH_ASSET, PATH_SITEMAP, PATH_DEVS, PATH_LIVES, PATH_UNBOXINGS, PATH_ALBUMS, PATH_DEV, PATH_LIVE, PATH_UNBOXING, PATH_ALBUM);
    foreach ($ps as $p) deleteDir ($p);

    $fs = array (PAGE_PATH_INDEX, PAGE_PATH_TIMELINE, PAGE_PATH_LICENSE);

    foreach ($fs as $f) @unlink ($f);
  }
  public function init ($title) {
    $ps = array (PATH_ASSET, PATH_SITEMAP, PATH_DEVS, PATH_LIVES, PATH_UNBOXINGS, PATH_ALBUMS, PATH_DEV, PATH_LIVE, PATH_UNBOXING, PATH_ALBUM);

    if ($t = array_filter (array_map (function ($p) {
      if (!file_exists ($p)) mkdir777 ($p);
      return !(is_dir ($p) && is_writable ($p)) ? ' 目錄：' . $p : '';
    }, $ps))) return $this->error ($title . '失敗：' . implode (', ', $t));
  }

  public function indexHtml ($title) {
    // if (!$home = (($home = myReadFile (PATH_APIS . 'home.json')) ? json_decode ($home, true) : null))
    //   return $this->error ($title . '失敗！');

    if (!(($load = new Load ()) && myWriteFile (PAGE_PATH_INDEX, $load->frame (array (
      'meta'   => $load->meta (),
      'title'  => $load->title (),
      'link'   => $load->link (),
      'css'    => $load->css (),
      'js'     => $load->js (),
      'jsonLd' => $load->jsonLd (),
      'scope'  => $load->scope (),

      'header' => $load->_header (),
      'menu'   => $load->_menu (),
      'info'   => $load->_info (),
      'main'   => $load->index (),
    ))))) return $this->error ($title . '失敗！');

    // if (!myWriteFile (PAGE_PATH_INDEX, HTMLMin::minify (loadView (VIEW_PATH_FRAME, array (
    //     'header' => loadView (VIEW_PATH_HEADER, array ('active' => PAGE_URL_INDEX)),
    //     // 'title' => '首頁',
    //     // 'meta' => meta (
    //     //     array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
    //     //     array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 150, '…','UTF-8')),
    //     //     array ('property' => 'og:url', 'content' => PAGE_URL_INDEX),
    //     //     array ('property' => 'og:title', 'content' => '首頁 -' . MAIN_TITLE),
    //     //     array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
    //     //     array ('property' => 'article:modified_time', 'content' => date ('c')),
    //     //     array ('property' => 'article:published_time', 'content' => date ('c')),
    //     //     array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
    //     //     array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
    //     // 'jsonLd' => jsonLd (array (
    //     //     '@context' => 'http://schema.org', '@type' => 'Organization', 'name' => TITLE, 'url' => URL, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60),
    //     //     'description' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 150, '…','UTF-8'),
    //     //     'sameAs' => array (URL, FB_URL), 'image' => array ('@type' => 'ImageObject', 'url' => MAIN_OG_URL, 'height' => 630, 'width' => 1200),
    //     //     'datePublished' => date ('c', strtotime ('2013-10-08 08:00:00')), 'dateModified' => date ('c'),
    //     //   )),
    //     // 'link' => myLink (array ('rel' => 'canonical', 'href' => PAGE_URL_INDEX), array ('rel' => 'alternate', 'href' => PAGE_URL_INDEX, 'hreflang' => 'zh-Hant')),
    //     // 'scopes' => array (array ('url' => URL, 'title' => TITLE)),

    //     // 'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/index' . CSS),
    //     // 'js' => js ('js/public' . JS, 'js/index' . JS),
    //     // '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => PAGE_URL_INDEX)),
    //     // '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
    //     // 'banners' => $banners,
    //     // 'promos' => $promos,
    //   ))))) return $this->error ($title . '失敗！');

    array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_INDEX), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  }







  // public function aboutHtml ($title) {
  //   if (!myWriteFile (PAGE_PATH_ABOUT, HTMLMin::minify (loadView (PATH_VIEWS . 'about' . PHP, array (
  //         'title' => '關於宙思',
  //         'meta' => meta (
  //             array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //             array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 150, '…','UTF-8')),
  //             array ('property' => 'og:url', 'content' => PAGE_URL_ABOUT),
  //             array ('property' => 'og:title', 'content' => '關於宙思 -' . MAIN_TITLE),
  //             array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
  //             array ('property' => 'article:modified_time', 'content' => date ('c')),
  //             array ('property' => 'article:published_time', 'content' => date ('c')),
  //             array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //             array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //         'jsonLd' => jsonLd (array (
  //             '@context' => 'http://schema.org', '@type' => 'Article', 'url' => PAGE_URL_ABOUT, 'mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => PAGE_URL_ABOUT),
  //             'headline' => '關於宙思', 'image' => array ('@type' => 'ImageObject', 'url' => MAIN_OG_URL, 'height' => 630, 'width' => 1200),
  //             'datePublished' => date ('c', strtotime ('2013-10-08 08:00:00')), 'dateModified' => date ('c'),
  //             'description' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 150, '…','UTF-8'),
  //             'publisher' => array ('@type' => 'Organization', 'name' => TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)),
  //           )),
  //         'link' => myLink (array ('rel' => 'canonical', 'href' => PAGE_URL_ABOUT), array ('rel' => 'alternate', 'href' => PAGE_URL_ABOUT, 'hreflang' => 'zh-Hant')),
  //         'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => PAGE_URL_ABOUT, 'title' => '關於宙思')),

  //         'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/about' . CSS),
  //         'js' => js ('js/public' . JS),
  //         '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => PAGE_URL_ABOUT)),
  //         '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
  //       ))))) return $this->error ($title . '失敗！');

  //   array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_ABOUT), 'priority' => '0.4', 'changefreq' => 'weekly', 'lastmod' => date ('c'),));
  // }
  // public function contactHtml ($title) {
  //   if (!myWriteFile (PAGE_PATH_CONTACT, HTMLMin::minify (loadView (PATH_VIEWS . 'contact' . PHP, array (
  //         'title' => '聯絡我們',
  //         'meta' => meta (
  //             array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //             array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 150, '…','UTF-8')),
  //             array ('property' => 'og:url', 'content' => PAGE_URL_CONTACT),
  //             array ('property' => 'og:title', 'content' => '聯絡我們 -' . MAIN_TITLE),
  //             array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
  //             array ('property' => 'article:modified_time', 'content' => date ('c')),
  //             array ('property' => 'article:published_time', 'content' => date ('c')),
  //             array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //             array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //         'jsonLd' => jsonLd (array (
  //             '@context' => 'http://schema.org', '@type' => 'Article', 'url' => PAGE_URL_CONTACT, 'mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => PAGE_URL_CONTACT),
  //             'headline' => '聯絡我們', 'image' => array ('@type' => 'ImageObject', 'url' => MAIN_OG_URL, 'height' => 630, 'width' => 1200),
  //             'datePublished' => date ('c', strtotime ('2013-10-08 08:00:00')), 'dateModified' => date ('c'),
  //             'description' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 150, '…','UTF-8'),
  //             'publisher' => array ('@type' => 'Organization', 'name' => TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)),
  //           )),
  //         'link' => myLink (array ('rel' => 'canonical', 'href' => PAGE_URL_CONTACT), array ('rel' => 'alternate', 'href' => PAGE_URL_CONTACT, 'hreflang' => 'zh-Hant')),
  //         'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => PAGE_URL_CONTACT, 'title' => '聯絡我們')),

  //         'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/contact' . CSS),
  //         'js' => js ('js/public' . JS),
  //         '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => PAGE_URL_CONTACT)),
  //         '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
  //       ))))) return $this->error ($title . '失敗！');
  
  //   array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_CONTACT), 'priority' => '0.3', 'changefreq' => 'weekly', 'lastmod' => date ('c'),));
  // }
  // public function articlesHtml ($title) {
  //   $articles = array_filter (array_map (function ($article) {
  //     $article['url'] = urlArticle ($article['id'], $article['title']);
  //     $article['path'] = pathArticle ($article['id'], $article['title']);
  //     $article['jsonLd'] = array ('mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => $article['url']), 'headline' => $article['title'], 'image' => array ('@type' => 'ImageObject', 'url' => $article['cover']['c1200'], 'height' => 630, 'width' => 1200), 'datePublished' => date ('c', strtotime ($article['created_at'])), 'dateModified' => date ('c', strtotime ($article['updated_at'])), 'author' => array ('@type' => 'Person', 'name' => $article['user']['name'], 'url' => $article['user']['url'], 'image' => array ('@type' => 'ImageObject', 'url' => $article['user']['avatar'])), 'publisher' => array ('@type' => 'Organization', 'name' => TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => mb_strimwidth (removeHtmlTag ($article['content']), 0, 150, '…','UTF-8'));
  //     return DEV || $article['status'] ? $article : null;
  //   }, json_decode (myReadFile (PATH_APIS . 'articles.json'), true)));

  //   $tags = array ();
  //   foreach (columnArray ($articles, 'tags') as $ts)
  //     foreach ($ts as $t)
  //       if (!isset ($tags[$t['id']]))
  //         $tags[$t['id']] = $t;

  //   $tags = array_map (function ($tag) use ($articles) {
  //     return array_merge ($tag, array (
  //       'url' => sprintf (URL_TAG_ARTICLES, rawurlencode (urlFormat ($tag['name']))),
  //       'path' => sprintf (PATH_TAG_ARTICLES, urlFormat ($tag['name'])),
  //       'articles' => array_filter ($articles, function ($article) use ($tag) { return ($ids = columnArray ($article['tags'], 'id')) && in_array ($tag['id'], $ids); }), ));}, $tags);
    
  //   $articles = array_map (function ($article) use ($tags) { $article['tags'] = array_filter (array_map (function ($tag) use ($tags) { return isset ($tags[$tag['id']]) ? $tags[$tag['id']] : array (); }, $article['tags'])); return $article; }, $articles);

  //   $news = array_values ($articles); $hots = array_values ($articles);
  //   usort ($hots, function ($a, $b) { return $a['pv'] < $b['pv']; });
  //   $hots = array_slice ($hots, 0, 5); $news = array_slice ($news, 0, 5);
    
  //   $limit = 10;

  //   if ($total = count ($articles)) {
  //     for ($offset = 0; $offset < $total; $offset += $limit) {
  //       $i = 0; $as = array_slice ($articles, $offset, $limit); $html = (!$offset ? 'index' : $offset) . HTML;
        
  //       if (!myWriteFile (PATH_ARTICLES . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'articles' . PHP, array (
  //           'title' => '知識文章',
  //           'meta' => meta (
  //               array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //               array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag ($description = TITLE . '有著豐富的相關文章，你知道 ' . implode (',', columnArray ($as, 'title')) . ' 嗎？不知道的朋友沒關係，趕緊來看看宙思文章喔！'), 0, 150, '…','UTF-8')),
  //               array ('property' => 'og:url', 'content' => URL_ARTICLES . $html),
  //               array ('property' => 'og:title', 'content' => '知識文章' . ' - ' . MAIN_TITLE),
  //               array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag ($description, false), 0, 300, '…','UTF-8')),
  //               array ('property' => 'article:modified_time', 'content' => date ('c')),
  //               array ('property' => 'article:published_time', 'content' => date ('c')),
  //               array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //               array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //           'jsonLd' => jsonLd (array (
  //             '@context' => 'http://schema.org', '@type' => 'ItemList',
  //             'itemListElement' => array_map (function ($article) use ($offset, &$i) {
  //               return array_merge (array (
  //                     '@type' => 'Article',
  //                     'position' => $offset + ++$i,
  //                     'url' => $article['url']), $article['jsonLd']); }, $as))),
  //           'link' => myLink (array ('rel' => 'canonical', 'href' => URL_ARTICLES . $html), array ('rel' => 'alternate', 'href' => URL_ARTICLES . $html, 'hreflang' => 'zh-Hant')),
  //           'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_ARTICLES . $html, 'title' => '知識文章')),

  //           'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/article' . CSS, 'css/pagination' . CSS),
  //           'js' => js ('js/public' . JS),
  //           '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_ARTICLES)),
  //           '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
            
  //           'tags' => $tags,
  //           'news' => $news,
  //           'hots' => $hots,
  //           'articles' => $as,
  //           'pagination' => Pagination::initialize (array ('offset' => $offset, 'base_url' => URL_ARTICLES, 'total_rows' => $total, 'per_page' => $limit))->create_links (),
  //         ))))) return $this->error ($title . '失敗！');

  //       array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', URL_ARTICLES . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //     }
  //   } else {
  //     $html = 'index' . HTML;
  //     if (!myWriteFile (PATH_ARTICLES . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'articles' . PHP, array (
  //         'title' => '知識文章',
  //         'meta' => meta (
  //             array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //             array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION), 0, 150, '…','UTF-8')),
  //             array ('property' => 'og:url', 'content' => URL_ARTICLES . $html),
  //             array ('property' => 'og:title', 'content' => '知識文章' . ' - ' . MAIN_TITLE),
  //             array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
  //             array ('property' => 'article:modified_time', 'content' => date ('c')),
  //             array ('property' => 'article:published_time', 'content' => date ('c')),
  //             array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //             array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //         'jsonLd' => jsonLd (array ('@context' => 'http://schema.org', '@type' => 'ItemList', 'itemListElement' => array ())),
  //         'link' => myLink (array ('rel' => 'canonical', 'href' => URL_ARTICLES . $html), array ('rel' => 'alternate', 'href' => URL_ARTICLES . $html, 'hreflang' => 'zh-Hant')),
  //         'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_ARTICLES . $html, 'title' => '知識文章')),
          
  //         'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/article' . CSS, 'css/pagination' . CSS),
  //         'js' => js ('js/public' . JS),
  //         '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_ARTICLES)),
  //         '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),

  //         'tags' => $tags,
  //         'news' => $news,
  //         'hots' => $hots,
  //         'articles' => array (),
  //         'pagination' => '',
  //       ))))) return $this->error ($title . '失敗！');
  
  //     array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', URL_ARTICLES . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //   }

  //   foreach ($tags as $tag) {
  //     if (!file_exists ($tag['path'])) mkdir777 ($tag['path']);

  //     if ($total = count ($tag['articles'])) {
  //       for ($offset = 0; $offset < $total; $offset += $limit) {
  //         $i = 0; $as = array_slice ($tag['articles'], $offset, $limit); $html = (!$offset ? 'index' : $offset) . HTML;

  //         if (!myWriteFile ($tag['path'] . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'tag-articles' . PHP, array (
  //             'title' => $tag['name'] . '相關文章',
  //             'meta' => meta (
  //               array ('name' => 'keywords', 'content' => MAIN_KEYWORDS . ', ' . $tag['name']),
  //               array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag ($description = TITLE . '有著豐富的 「' . $tag['name'] . '」 相關文章，你知道 ' . implode (',', columnArray ($as, 'title')) . ' 嗎？不知道的朋友沒關係，趕緊來看看宙思文章喔！'), 0, 150, '…','UTF-8')),
  //               array ('property' => 'og:url', 'content' => $tag['url'] . $html),
  //               array ('property' => 'og:title', 'content' => $tag['name'] . '相關文章' . ' - ' . MAIN_TITLE),
  //               array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag ($description, false), 0, 300, '…','UTF-8')),
  //               array ('property' => 'article:modified_time', 'content' => date ('c')),
  //               array ('property' => 'article:published_time', 'content' => date ('c')),
  //               array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //               array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //             'jsonLd' => jsonLd (array (
  //               '@context' => 'http://schema.org', '@type' => 'ItemList',
  //               'itemListElement' => array_map (function ($article) use ($offset, &$i) {
  //                 return array_merge (array (
  //                       '@type' => 'Article',
  //                       'position' => $offset + ++$i,
  //                       'url' => $article['url']), $article['jsonLd']); }, $as))),
  //             'link' => myLink (array ('rel' => 'canonical', 'href' => $tag['url'] . $html), array ('rel' => 'alternate', 'href' => $tag['url'] . $html, 'hreflang' => 'zh-Hant')),
  //             'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_ARTICLES . 'index' . HTML, 'title' => '知識文章'), array ('url' => $tag['url'] . $html, 'title' => $tag['name'] . '相關文章')),

  //             'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/article' . CSS, 'css/pagination' . CSS),
  //             'js' => js ('js/public' . JS),
  //             '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_ARTICLES)),
  //             '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),

  //             'tag' => $tag,
  //             'tags' => $tags,
  //             'news' => $news,
  //             'hots' => $hots,
  //             'articles' => $as,
  //             'pagination' => Pagination::initialize (array ('offset' => $offset, 'base_url' => URL_ARTICLES, 'total_rows' => $total, 'per_page' => $limit))->create_links (),
  //           ))))) return $this->error ($title . '失敗！');

  //         array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $tag['url'] . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //       }
  //     } else {
  //       $html = 'index' . HTML;
  //       if (!myWriteFile ($tag['path'] . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'tag-articles' . PHP, array (
  //           'title' => $tag['name'] . '相關文章',
  //           'meta' => meta (
  //               array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //               array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION), 0, 150, '…','UTF-8')),
  //               array ('property' => 'og:url', 'content' => $tag['url'] . $html),
  //               array ('property' => 'og:title', 'content' => $tag['name'] . '相關文章' . ' - ' . MAIN_TITLE),
  //               array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
  //               array ('property' => 'article:modified_time', 'content' => date ('c')),
  //               array ('property' => 'article:published_time', 'content' => date ('c')),
  //               array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //               array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //           'jsonLd' => jsonLd (array ('@context' => 'http://schema.org', '@type' => 'ItemList', 'itemListElement' => array ())),
  //           'link' => myLink (array ('rel' => 'canonical', 'href' => $tag['url'] . $html), array ('rel' => 'alternate', 'href' => $tag['url'] . $html, 'hreflang' => 'zh-Hant')),
  //           'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_ARTICLES . 'index' . HTML, 'title' => '知識文章'), array ('url' => $tag['url'] . $html, 'title' => $tag['name'] . '相關文章')),

  //           'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/article' . CSS, 'css/pagination' . CSS),
  //           'js' => js ('js/public' . JS),
  //           '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_ARTICLES)),
  //           '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),

  //           'tag' => $tag,
  //           'tags' => $tags,
  //           'news' => $news,
  //           'hots' => $hots,
  //           'articles' => array (),
  //           'pagination' => '',
  //         ))))) return $this->error ($title . '失敗！');

  //       array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $tag['url'] . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //     }
  //   }

  //   foreach ($articles as $article) {
  //     if (!myWriteFile ($article['path'], HTMLMin::minify (loadView (PATH_VIEWS . 'article' . PHP, array (
  //         'title' => $article['title'],
  //         'meta' => meta (
  //             array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //             array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag ($article['content']), 0, 150, '…','UTF-8')),
  //             array ('property' => 'og:url', 'content' => $article['url']),
  //             array ('property' => 'og:title', 'content' => $article['title'] . ' - ' . MAIN_TITLE),
  //             array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag ($article['content'], false), 0, 300, '…','UTF-8')),
  //             array ('property' => 'article:modified_time', 'content' => date ('c', strtotime ($article['updated_at']))),
  //             array ('property' => 'article:published_time', 'content' => date ('c', strtotime ($article['created_at']))),
  //             array ('property' => 'og:image', 'content' => $article['cover']['c1200'], 'alt' => $article['title'] . ' - ' . MAIN_TITLE),
  //             array ('property' => 'og:image:type', 'content' => typeOfImg ($article['cover']['c1200']), 'tag' => 'larger')),
  //         'jsonLd' => jsonLd (array_merge (array (
  //           '@context' => 'http://schema.org',
  //           '@type' => 'Article',
  //           'url' => $article['url']), $article['jsonLd'])),
  //         'link' => myLink (array ('rel' => 'canonical', 'href' => $article['url']), array ('rel' => 'alternate', 'href' => $article['url'], 'hreflang' => 'zh-Hant')),
  //         'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_ARTICLES . 'index' . HTML, 'title' => '知識文章'), array ('url' => $article['url'], 'title' => $article['title'])),
          
  //         'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/article' . CSS),
  //         'js' => js ('js/public' . JS),
  //         '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_ARTICLES)),
  //         '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),

  //         'tags' => $tags,
  //         'news' => $news,
  //         'hots' => $hots,
  //         'article' => $article,
  //       ))))) return $this->error ($title . '失敗！');

  //     array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $article['url']), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //   }
  // }
  // public function worksHtml ($title) {
  //   $ntags = array_map (function ($tag) {
  //     $tag['url'] = sprintf (URL_TAG_WORKS, rawurlencode (urlFormat ($tag['name'])));
  //     $tag['path'] = sprintf (PATH_TAG_WORKS, urlFormat ($tag['name']));
  //     $tag['subs'] = array_map (function ($tag) { $tag['url'] = sprintf (URL_TAG_WORKS, rawurlencode (urlFormat ($tag['name']))); $tag['path'] = sprintf (PATH_TAG_WORKS, urlFormat ($tag['name'])); return $tag; }, $tag['subs']); return $tag; }, json_decode (myReadFile (PATH_APIS . 'work_tags.json'), true));

  //   $works = array_filter (array_map (function ($work) {
  //     $work['url'] = urlWrok ($work['id'], $work['title']);
  //     $work['path'] = pathWrok ($work['id'], $work['title']);
  //     $work['jsonLd'] = array ('mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => $work['url']), 'headline' => $work['title'], 'image' => array ('@type' => 'ImageObject', 'url' => $work['cover']['c1200'], 'height' => 630, 'width' => 1200), 'datePublished' => date ('c', strtotime ($work['created_at'])), 'dateModified' => date ('c', strtotime ($work['updated_at'])), 'author' => array ('@type' => 'Person', 'name' => $work['user']['name'], 'url' => $work['user']['url'], 'image' => array ('@type' => 'ImageObject', 'url' => $work['user']['avatar'])), 'publisher' => array ('@type' => 'Organization', 'name' => TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => mb_strimwidth (removeHtmlTag ($work['content']), 0, 150, '…','UTF-8'));
  //     return DEV || $work['status'] ? $work : null;
  //   }, json_decode (myReadFile (PATH_APIS . 'works.json'), true)));

  //   $tags = array ();
  //   foreach ($ntags as $nt) {
  //     if (!isset ($tags[$nt['id']])) $tags[$nt['id']] = $nt;
  //     foreach ($nt['subs'] as $t) if (!isset ($tags[$t['id']])) $tags[$t['id']] = $t;
  //   }

  //   $tags = array_map (function ($tag) use ($works) {
  //     return array_merge ($tag, array (
  //       'url' => sprintf (URL_TAG_WORKS, rawurlencode (urlFormat ($tag['name']))),
  //       'path' => sprintf (PATH_TAG_WORKS, urlFormat ($tag['name'])),
  //       'works' => array_filter ($works, function ($work) use ($tag) { return ($ids = columnArray ($work['tags'], 'id')) && in_array ($tag['id'], $ids); }), )); }, $tags);

  //   $works = array_map (function ($work) use ($tags) { $work['tags'] = array_filter (array_map (function ($tag) use ($tags) { return isset ($tags[$tag['id']]) ? $tags[$tag['id']] : array (); }, $work['tags'])); return $work; }, $works);

  //   $limit = 9;
  //   if ($total = count ($works)) {
  //     for ($offset = 0; $offset < $total; $offset += $limit) {
  //       $i = 0; $ws = array_slice ($works, $offset, $limit); $html = (!$offset ? 'index' : $offset) . HTML;
        
  //       if (!myWriteFile (PATH_WORKS . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'works' . PHP, array (
  //           'title' => '設計作品',
  //           'meta' => meta (
  //               array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //               array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag ($description = TITLE . '有著豐富的設計作品，你知道 ' . implode (',', columnArray ($ws, 'title')) . ' 嗎？不知道的朋友沒關係，趕緊來看看宙思的設計作品喔！'), 0, 150, '…','UTF-8')),
  //               array ('property' => 'og:url', 'content' => URL_WORKS . $html),
  //               array ('property' => 'og:title', 'content' => '設計作品' . ' - ' . MAIN_TITLE),
  //               array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag ($description, false), 0, 300, '…','UTF-8')),
  //               array ('property' => 'article:modified_time', 'content' => date ('c')),
  //               array ('property' => 'article:published_time', 'content' => date ('c')),
  //               array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //               array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //           'jsonLd' => jsonLd (array (
  //             '@context' => 'http://schema.org', '@type' => 'ItemList',
  //             'itemListElement' => array_map (function ($work) use ($offset, &$i) {
  //               return array_merge (array (
  //                     '@type' => 'Article',
  //                     'position' => $offset + ++$i,
  //                     'url' => $work['url']), $work['jsonLd']); }, $ws))),
  //           'link' => myLink (array ('rel' => 'canonical', 'href' => URL_WORKS . $html), array ('rel' => 'alternate', 'href' => URL_WORKS . $html, 'hreflang' => 'zh-Hant')),
  //           'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_WORKS . $html, 'title' => '設計作品')),

  //           'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/work' . CSS, 'css/pagination' . CSS),
  //           'js' => js ('js/public' . JS),
  //           '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_WORKS)),
  //           '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
  //           'tags' => $ntags,
  //           'works' => $ws,
  //           'pagination' => Pagination::initialize (array ('offset' => $offset, 'base_url' => URL_WORKS, 'total_rows' => $total, 'per_page' => $limit))->create_links (),
  //         ))))) return $this->error ($title . '失敗！');

  //       array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', URL_WORKS . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //     }
  //   } else {
  //     $html = 'index' . HTML;
  //     if (!myWriteFile (PATH_WORKS . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'works' . PHP, array (
  //         'title' => '設計作品',
  //         'meta' => meta (
  //             array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //             array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION), 0, 150, '…','UTF-8')),
  //             array ('property' => 'og:url', 'content' => URL_WORKS . $html),
  //             array ('property' => 'og:title', 'content' => '設計作品' . ' - ' . MAIN_TITLE),
  //             array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
  //             array ('property' => 'article:modified_time', 'content' => date ('c')),
  //             array ('property' => 'article:published_time', 'content' => date ('c')),
  //             array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //             array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //         'jsonLd' => jsonLd (array ('@context' => 'http://schema.org', '@type' => 'ItemList', 'itemListElement' => array ())),
  //         'link' => myLink (array ('rel' => 'canonical', 'href' => URL_WORKS . $html), array ('rel' => 'alternate', 'href' => URL_WORKS . $html, 'hreflang' => 'zh-Hant')),
  //         'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_WORKS . $html, 'title' => '設計作品')),
          
  //         'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/work' . CSS, 'css/pagination' . CSS),
  //         'js' => js ('js/public' . JS),
  //         '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_WORKS)),
  //         '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
  //         'tags' => $ntags,
  //         'works' => array (),
  //         'pagination' => '',
  //       ))))) return $this->error ($title . '失敗！');
  
  //     array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', URL_WORKS . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //   }

  //   foreach ($tags as $tag) {
  //     if (!file_exists ($tag['path'])) mkdir777 ($tag['path']);

  //     if ($total = count ($tag['works'])) {
  //       for ($offset = 0; $offset < $total; $offset += $limit) {
  //         $i = 0; $ws = array_slice ($tag['works'], $offset, $limit); $html = (!$offset ? 'index' : $offset) . HTML;

  //         if (!myWriteFile ($tag['path'] . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'tag-works' . PHP, array (
  //             'title' => $tag['name'] . '相關作品',
  //             'meta' => meta (
  //               array ('name' => 'keywords', 'content' => MAIN_KEYWORDS . ', ' . $tag['name']),
  //               array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag ($description = TITLE . '有著豐富的 「' . $tag['name'] . '」 相關作品，你知道 ' . implode (',', columnArray ($ws, 'title')) . ' 嗎？不知道的朋友沒關係，趕緊來看看宙思的設計作品喔！'), 0, 150, '…','UTF-8')),
  //               array ('property' => 'og:url', 'content' => $tag['url'] . $html),
  //               array ('property' => 'og:title', 'content' => $tag['name'] . '相關作品' . ' - ' . MAIN_TITLE),
  //               array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag ($description, false), 0, 300, '…','UTF-8')),
  //               array ('property' => 'article:modified_time', 'content' => date ('c')),
  //               array ('property' => 'article:published_time', 'content' => date ('c')),
  //               array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //               array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //             'jsonLd' => jsonLd (array (
  //               '@context' => 'http://schema.org', '@type' => 'ItemList',
  //               'itemListElement' => array_map (function ($work) use ($offset, &$i) {
  //                 return array_merge (array (
  //                       '@type' => 'Article',
  //                       'position' => $offset + ++$i,
  //                       'url' => $work['url']), $work['jsonLd']); }, $ws))),
  //             'link' => myLink (array ('rel' => 'canonical', 'href' => $tag['url'] . $html), array ('rel' => 'alternate', 'href' => $tag['url'] . $html, 'hreflang' => 'zh-Hant')),
  //             'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_WORKS . 'index' . HTML, 'title' => '設計作品'), array ('url' => $tag['url'] . $html, 'title' => $tag['name'] . '相關作品')),

  //             'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/work' . CSS, 'css/pagination' . CSS),
  //             'js' => js ('js/public' . JS),
  //             '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_WORKS)),
  //             '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),

  //             'tag' => $tag,
  //             'tags' => $ntags,
  //             'works' => $ws,
  //             'pagination' => Pagination::initialize (array ('offset' => $offset, 'base_url' => URL_WORKS, 'total_rows' => $total, 'per_page' => $limit))->create_links (),
  //           ))))) return $this->error ($title . '失敗！');

  //         array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $tag['url'] . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //       }
  //     } else {
  //       $html = 'index' . HTML;
  //       if (!myWriteFile ($tag['path'] . $html, HTMLMin::minify (loadView (PATH_VIEWS . 'tag-works' . PHP, array (
  //           'title' => $tag['name'] . '相關作品',
  //           'meta' => meta (
  //               array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //               array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION), 0, 150, '…','UTF-8')),
  //               array ('property' => 'og:url', 'content' => $tag['url'] . $html),
  //               array ('property' => 'og:title', 'content' => $tag['name'] . '相關作品' . ' - ' . MAIN_TITLE),
  //               array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag (MAIN_DESCRIPTION, false), 0, 300, '…','UTF-8')),
  //               array ('property' => 'article:modified_time', 'content' => date ('c')),
  //               array ('property' => 'article:published_time', 'content' => date ('c')),
  //               array ('property' => 'og:image', 'content' => MAIN_OG_URL, 'alt' => MAIN_TITLE, 'tag' => 'larger'),
  //               array ('property' => 'og:image:type', 'content' => typeOfImg (MAIN_OG_URL), 'tag' => 'larger')),
  //           'jsonLd' => jsonLd (array ('@context' => 'http://schema.org', '@type' => 'ItemList', 'itemListElement' => array ())),
  //           'link' => myLink (array ('rel' => 'canonical', 'href' => $tag['url'] . $html), array ('rel' => 'alternate', 'href' => $tag['url'] . $html, 'hreflang' => 'zh-Hant')),
  //           'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_WORKS . 'index' . HTML, 'title' => '設計作品'), array ('url' => $tag['url'] . $html, 'title' => $tag['name'] . '相關作品')),

  //           'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/work' . CSS, 'css/pagination' . CSS),
  //           'js' => js ('js/public' . JS),
  //           '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_WORKS)),
  //           '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),

  //           'tag' => $tag,
  //           'tags' => $ntags,
  //           'works' => array (),
  //           'pagination' => '',
  //         ))))) return $this->error ($title . '失敗！');

  //       array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $tag['url'] . $html), 'priority' => '0.5', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //     }
  //   }

  //   foreach ($works as $work) {
  //     if (!myWriteFile ($work['path'], HTMLMin::minify (loadView (PATH_VIEWS . 'work' . PHP, array (
  //         'title' => $work['title'],
  //         'meta' => meta (
  //             array ('name' => 'keywords', 'content' => MAIN_KEYWORDS),
  //             array ('name' => 'description', 'content' => mb_strimwidth (removeHtmlTag ($work['content']), 0, 150, '…','UTF-8')),
  //             array ('property' => 'og:url', 'content' => $work['url']),
  //             array ('property' => 'og:title', 'content' => $work['title'] . ' - ' . MAIN_TITLE),
  //             array ('property' => 'og:description', 'content' => mb_strimwidth (removeHtmlTag ($work['content'], false), 0, 300, '…','UTF-8')),
  //             array ('property' => 'article:modified_time', 'content' => date ('c', strtotime ($work['updated_at']))),
  //             array ('property' => 'article:published_time', 'content' => date ('c', strtotime ($work['created_at']))),
  //             array ('property' => 'og:image', 'content' => $work['cover']['c1200'], 'alt' => $work['title'] . ' - ' . MAIN_TITLE),
  //             array ('property' => 'og:image:type', 'content' => typeOfImg ($work['cover']['c1200']), 'tag' => 'larger')),
  //         'jsonLd' => jsonLd (array_merge (array (
  //           '@context' => 'http://schema.org',
  //           '@type' => 'Article',
  //           'url' => $work['url']), $work['jsonLd'])),
  //         'link' => myLink (array ('rel' => 'canonical', 'href' => $work['url']), array ('rel' => 'alternate', 'href' => $work['url'], 'hreflang' => 'zh-Hant')),
  //         'scopes' => array (array ('url' => URL, 'title' => TITLE), array ('url' => URL_WORKS . 'index' . HTML, 'title' => '知識文章'), array ('url' => $work['url'], 'title' => $work['title'])),
          
  //         'css' => css ('css/icon' . CSS, 'css/public' . CSS, 'css/work' . CSS),
  //         'js' => js ('js/public' . JS),
  //         '_header' => loadView (PATH_VIEWS . '_header' . PHP, array ('active' => URL_WORKS)),
  //         '_footer' => loadView (PATH_VIEWS . '_footer' . PHP),
  //         'tags' => $ntags,
  //         'work' => $work,
  //       ))))) return $this->error ($title . '失敗！');

  //     array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $work['url']), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => date ('c'),));
  //   }
  // }
  // public function sitemap ($title) {
  //   $sitmap = new Sitemap ($domain = rtrim (URL, '/'));
  //   $sitmap->setPath (PATH_SITEMAP);
  //   $sitmap->setDomain ($domain);

  //   foreach ($this->sitemapInfos as $sitemapInfo)
  //     $sitmap->addItem ($sitemapInfo['uri'], $sitemapInfo['priority'], $sitemapInfo['changefreq'], $sitemapInfo['lastmod']);

  //   $sitmap->createSitemapIndex ($domain . '/sitemap/', date ('c'));
  // }
}