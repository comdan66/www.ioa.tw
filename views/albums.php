<main id="main">
  <div id="a">
<?php foreach ($objs as $obj) { ?>
        <a href="<?php echo $obj['_url'];?>">
          <figure class='_ic' data-cnt='<?php echo number_format ($obj['pv']);?>'>
            <img alt="<?php echo $obj['title'];?> - <?php echo MAIN_TITLE;?>" src="<?php echo $obj['cover']['c630x315'];?>" />
            <figcaption><?php echo $obj['title'];?></figcaption>
          </figure>
          <div><?php echo $obj['title'];?></div>
          <span>共有 <?php echo number_format (count ($obj['images']));?> 張照片</span>
        </a>
<?php }?>
    <div class="g"><?php echo $pagination;?></div>
  </div>
</main>