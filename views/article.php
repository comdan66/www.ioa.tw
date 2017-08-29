<main id="main">
  <div>
    <figure class="b p580 _ic">
      <img alt='<?php echo $item['title'];?> - <?php echo MAIN_TITLE;?>' src="<?php echo $item['cover']['c1200x630'];?>" />
    </figure>

    <article class="p p580 ar">
      <header>
        <h1><?php echo $item['title'];?></h1>
        <span><?php echo $item['bio'];?></span>
      </header>

      <div>
        <time><?php echo datetime2Format ($item['date_at'], 'Y.m.d');?></time>
        <span><div class="fb-like" data-href="<?php echo $item['_url'];?>" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></span>
      </div>

      <section class="s"><?php echo $item['content'];?></section>
    </article>

<?php if ($item['sources']) { ?>
        <article class='p p580 ar'>
          <section class='s'>
            <header>相關參考</header>
            <ul>
        <?php foreach ($item['sources'] as $source) {
                if ($source['title'] && $source['href']) { ?>
                  <li><a href="<?php echo $source['href'];?>"><?php echo $source['title'];?></a><a href="<?php echo $source['href'];?>"><?php echo $source['href'];?></a></li>
          <?php } else if ($source['title']) { ?>
                  <li><?php echo $source['title'];?></li>
          <?php } else if ($source['href']) { ?>
                  <li><a href="<?php echo $source['href'];?>"><?php echo $source['href'];?></a><a href="<?php echo $source['href'];?>"><?php echo $source['href'];?></a></li>
          <?php }
              } ?>
            </ul>
          </section>
        </article>
<?php }
      if ($others) { ?>
        <article class="p p580 ar">
          <section class="s">
            <header>推薦文章</header>
            <div class="ot">
        <?php foreach ($others as $other) { ?>
                <a href="<?php echo $other['_url'];?>">
                  <figure class="_ic">
                    <img alt="<?php echo $other['title'];?> - <?php echo MAIN_TITLE;?>" src="<?php echo $other['cover']['c630x315'];?>" />
                    <figcaption><?php echo $other['title'];?><figcaption>
                  </figure>
                  <b><?php echo $other['title'];?></b>
                  <span><?php echo strCat ($other['title'], 100);?></span>
                </a>
        <?php } ?>
            </div>
          </section>
        </article>
<?php }?>

    <article class="p p580 ar">
      <section class="f">
        <div class="fb-comments" data-order-by="reverse_time" width="100%" data-href="<?php echo $item['_url'];?>" data-numposts="5">
      </section>
    </article>

  </div>
</main>