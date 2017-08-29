<header id="header">
  <div>
<?php if (isset ($back_url) && $back_url) { ?>
        <a class="icon-l2" href="<?php echo $back_url;?>"></a>
<?php } else { ?>
        <label class="icon-m" for="menu_ckb"></label>
<?php } ?>

    <a href='<?php echo PAGE_URL_INDEX;?>'>
      <b>OA's</b>
      <span>生活部落格</span>
      <i>Blog、Album</i>
    </a>

    <form method="get" action="<?php echo PAGE_URL_SEARCH;?>">
      <input type="text" id="q" name="q" placeholder="搜尋 OA Wu.." value="<?php echo isset ($val) && $val ? $val : '';?>" pattern='.{1,}' required title='搜尋 OA Wu 的相關資訊!' />
      <button type="submit" class="icon-s"></button>
    </form>

    <label for="info_ckb" class="_ic">
      <img src="<?php echo avatarUrl (OA_FB_UID);?>" />
    </label>
  </div>
</header>