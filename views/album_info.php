<article id="i" class="p ar" data-id='<?php echo $item['id'];?>' data-orm='Article'>
  <figure class="_ic" data-cnt="10">
    <img alt="<?php echo $item['title'];?> - <?php echo MAIN_TITLE;?>" src="<?php echo $item['cover']['c630x315'];?>" />
  </figure>

  <header>
    <h1><?php echo $item['title'];?></h1>
    <span><?php echo $item['bio'];?></span>
  </header>

  <div>
    <time data-time='<?php echo datetime2Format ($item['date_at'], 'Y.m.d');?>' datetime='<?php echo $item['date_at'];?>'><?php echo datetime2Format ($item['date_at'], 'Y-m-d');?></time>
    <span><div class="fb-like" data-href="<?php echo $item['_url'];?>" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></span>
  </div>

  <section class="s"><?php echo $item['content'];?></section>
</article>