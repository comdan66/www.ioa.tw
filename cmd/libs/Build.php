<?php

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class Build {
  private $sitemapInfos = array ();
  private $apis = array ();

  public function __construct () { }

  public function error ($e) {
    header ('Content-Type: application/json', 'true');
    echo json_encode (array ('status' => false, 'message' => $e));
    exit();
  }

  public function clean ($title) {
    $ps = array (PATH_ASSET, PATH_SITEMAP, PATH_DEVS, PATH_BLOGS, PATH_UNBOXINGS, PATH_ALBUMS, PATH_ARTICLE, PATH_ALBUM);
    foreach ($ps as $p) deleteDir ($p);

    $fs = array (PAGE_PATH_INDEX, PAGE_PATH_TIMELINE, PAGE_PATH_LICENSE, PAGE_PATH_CAKERESUME, PAGE_PATH_SEARCH, JS_PATH_SEARCH, JS_PATH_TIMELINE);

    foreach ($fs as $f) @unlink ($f);
  }
  public function init ($title) {
    $ps = array (PATH_ASSET, PATH_SITEMAP, PATH_DEVS, PATH_BLOGS, PATH_UNBOXINGS, PATH_ALBUMS, PATH_ARTICLE, PATH_ALBUM);

    if ($t = array_filter (array_map (function ($p) {
      if (!file_exists ($p)) mkdir777 ($p);
      return !(is_dir ($p) && is_writable ($p)) ? ' 目錄：' . $p : '';
    }, $ps))) return $this->error ($title . '失敗：' . implode (', ', $t));
  }

  public function getApi ($title) {
    $this->apis['pv'] = DEV ? 'https://dev.admin.www.ioa.tw/api/pv/' : 'https://admin.www.ioa.tw/api/pv/';

    $this->apis['home'] = (($this->apis['home'] = myReadFile (PATH_APIS . 'home.json')) ? json_decode ($this->apis['home'], true) : null);
    $this->apis['license'] = (($this->apis['license'] = myReadFile (PATH_APIS . 'license.json')) ? json_decode ($this->apis['license'], true) : null);
    
    $this->apis['devs'] = array_map (function ($obj) {
      $obj['_url'] = pageUrl (URL_ARTICLE, $obj['id'], $obj['title']);
      $obj['_path'] = pagePath (PATH_ARTICLE, $obj['id'], $obj['title']);
      $obj['_jsonLd'] = array ('mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => $obj['_url']), 'headline' => $obj['title'], 'image' => array ('@type' => 'ImageObject', 'url' => $obj['cover']['c1200x630'], 'height' => 630, 'width' => 1200), 'datePublished' => datetime2Format ($obj['created_at']), 'dateModified' => datetime2Format ($obj['updated_at']), 'author' => array ('@type' => 'Person', 'name' => OA_NAME, 'url' => PAGE_URL_INDEX, 'image' => array ('@type' => 'ImageObject', 'url' => avatarUrl (OA_FB_UID))), 'publisher' => array ('@type' => 'Organization', 'name' => MAIN_TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => strCat ($obj['content'], 150));
      return $obj;
    }, (($this->apis['devs'] = myReadFile (PATH_APIS . 'devs.json')) ? json_decode ($this->apis['devs'], true) : array ()));

    $this->apis['blogs'] = array_map (function ($obj) {
      $obj['_url'] = pageUrl (URL_ARTICLE, $obj['id'], $obj['title']);
      $obj['_path'] = pagePath (PATH_ARTICLE, $obj['id'], $obj['title']);
      $obj['_jsonLd'] = array ('mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => $obj['_url']), 'headline' => $obj['title'], 'image' => array ('@type' => 'ImageObject', 'url' => $obj['cover']['c1200x630'], 'height' => 630, 'width' => 1200), 'datePublished' => datetime2Format ($obj['created_at']), 'dateModified' => datetime2Format ($obj['updated_at']), 'author' => array ('@type' => 'Person', 'name' => OA_NAME, 'url' => PAGE_URL_INDEX, 'image' => array ('@type' => 'ImageObject', 'url' => avatarUrl (OA_FB_UID))), 'publisher' => array ('@type' => 'Organization', 'name' => MAIN_TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => strCat ($obj['content'], 150));
      return $obj;
    }, (($this->apis['blogs'] = myReadFile (PATH_APIS . 'blogs.json')) ? json_decode ($this->apis['blogs'], true) : array ()));

    $this->apis['unboxings'] = array_map (function ($obj) {
      $obj['_url'] = pageUrl (URL_ARTICLE, $obj['id'], $obj['title']);
      $obj['_path'] = pagePath (PATH_ARTICLE, $obj['id'], $obj['title']);
      $obj['_jsonLd'] = array ('mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => $obj['_url']), 'headline' => $obj['title'], 'image' => array ('@type' => 'ImageObject', 'url' => $obj['cover']['c1200x630'], 'height' => 630, 'width' => 1200), 'datePublished' => datetime2Format ($obj['created_at']), 'dateModified' => datetime2Format ($obj['updated_at']), 'author' => array ('@type' => 'Person', 'name' => OA_NAME, 'url' => PAGE_URL_INDEX, 'image' => array ('@type' => 'ImageObject', 'url' => avatarUrl (OA_FB_UID))), 'publisher' => array ('@type' => 'Organization', 'name' => MAIN_TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => strCat ($obj['content'], 150));
      return $obj;
    }, (($this->apis['unboxings'] = myReadFile (PATH_APIS . 'unboxings.json')) ? json_decode ($this->apis['unboxings'], true) : array ()));

    $this->apis['stars'] = array_map (function ($obj) {
      return $obj;
    }, (($this->apis['stars'] = myReadFile (PATH_APIS . 'stars.json')) ? json_decode ($this->apis['stars'], true) : array ()));

    $this->apis['albums'] = array_map (function ($obj) {
      $obj['_url'] = pageUrl (URL_ALBUM, $obj['id'], $obj['title']);
      $obj['_path'] = pagePath (PATH_ALBUM, $obj['id'], $obj['title']);
      $obj['_jsonLd'] = array ('mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => $obj['_url']), 'headline' => $obj['title'], 'image' => array ('@type' => 'ImageObject', 'url' => $obj['cover']['c1200x630'], 'height' => 630, 'width' => 1200), 'datePublished' => datetime2Format ($obj['created_at']), 'dateModified' => datetime2Format ($obj['updated_at']), 'author' => array ('@type' => 'Person', 'name' => OA_NAME, 'url' => PAGE_URL_INDEX, 'image' => array ('@type' => 'ImageObject', 'url' => avatarUrl (OA_FB_UID))), 'publisher' => array ('@type' => 'Organization', 'name' => MAIN_TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => strCat ($obj['content'], 150));
      return $obj;
    }, (($this->apis['albums'] = myReadFile (PATH_APIS . 'albums.json')) ? json_decode ($this->apis['albums'], true) : array ()));
  }

  public function indexHtml ($title) {
    $ptitle = '首頁';

    if (!(($load = new Load ($this->apis)) && myWriteFile (PAGE_PATH_INDEX, $load->frame (array (
      'title'  => $load->title ($ptitle),
      'meta'   => $load->meta (
        array ('_k' => 'poi',  'property' => 'og:title',           'content' => $ptitle . ' - ' . MAIN_TITLE),
        array ('_k' => 'pam',  'property' => 'article:modified_time',  'content' => datetime2Format ($this->apis['home']['updated_at'])),
        array ('_k' => 'papt', 'property' => 'article:published_time', 'content' => datetime2Format ($this->apis['home']['created_at']))),
      'jsonLd' => $load->jsonLd (array (
        '@context' => 'http://schema.org', '@type' => 'Organization',
        'name' => MAIN_TITLE, 'url' => PAGE_URL_INDEX,
        'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60),
        'description' => strCat (MAIN_DESCRIPTION, 150),
        'sameAs' => array (
          'https://www.ioa.tw/',
          'https://www.facebook.com/comdan66',
          'https://github.com/comdan66',
          'https://www.youtube.com/user/comdan66',
          'https://plus.google.com/u/0/+吳政賢',
          'https://picasaweb.google.com/108708350604082729522',
          'https://www.flickr.com/comdan66',
          'https://www.linkedin.com/in/政賢-吳-116136a1'))),
      'link'   => $load->link (),
      'scopes' => $load->scope (array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE)),
      'css'    => $load->css (),
      'js'     => $load->js (),
      'header' => $load->_header (),
      'info'   => $load->_info (),
      'menu'   => $load->_menu (array ('now' => 'index')),
      'main'   => $load->index (),
    ))))) return $this->error ($title . '失敗！');

    array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_INDEX), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => date ('c')));
  }
  public function searchHtml ($title) {
    $objs = array_merge (array_map (function ($t) {
      return array ('g' => '開發心得', 'h' => PAGE_URL_DEVS, 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 300, '…','UTF-8'), 'm' => $t['icon']['c300x300'], 'l' => $t['_url'], 'a' => $t['tag']['title'], 'b' => $t['tag']['key'], 's' => array_values (columnArray ($t['tags'], 'name')));
    }, $this->apis['devs']), array_map (function ($t) {
      return array ('g' => '生活紀錄', 'h' => PAGE_URL_BLOGS, 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 300, '…','UTF-8'), 'm' => $t['icon']['c300x300'], 'l' => $t['_url'], 'a' => $t['tag']['title'], 'b' => $t['tag']['key'], 's' => array_values (columnArray ($t['tags'], 'name')));
    }, $this->apis['blogs']), array_map (function ($t) {
      return array ('g' => '開箱文章', 'h' => PAGE_URL_UNBOXINGS, 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 300, '…','UTF-8'), 'm' => $t['icon']['c300x300'], 'l' => $t['_url'], 'a' => $t['tag']['title'], 'b' => $t['tag']['key'], 's' => array_values (columnArray ($t['tags'], 'name')));
    }, $this->apis['unboxings']), array_map (function ($t) {
      return array ('g' => '個人相簿', 'h' => PAGE_URL_ALBUMS, 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 300, '…','UTF-8'), 'm' => $t['cover']['c630x315'], 'l' => $t['_url'], 'a' => $t['tag']['title'], 'b' => $t['tag']['key'], 's' => array_values (columnArray ($t['tags'], 'name')));
    }, $this->apis['albums']));

    if (!myWriteFile (JS_PATH_SEARCH, "/*!\n * Fuse.js v3.0.5 - Lightweight fuzzy-search (http://fusejs.io)\n * \n * Copyright (c) 2012-2017 Kirollos Risk (http://kiro.me)\n * All Rights Reserved. Apache Software License 2.0\n * \n * http://www.apache.org/licenses/LICENSE-2.0\n */\n\n!function(e,t){\"object\"==typeof exports&&\"object\"==typeof module?module.exports=t():\"function\"==typeof define&&define.amd?define(\"Fuse\",[],t):\"object\"==typeof exports?exports.Fuse=t():e.Fuse=t()}(this,function(){return function(e){function t(n){if(r[n])return r[n].exports;var o=r[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var r={};return t.m=e,t.c=r,t.i=function(e){return e},t.d=function(e,r,n){t.o(e,r)||Object.defineProperty(e,r,{configurable:!1,enumerable:!0,get:n})},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,\"a\",r),r},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p=\"\",t(t.s=8)}([function(e,t,r){\"use strict\";e.exports=function(e){return\"[object Array]\"===Object.prototype.toString.call(e)}},function(e,t,r){\"use strict\";function n(e,t){if(!(e instanceof t))throw new TypeError(\"Cannot call a class as a function\")}var o=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,\"value\"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),i=r(5),a=r(7),s=r(4),c=function(){function e(t,r){var o=r.location,i=void 0===o?0:o,a=r.distance,c=void 0===a?100:a,h=r.threshold,l=void 0===h?.6:h,u=r.maxPatternLength,f=void 0===u?32:u,d=r.isCaseSensitive,v=void 0!==d&&d,p=r.tokenSeparator,g=void 0===p?/ +/g:p,y=r.findAllMatches,m=void 0!==y&&y,k=r.minMatchCharLength,x=void 0===k?1:k;n(this,e),this.options={location:i,distance:c,threshold:l,maxPatternLength:f,isCaseSensitive:v,tokenSeparator:g,findAllMatches:m,minMatchCharLength:x},this.pattern=this.options.isCaseSensitive?t:t.toLowerCase(),this.pattern.length<=f&&(this.patternAlphabet=s(this.pattern))}return o(e,[{key:\"search\",value:function(e){if(this.options.isCaseSensitive||(e=e.toLowerCase()),this.pattern===e)return{isMatch:!0,score:0,matchedIndices:[[0,e.length-1]]};var t=this.options,r=t.maxPatternLength,n=t.tokenSeparator;if(this.pattern.length>r)return i(e,this.pattern,n);var o=this.options,s=o.location,c=o.distance,h=o.threshold,l=o.findAllMatches,u=o.minMatchCharLength;return a(e,this.pattern,this.patternAlphabet,{location:s,distance:c,threshold:h,findAllMatches:l,minMatchCharLength:u})}}]),e}();e.exports=c},function(e,t,r){\"use strict\";var n=r(0),o=function e(t,r,o){if(r){var i=r.indexOf(\".\"),a=r,s=null;-1!==i&&(a=r.slice(0,i),s=r.slice(i+1));var c=t[a];if(null!==c&&void 0!==c)if(s||\"string\"!=typeof c&&\"number\"!=typeof c)if(n(c))for(var h=0,l=c.length;h<l;h+=1)e(c[h],s,o);else s&&e(c,s,o);else o.push(c)}else o.push(t);return o};e.exports=function(e,t){return o(e,t,[])}},function(e,t,r){\"use strict\";e.exports=function(){for(var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,r=[],n=-1,o=-1,i=0,a=e.length;i<a;i+=1){var s=e[i];s&&-1===n?n=i:s||-1===n||(o=i-1,o-n+1>=t&&r.push([n,o]),n=-1)}return e[i-1]&&i-n>=t&&r.push([n,i-1]),r}},function(e,t,r){\"use strict\";e.exports=function(e){for(var t={},r=e.length,n=0;n<r;n+=1)t[e.charAt(n)]=0;for(var o=0;o<r;o+=1)t[e.charAt(o)]|=1<<r-o-1;return t}},function(e,t,r){\"use strict\";var n=/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g;e.exports=function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:/ +/g,o=new RegExp(t.replace(n,\"\\$&\").replace(r,\"|\")),i=e.match(o),a=!!i,s=[];if(a)for(var c=0,h=i.length;c<h;c+=1){var l=i[c];s.push([e.indexOf(l),l.length-1])}return{score:a?.5:1,isMatch:a,matchedIndices:s}}},function(e,t,r){\"use strict\";e.exports=function(e,t){var r=t.errors,n=void 0===r?0:r,o=t.currentLocation,i=void 0===o?0:o,a=t.expectedLocation,s=void 0===a?0:a,c=t.distance,h=void 0===c?100:c,l=n/e.length,u=Math.abs(s-i);return h?l+u/h:u?1:l}},function(e,t,r){\"use strict\";var n=r(6),o=r(3);e.exports=function(e,t,r,i){for(var a=i.location,s=void 0===a?0:a,c=i.distance,h=void 0===c?100:c,l=i.threshold,u=void 0===l?.6:l,f=i.findAllMatches,d=void 0!==f&&f,v=i.minMatchCharLength,p=void 0===v?1:v,g=s,y=e.length,m=u,k=e.indexOf(t,g),x=t.length,S=[],M=0;M<y;M+=1)S[M]=0;if(-1!==k){var b=n(t,{errors:0,currentLocation:k,expectedLocation:g,distance:h});if(m=Math.min(b,m),-1!==(k=e.lastIndexOf(t,g+x))){var _=n(t,{errors:0,currentLocation:k,expectedLocation:g,distance:h});m=Math.min(_,m)}}k=-1;for(var L=[],w=1,C=x+y,A=1<<x-1,I=0;I<x;I+=1){for(var O=0,F=C;O<F;){n(t,{errors:I,currentLocation:g+F,expectedLocation:g,distance:h})<=m?O=F:C=F,F=Math.floor((C-O)/2+O)}C=F;var P=Math.max(1,g-F+1),j=d?y:Math.min(g+F,y)+x,z=Array(j+2);z[j+1]=(1<<I)-1;for(var T=j;T>=P;T-=1){var E=T-1,K=r[e.charAt(E)];if(K&&(S[E]=1),z[T]=(z[T+1]<<1|1)&K,0!==I&&(z[T]|=(L[T+1]|L[T])<<1|1|L[T+1]),z[T]&A&&(w=n(t,{errors:I,currentLocation:E,expectedLocation:g,distance:h}))<=m){if(m=w,(k=E)<=g)break;P=Math.max(1,2*g-k)}}if(n(t,{errors:I+1,currentLocation:g,expectedLocation:g,distance:h})>m)break;L=z}return{isMatch:k>=0,score:0===w?.001:w,matchedIndices:o(S,p)}}},function(e,t,r){\"use strict\";function n(e,t){if(!(e instanceof t))throw new TypeError(\"Cannot call a class as a function\")}var o=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,\"value\"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),i=r(1),a=r(2),s=r(0),c=function(){function e(t,r){var o=r.location,i=void 0===o?0:o,s=r.distance,c=void 0===s?100:s,h=r.threshold,l=void 0===h?.6:h,u=r.maxPatternLength,f=void 0===u?32:u,d=r.caseSensitive,v=void 0!==d&&d,p=r.tokenSeparator,g=void 0===p?/ +/g:p,y=r.findAllMatches,m=void 0!==y&&y,k=r.minMatchCharLength,x=void 0===k?1:k,S=r.id,M=void 0===S?null:S,b=r.keys,_=void 0===b?[]:b,L=r.shouldSort,w=void 0===L||L,C=r.getFn,A=void 0===C?a:C,I=r.sortFn,O=void 0===I?function(e,t){return e.score-t.score}:I,F=r.tokenize,P=void 0!==F&&F,j=r.matchAllTokens,z=void 0!==j&&j,T=r.includeMatches,E=void 0!==T&&T,K=r.includeScore,$=void 0!==K&&K,J=r.verbose,N=void 0!==J&&J;n(this,e),this.options={location:i,distance:c,threshold:l,maxPatternLength:f,isCaseSensitive:v,tokenSeparator:g,findAllMatches:m,minMatchCharLength:x,id:M,keys:_,includeMatches:E,includeScore:$,shouldSort:w,getFn:A,sortFn:O,verbose:N,tokenize:P,matchAllTokens:z},this.setCollection(t)}return o(e,[{key:\"setCollection\",value:function(e){return this.list=e,e}},{key:\"search\",value:function(e){this._log('---------\\nSearch pattern: \"'+e+'\"');var t=this._prepareSearchers(e),r=t.tokenSearchers,n=t.fullSearcher,o=this._search(r,n),i=o.weights,a=o.results;return this._computeScore(i,a),this.options.shouldSort&&this._sort(a),this._format(a)}},{key:\"_prepareSearchers\",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:\"\",t=[];if(this.options.tokenize)for(var r=e.split(this.options.tokenSeparator),n=0,o=r.length;n<o;n+=1)t.push(new i(r[n],this.options));return{tokenSearchers:t,fullSearcher:new i(e,this.options)}}},{key:\"_search\",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=arguments[1],r=this.list,n={},o=[];if(\"string\"==typeof r[0]){for(var i=0,a=r.length;i<a;i+=1)this._analyze({key:\"\",value:r[i],record:i,index:i},{resultMap:n,results:o,tokenSearchers:e,fullSearcher:t});return{weights:null,results:o}}for(var s={},c=0,h=r.length;c<h;c+=1)for(var l=r[c],u=0,f=this.options.keys.length;u<f;u+=1){var d=this.options.keys[u];if(\"string\"!=typeof d){if(s[d.name]={weight:1-d.weight||1},d.weight<=0||d.weight>1)throw new Error(\"Key weight has to be > 0 and <= 1\");d=d.name}else s[d]={weight:1};this._analyze({key:d,value:this.options.getFn(l,d),record:l,index:c},{resultMap:n,results:o,tokenSearchers:e,fullSearcher:t})}return{weights:s,results:o}}},{key:\"_analyze\",value:function(e,t){var r=e.key,n=e.arrayIndex,o=void 0===n?-1:n,i=e.value,a=e.record,c=e.index,h=t.tokenSearchers,l=void 0===h?[]:h,u=t.fullSearcher,f=void 0===u?[]:u,d=t.resultMap,v=void 0===d?{}:d,p=t.results,g=void 0===p?[]:p;if(void 0!==i&&null!==i){var y=!1,m=-1,k=0;if(\"string\"==typeof i){this._log(\"\\nKey: \"+(\"\"===r?\"-\":r));var x=f.search(i);if(this._log('Full text: \"'+i+'\", score: '+x.score),this.options.tokenize){for(var S=i.split(this.options.tokenSeparator),M=[],b=0;b<l.length;b+=1){var _=l[b];this._log('\\nPattern: \"'+_.pattern+'\"');for(var L=!1,w=0;w<S.length;w+=1){var C=S[w],A=_.search(C),I={};A.isMatch?(I[C]=A.score,y=!0,L=!0,M.push(A.score)):(I[C]=1,this.options.matchAllTokens||M.push(1)),this._log('Token: \"'+C+'\", score: '+I[C])}L&&(k+=1)}m=M[0];for(var O=M.length,F=1;F<O;F+=1)m+=M[F];m/=O,this._log(\"Token score average:\",m)}var P=x.score;m>-1&&(P=(P+m)/2),this._log(\"Score average:\",P);var j=!this.options.tokenize||!this.options.matchAllTokens||k>=l.length;if(this._log(\"\\nCheck Matches: \"+j),(y||x.isMatch)&&j){var z=v[c];z?z.output.push({key:r,arrayIndex:o,value:i,score:P,matchedIndices:x.matchedIndices}):(v[c]={item:a,output:[{key:r,arrayIndex:o,value:i,score:P,matchedIndices:x.matchedIndices}]},g.push(v[c]))}}else if(s(i))for(var T=0,E=i.length;T<E;T+=1)this._analyze({key:r,arrayIndex:T,value:i[T],record:a,index:c},{resultMap:v,results:g,tokenSearchers:l,fullSearcher:f})}}},{key:\"_computeScore\",value:function(e,t){this._log(\"\\n\\nComputing score:\\n\");for(var r=0,n=t.length;r<n;r+=1){for(var o=t[r].output,i=o.length,a=0,s=1,c=0;c<i;c+=1){var h=o[c].score,l=e?e[o[c].key].weight:1,u=h*l;1!==l?s=Math.min(s,u):(o[c].nScore=u,a+=u)}t[r].score=1===s?a/i:s,this._log(t[r])}}},{key:\"_sort\",value:function(e){this._log(\"\\n\\nSorting....\"),e.sort(this.options.sortFn)}},{key:\"_format\",value:function(e){var t=[];this._log(\"\\n\\nOutput:\\n\\n\",JSON.stringify(e));var r=[];this.options.includeMatches&&r.push(function(e,t){var r=e.output;t.matches=[];for(var n=0,o=r.length;n<o;n+=1){var i=r[n];if(0!==i.matchedIndices.length){var a={indices:i.matchedIndices,value:i.value};i.key&&(a.key=i.key),i.hasOwnProperty(\"arrayIndex\")&&i.arrayIndex>-1&&(a.arrayIndex=i.arrayIndex),t.matches.push(a)}}}),this.options.includeScore&&r.push(function(e,t){t.score=e.score});for(var n=0,o=e.length;n<o;n+=1){var i=e[n];if(this.options.id&&(i.item=this.options.getFn(i.item,this.options.id)[0]),r.length){for(var a={item:i.item},s=0,c=r.length;s<c;s+=1)r[s](i,a);t.push(a)}else t.push(i.item)}return t}},{key:\"_log\",value:function(){if(this.options.verbose){var e;(e=console).log.apply(e,arguments)}}}]),e}();e.exports=c}])});\n\n\n/**\n * @author      OA Wu <comdan66@gmail.com>\n * @copyright   Copyright (c) 2017 OA Wu Design\n * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/\n */\n\nwindow.objs = " . json_encode ($objs) . ";\n\n$(function () {\n   function searchLayout (objs) {\n    var groups = {}, \$_s = $('#s').empty ();\n\n    objs.forEach (function (t) {\n      if (typeof groups[t.g] === 'undefined') groups[t.g] = {n: t.g, h: t.h, a: [t]};\n      else groups[t.g].a.push (t);\n    })\n\n    Object.values (groups).map (function (t) {\n      \$_s.append ($('<div />').addClass ('p580 t n2').append (\n        $('<span />').text (t.n)).append (\n        $('<span />').append ($('<a />').attr ('href', t.h).text ('更多…')))).append (\n          $('<div />').addClass ('p p580 l').append (\n            t.a.map (function (u) {\n              return $('<a />').attr ('href', u.l).append (\n                $('<figure />').addClass ('_ic').append (\n                  $('<img />').attr ('src', u.m))).append (\n                $('<b />').text (u.t).addClass ('c' + u.b).attr ('data-tip', u.a)).append (\n                $('<span />').text (u.c));\n              }))).find ('figure').OAIL ({verticalAlign: 'center'});\n    });\n  } \n\n  var url = new URL (location.href), n = url.pathname.substring (url.pathname.lastIndexOf ('/') + 1), q = url.searchParams.get ('q');\n  if (n === 'search.html') {\n    if (!(q && q.length)) window.location.replace (url.origin);\n    $('#q').val (decodeURIComponent (q));\n    var tag = q.match (/^tag:(.*)/), tags = q.match (/^tags:(.*)/);\n\n    searchLayout (tag === null ? tags !== null ? new Fuse (window.objs, { keys: ['s'] }).search (tags[1]) : new Fuse (window.objs, { keys: ['t', 'c'] }).search (q) : new Fuse (window.objs, { keys: ['a', 's'] }).search (tag[1]));\n  }\n});"))
      return $this->error ($title . '失敗！');

    $ptitle = '搜尋結果';
    $d = MAIN_DESCRIPTION;

    if (!(($load = new Load ($this->apis)) && myWriteFile (PAGE_PATH_SEARCH, $load->frame (array (
      'title'  => $load->title ($ptitle),
      'meta'   => $load->meta (
        array ('_k' => 'nd',    'name' => 'description',                'content' => strCat ($d, 150)),
        array ('_k' => 'pou',   'property' => 'og:url',                 'content' => PAGE_URL_SEARCH),
        array ('_k' => 'poi',   'property' => 'og:title',               'content' => $ptitle . ' - ' . MAIN_TITLE),
        array ('_k' => 'pod',   'property' => 'og:description',         'content' => strCat ($d, 200, false))),
      'jsonLd' => $load->jsonLd (array (
        '@context' => 'http://schema.org',
        '@type' => 'WebSite',
        'url' => URL,
        'potentialAction' => array (
          '@type' => 'SearchAction',
          'target' => PAGE_URL_SEARCH . '?q={keyword}&referrer=jsonLd_searchbox',
          'query-input' => 'required name=keyword'
        ))),
      'link'   => $load->link (
        array ('_k' => 'rc', 'rel' => 'canonical', 'href' => PAGE_URL_SEARCH),
        array ('_k' => 'ra', 'rel' => 'alternate', 'href' => PAGE_URL_SEARCH, 'hreflang' => 'zh-Hant')),
      'scopes' => $load->scope (
        array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE),
        array ('href' => PAGE_URL_SEARCH, 'title' => $ptitle)),
      'css'    => $load->css (),
      'js'     => $load->js ('js/search' . JS),
      'header' => $load->_header (),
      'info'   => $load->_info (),
      'menu'   => $load->_menu (array ('now' => 'search')),
      'main'   => $load->search (),
    ))))) return $this->error ($title . '失敗！');

    array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_SEARCH), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => date ('c')));
  }
  public function timelineHtml ($title) {
    $objs = array_merge (array_map (function ($t) {
      return array ('n' => $t['icon']['c300x300'], 'i' => 'icon-t', 'm' => datetime2Format ($t['date_at'], 'Y-m-d'), 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 120, '…','UTF-8'), 'u' => $t['_url'], 's' => array ());
    }, array_filter ($this->apis['devs'], function ($t) {
      return $t['timeline'] == 2;
    })), array_map (function ($t) {
      return array ('n' => $t['icon']['c300x300'], 'i' => 'icon-b', 'm' => datetime2Format ($t['date_at'], 'Y-m-d'), 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 120, '…','UTF-8'), 'u' => $t['_url'], 's' => array ());
    }, array_filter ($this->apis['blogs'], function ($t) {
      return $t['timeline'] == 2;
    })), array_map (function ($t) {
      return array ('n' => '', 'i' => 'icon-st', 'm' => datetime2Format ($t['date_at'], 'Y-m-d'), 't' => $t['title'], 'c' => removeHtmlTag ($t['content']), 'u' => '', 's' => array ());
    }, $this->apis['stars']), array_map (function ($t) {
      return array ('n' => $t['icon']['c300x300'], 'i' => 'icon-g', 'm' => datetime2Format ($t['date_at'], 'Y-m-d'), 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 120, '…','UTF-8'), 'u' => $t['_url'], 's' => array ());
    }, array_filter ($this->apis['unboxings'], function ($t) {
      return $t['timeline'] == 2;
    })), array_map (function ($t) {
      return array ('n' => '', 'i' => 'icon-i', 'm' => datetime2Format ($t['date_at'], 'Y-m-d'), 't' => $t['title'], 'c' => mb_strimwidth (removeHtmlTag ($t['content']), 0, 120, '…','UTF-8'), 'u' => $t['_url'], 's' => array_map (function ($u) {
        return array (
          'i' => $u['id'],
          't' => $u['title'],
          'm' => $u['name']['w800']);
      }, array_slice ($t['images'], 0, 3)));
    }, array_filter ($this->apis['albums'], function ($t) {
      return $t['timeline'] == 2;
    })));

    if (!myWriteFile (JS_PATH_TIMELINE, "/**\n * @author      OA Wu <comdan66@gmail.com>\n * @copyright   Copyright (c) 2017 OA Wu Design\n * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/\n */\n\n$(function () {\n  var objs = " . json_encode ($objs) . ";\n  var \$_l = $('#l'), \$_lb = $('#l + button');\n\n  function initObjElement (obj) {\n    return $('<section />').addClass ('s').append (\n      $('<div />').addClass ('o').addClass (!obj.s.length && obj.n.length ? 'v' : '').append (\n        $('<time />').attr ('data-time', obj.m).text ($.timeago (obj.m))).append (\n        $('<i />').addClass (obj.i)).append (\n        $('<h3 />').text (obj.t)).append (\n        $('<p />').text (obj.c).prepend (!obj.s.length && obj.n.length ? $('<figure />').addClass ('ic').append ($('<img />').attr ('src', obj.n)) : null)).append (\n        obj.s.length ? $('<div />').addClass ('n' + obj.s.length).append (obj.s.map (function (t, i) {\n          return (obj.s.length == i + 1 ? $('<a />').attr ('href', obj.u).attr ('target', '_blank') : $('<figure />')).attr ('data-pvid', 'ArticleImage-' + t.i).addClass ('ic').append (\n            $('<img />').attr ('src', t.m).attr ('alt', t.t.length ? '" . str_replace ("'", "\'", MAIN_TITLE) . "' : t.t)).append (\n            $('<figcaption />').text (t.t.length ? t.t : obj.t));\n        })) : null).append (\n        obj.u.length ? $('<span />').append ($('<a />').attr ('href', obj.u).attr ('target', '_blank').text ('詳細內容')) : null));\n  }\n  function initObjFeature (\$obj) {\n    \$obj.find ('.ic').OAIL ({verticalAlign: 'center'});\n    setTimeout (function () { \$obj.addClass ('ani'); }, 300);\n    window.OAIPS.set (\$obj, 'figure');\n    return \$obj;\n  }\n  function loadObjs () {\n    if (!objs.length) return;\n\n    \$_lb.get (0).c++;\n\n    objs.sort (function (a,b) {\n      a = new Date (a.m);\n      b = new Date (b.m);\n      return a > b ? -1 : a < b ? 1 : 0;\n    }); \n    objs.splice (0, 3).forEach (function (t) {\n      initObjFeature ($(initObjElement (t)).appendTo (\$_l));\n    });\n\n    if (!objs.length) \$_lb.remove ();\n\n    clearTimeout (\$_lb.get (0).st);\n    \$_lb.get (0).st = null;\n  }\n\n  if (\$_lb.length) {\n    \$_lb.get (0).c = 0;\n    \$_lb.click (loadObjs);\n    $(window).scroll (function () {\n      if (\$_lb.get (0).c >= 3) return;\n      if (\$_lb.get (0).st) return;\n      if (!($(window).height () + $(window).scrollTop () > \$_lb.offset ().top - 80)) return;\n\n      \$_lb.get (0).st = setTimeout (loadObjs, 500);\n    }).scroll ();\n  }\n});"))
      return $this->error ($title . '失敗！');

    $ptitle = '成就紀錄';
    $d = MAIN_DESCRIPTION;

    if (!(($load = new Load ($this->apis)) && myWriteFile (PAGE_PATH_TIMELINE, $load->frame (array (
      'title'  => $load->title ($ptitle),
      'meta'   => $load->meta (
        array ('_k' => 'nd',    'name' => 'description',                'content' => strCat ($d, 150)),
        array ('_k' => 'pou',   'property' => 'og:url',                 'content' => PAGE_URL_TIMELINE),
        array ('_k' => 'poi',   'property' => 'og:title',               'content' => $ptitle . ' - ' . MAIN_TITLE),
        array ('_k' => 'pod',   'property' => 'og:description',         'content' => strCat ($d, 200, false))),
      'jsonLd' => $load->jsonLd (array ('@context' => 'http://schema.org', '@type' => 'Article', 'url' => PAGE_URL_TIMELINE, 'mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => PAGE_URL_TIMELINE), 'headline' => $ptitle, 'image' => array ('@type' => 'ImageObject', 'url' => MAIN_OG_URL, 'height' => 630, 'width' => 1200), 'datePublished' => date ('c'), 'dateModified' => date ('c'), 'author' => array ('@type' => 'Person', 'name' => OA_NAME, 'url' => PAGE_URL_INDEX, 'image' => array ('@type' => 'ImageObject', 'url' => avatarUrl (OA_FB_UID))), 'publisher' => array ('@type' => 'Organization', 'name' => MAIN_TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => strCat ($d, 150))),
      'link'   => $load->link (
        array ('_k' => 'rc', 'rel' => 'canonical', 'href' => PAGE_URL_TIMELINE),
        array ('_k' => 'ra', 'rel' => 'alternate', 'href' => PAGE_URL_TIMELINE, 'hreflang' => 'zh-Hant')),
      'scopes' => $load->scope (
        array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE),
        array ('href' => PAGE_URL_TIMELINE, 'title' => $ptitle)),
      'css'    => $load->css (),
      'js'     => $load->js ('js/time' . JS),
      'header' => $load->_header (),
      'info'   => $load->_info (),
      'menu'   => $load->_menu (array ('now' => 'timeline')),
      'main'   => $load->timeline (),
    ))))) return $this->error ($title . '失敗！');

    array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_TIMELINE), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => date ('c')));
  }
  public function licenseHtml ($title) {
    $ptitle = '授權聲明';
    $d = MAIN_DESCRIPTION;

    if (!(($load = new Load ($this->apis)) && myWriteFile (PAGE_PATH_LICENSE, $load->frame (array (
      'title'  => $load->title ($ptitle),
      'meta'   => $load->meta (
          array ('_k' => 'nk',  'name' => 'keywords',           'content' => $ptitle . ', ' . MAIN_KEYWORDS),
          array ('_k' => 'pou', 'property' => 'og:url',         'content' => PAGE_URL_LICENSE),
          array ('_k' => 'poi', 'property' => 'og:title',       'content' => $ptitle . ' - ' . MAIN_TITLE),
          array ('_k' => 'nd',  'name' => 'description',        'content' => strCat ($d, 150)),
          array ('_k' => 'pod', 'property' => 'og:description', 'content' => strCat ($d, 200, false))),
      'jsonLd' => $load->jsonLd (array ('@context' => 'http://schema.org', '@type' => 'Article', 'url' => PAGE_URL_LICENSE, 'mainEntityOfPage' => array ('@type' => 'WebPage', '@id' => PAGE_URL_LICENSE), 'headline' => $ptitle, 'image' => array ('@type' => 'ImageObject', 'url' => MAIN_OG_URL, 'height' => 630, 'width' => 1200), 'datePublished' => date ('c'), 'dateModified' => date ('c'), 'author' => array ('@type' => 'Person', 'name' => OA_NAME, 'url' => PAGE_URL_INDEX, 'image' => array ('@type' => 'ImageObject', 'url' => avatarUrl (OA_FB_UID))), 'publisher' => array ('@type' => 'Organization', 'name' => MAIN_TITLE, 'logo' => array ('@type' => 'ImageObject', 'url' => URL_IMG_LOGO_AMP, 'width' => 600, 'height' => 60)), 'description' => strCat ($d, 150))),
      'link'   => $load->link (array ('_k' => 'rc', 'rel' => 'canonical', 'href' => PAGE_URL_LICENSE), array ('_k' => 'ra', 'rel' => 'alternate', 'href' => PAGE_URL_LICENSE, 'hreflang' => 'zh-Hant')),
      'scopes' => $load->scope (array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE), array ('href' => PAGE_URL_LICENSE, 'title' => $ptitle)),
      'css'    => $load->css (),
      'js'     => $load->js (),
      'header' => $load->_header (),
      'info'   => $load->_info (),
      'menu'   => $load->_menu (array ('now' => 'license')),
      'main'   => $load->license (),
    ))))) return $this->error ($title . '失敗！');

    array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', PAGE_URL_LICENSE), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => date ('c')));
  }
  public function cakeresumeHtml ($title) {
    if (!(($load = new Load ($this->apis)) && myWriteFile (PAGE_PATH_CAKERESUME, $load->cakeresume ())))
      return $this->error ($title . '失敗！');
  }
  public function listHtml ($ptitle, $url, $path, $apiKey, $desc = MAIN_DESCRIPTION) {
    $limit = $apiKey !== 'albums' ? 10 : 12;
    $title = '產生 ' . $ptitle . ' 檔案';
    $back_urls = array ();

    $items = $this->apis[$apiKey];
    $load = new Load ($this->apis);
    
    $methods = $apiKey !== 'albums' ? 'articles' : 'albums';
    $method = $apiKey !== 'albums' ? 'article' : 'album';

    if ($total = count ($items)) {
      for ($offset = 0; $offset < $total; $offset += $limit) {
        $i = 0; $as = array_slice ($items, $offset, $limit); $html = (!$offset ? 'index' : $offset) . HTML;

        foreach ($as as $a)
          if (!isset ($back_urls[$a['id']]))
            $back_urls[$a['id']] = $url . $html;

        if (!myWriteFile ($path . $html, $load->frame (array (
            'title'  => $load->title ($ptitle),
            'meta'   => $load->meta (
              array ('_k' => 'nk',  'name' => 'keywords',           'content' => $ptitle . ', ' . MAIN_KEYWORDS),
              array ('_k' => 'nd',  'name' => 'description',        'content' => strCat ($desc, 150)),
              array ('_k' => 'pou', 'property' => 'og:url',         'content' => $url . $html),
              array ('_k' => 'poi', 'property' => 'og:title',       'content' => $ptitle . ' - ' . MAIN_TITLE),
              array ('_k' => 'pod', 'property' => 'og:description', 'content' => strCat ($desc, 200, false))),
            'jsonLd' => $load->jsonLd (array (
              '@context' => 'http://schema.org', '@type' => 'ItemList',
              'itemListElement' => array_map (function ($item) use ($offset, &$i) {
                return array_merge (array (
                  '@type' => 'Article',
                  'position' => $offset + ++$i,
                  'url' => $item['_url']), $item['_jsonLd']); }, $as))),
            'link' => $load->link (
              array ('_k' => 'rc', 'rel' => 'canonical', 'href' => $url . $html),
              array ('_k' => 'ra', 'rel' => 'alternate', 'href' => $url . $html, 'hreflang' => 'zh-Hant')),
            'scopes' => $load->scope (
              array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE),
              array ('href' => $url . $html, 'title' => $ptitle)),
            'css'    => $load->css (),
            'js'     => $load->js (),
            'header' => $load->_header (),
            'info'   => $load->_info (),
            'menu'   => $load->_menu (array ('now' => $apiKey)),
            'main'   => $load->$methods (array (
              'objs' => $as,
              'pagination' => Pagination::initialize (array ('offset' => $offset, 'base_url' => $url, 'total_rows' => $total, 'per_page' => $limit))->create_links ())),
          )))) return $this->error ($title . '失敗！');

        array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $url . $html), 'priority' => '0.3', 'changefreq' => 'daily', 'lastmod' => date ('c')));
      }
    } else {
      $html = 'index' . HTML;

      if (!myWriteFile ($path . $html, $load->frame (array (
          'title'  => $load->title ($ptitle),
          'meta'   => $load->meta (
            array ('_k' => 'nk',  'name' => 'keywords',           'content' => $ptitle . ', ' . MAIN_KEYWORDS),
            array ('_k' => 'nd',  'name' => 'description',        'content' => strCat ($desc, 150)),
            array ('_k' => 'pou', 'property' => 'og:url',         'content' => $url . $html),
            array ('_k' => 'poi', 'property' => 'og:title',       'content' => $ptitle . ' - ' . MAIN_TITLE),
            array ('_k' => 'pod', 'property' => 'og:description', 'content' => strCat ($desc, 200, false))),
          'link' => $load->link (
            array ('_k' => 'rc', 'rel' => 'canonical', 'href' => $url . $html),
            array ('_k' => 'ra', 'rel' => 'alternate', 'href' => $url . $html, 'hreflang' => 'zh-Hant')),
          'scopes' => $load->scope (
            array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE),
            array ('href' => $url . $html, 'title' => $ptitle)),
          'css'    => $load->css (),
          'js'     => $load->js (),
          'header' => $load->_header (),
          'info'   => $load->_info (),
          'menu'   => $load->_menu (array ('now' => $apiKey)),
          'main'   => $load->$methods (array (
            'objs' => array (),
            'pagination' => '')),
        )))) return $this->error ($title . '失敗！');

      array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $url . $html), 'priority' => '0.3', 'changefreq' => 'daily', 'lastmod' => date ('c')));
    }

    foreach ($items as $item) {
      $back_url = isset ($back_urls[$item['id']]) ? $back_urls[$item['id']] : ($url . 'index' . HTML);
      if ($others = array_values (array_filter ($items, function ($t) use ($item) { return $t['id'] != $item['id']; }))) {
        shuffle ($others);
        $others = count ($others) > 2 ? array_slice ($others, 0, 3) : array ();
      }
      $tags = columnArray ($item['tags'], 'name');
      array_push ($tags, isset ($item['tag']['title']) && $item['tag']['title'] ? $item['tag']['title'] : '');
      $tags = array_unique (array_filter ($tags));
      

      if (!myWriteFile ($item['_path'], $load->frame (array (
        'title'  => $load->title ($item['title']),
        'meta'   => $load->meta (
          array ('_k' => 'nk',    'name' => 'keywords',                   'content' => implode (', ', $tags) . ', ' . MAIN_KEYWORDS),
          array ('_k' => 'nd',    'name' => 'description',                'content' => strCat ($d = $item['content'], 150)),
          array ('_k' => 'pou',   'property' => 'og:url',                 'content' => $item['_url']),
          array ('_k' => 'poi',   'property' => 'og:title',               'content' => $item['title'] . ' - ' . MAIN_TITLE),
          array ('_k' => 'pod',   'property' => 'og:description',         'content' => strCat ($d, 200, false)),
          array ('_k' => 'pam',   'property' => 'article:modified_time',  'content' => datetime2Format ($item['updated_at'])),
          array ('_k' => 'papt',  'property' => 'article:published_time', 'content' => datetime2Format ($item['created_at'])),
          array ('_k' => 'poil',  'property' => 'og:image',               'content' => $item['cover']['c1200x630'],             'tag' => 'larger', 'alt' => $item['title'] . ' - ' . MAIN_TITLE),
          array ('_k' => 'poitl', 'property' => 'og:image:type',          'content' => typeOfImg ($item['cover']['c1200x630']), 'tag' => 'larger')),
        'jsonLd' => $load->jsonLd (array_merge (array (
          '@context' => 'http://schema.org',
          '@type' => 'Article',
          'url' => $item['_url']), $item['_jsonLd'])),
        'link' => $load->link (
          array ('_k' => 'rc', 'rel' => 'canonical', 'href' => $item['_url']),
          array ('_k' => 'ra', 'rel' => 'alternate', 'href' => $item['_url'], 'hreflang' => 'zh-Hant')),
        'scopes' => $load->scope (
          array ('href' => PAGE_URL_INDEX, 'title' => MAIN_TITLE),
          array ('href' => $back_url, 'title' => $ptitle),
          array ('href' => $item['_url'], 'title' => $item['title'])),
        'css'    => $load->css (),
        'js'     => $load->js (),
        'header' => $load->_header (array ('val' => $item['title'], 'back_url' => $back_url)),
        'info'   => $load->_info (),
        'menu'   => $apiKey !== 'albums' ? $load->_menu (array ('now' => $apiKey)) : $load->album_info (array ('item' => $item)),
        'main'   => $load->$method (array (
          'others' => $others,
          'item' => $item)),
      )))) return $this->error ($title . '失敗！');

      array_push ($this->sitemapInfos, array ('uri' => '/' . str_replace (URL, '', $item['_url']), 'priority' => '0.7', 'changefreq' => 'daily', 'lastmod' => datetime2Format ($item['updated_at'])));
    }
  }
  public function sitemap ($title) {
    $sitmap = new Sitemap ($domain = rtrim (URL, '/'));
    $sitmap->setPath (PATH_SITEMAP);
    $sitmap->setDomain ($domain);

    foreach ($this->sitemapInfos as $sitemapInfo)
      $sitmap->addItem ($sitemapInfo['uri'], $sitemapInfo['priority'], $sitemapInfo['changefreq'], $sitemapInfo['lastmod']);

    $sitmap->createSitemapIndex ($domain . '/sitemap/', date ('c'));
  }
}