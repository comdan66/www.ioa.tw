<div id="menu">
  <header>
    <div>iOA.tw</div>
    <div>OA Wu 個人作品</div>
  </header>

  <a href="<?php echo PAGE_URL_INDEX;?>" class="icon-h<?php echo isset ($now) && $now == 'index' ? ' a': '';?>">網站首頁</a>
  <a href="<?php echo PAGE_URL_DEVS;?>" class="icon-t<?php echo isset ($now) && $now == 'devs' ? ' a': '';?>" data-cnt="<?php echo number_format (count ($devs));?>">開發心得</a>
  <?php
  if ($blogs) { ?>
    <a href="<?php echo PAGE_URL_BLOGS;?>" class="icon-b<?php echo isset ($now) && $now == 'blogs' ? ' a': '';?>" data-cnt="<?php echo number_format (count ($blogs));?>">生活紀錄</a>
<?php
  } ?>
  <a href="<?php echo PAGE_URL_UNBOXINGS;?>" class="icon-g<?php echo isset ($now) && $now == 'unboxings' ? ' a': '';?>" data-cnt="<?php echo number_format (count ($unboxings));?>">開箱文章</a>
  <a href="<?php echo PAGE_URL_ALBUMS;?>" class="icon-i<?php echo isset ($now) && $now == 'albums' ? ' a': '';?>" data-cnt="<?php echo number_format (count ($albums));?>">個人相簿</a>
  <a href="<?php echo PAGE_URL_TIMELINE;?>" class="icon-v<?php echo isset ($now) && $now == 'timeline' ? ' a': '';?>">成就紀錄</a>

  <footer id="footer">
    <a href="<?php echo PAGE_URL_LICENSE;?>">服務條款 - 授權聲明</a>
    <span>©2014 - <?php echo date ('Y');?> www.ioa.tw</span>
  </footer>
</div><label for="menu_ckb" class="_bc"></label>


