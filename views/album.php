<main id="main">
  <div id="b">
<?php foreach ($item['images'] as $image) { ?>
        <figure class="_ic" data-pvid="ArticleImage-<?php echo $image['id'];?>" data-ori="<?php echo $image['name']['w800'];?>">
          <img alt="<?php echo $image['title'] ? $item['title'] : MAIN_TITLE;?>" src="<?php echo $image['name']['w800'];?>" />
          <figcaption><?php echo $image['title'] ? $image['title'] : $item['title'];?></figcaption>
        </figure>
<?php }?>
  </div>
</main>