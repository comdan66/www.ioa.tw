<main id="main">
  <div>

    <div class="p p580 l<?php echo $objs ? '' : ' e';?>">
<?php foreach ($objs as $obj) { ?>
        <a href="<?php echo $obj['_url'];?>">
          <figure class="_ic">
            <img alt="<?php echo $obj['title'];?> - <?php echo MAIN_TITLE;?>" src="<?php echo $obj['icon']['c300x300'];?>" />
            <figcaption><?php echo $obj['title'];?><figcaption>
          </figure>
          <b<?php echo $obj['tag'] ? ' data-tip="' . $obj['tag'] . '"' : '';?>><?php echo $obj['title'];?></b>
          <span><?php echo strCat ($obj['content'], 100);?></span>
        </a>
<?php }?>
    </div>

    <div class="g p580"><?php echo $pagination;?></div>
  </div>
</main>