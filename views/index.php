<main id="main" data-id='<?php echo $home['id'];?>' data-orm='Article'>
  <div>
    <figure class="b p580 _ic">
      <img alt="<?php echo MAIN_TITLE;?>" title="<?php echo MAIN_TITLE;?>" src="<?php echo $home['cover']['c1200x630'];?>" />
    </figure>

    <article id="u" class="p p580 ar">
      <figure class="r _ic">
        <img alt="<?php echo MAIN_TITLE;?>" title="<?php echo MAIN_TITLE;?>" src="<?php echo avatarUrl (OA_FB_UID);?>" />
      </figure>

      <header>
        <h1><?php echo $home['title'];?></h1>
        <span><?php echo $home['bio'];?></span>
      </header>

      <section class="s"><?php echo $home['content'];?></section>
      <time title="最後編輯日期"><?php echo datetime2Format ($home['updated_at'], 'Y.m.d');?></time>
    </article>

    <article class="p p580 ar">
      <section class="s">
        <header>接著請看</header>
        <div class="ot">
          <a href="<?php echo PAGE_URL_DEVS;?>">
            <i class="icon-t"></i>
            <b>開發心得</b>
            <span>前後端的實作心得，<br/>相關資訊技術研究筆記。</span>
          </a>
          <a href="<?php echo PAGE_URL_TIMELINE;?>">
            <i class="icon-v"></i>
            <b>成就紀錄</b>
            <span>個人里程碑，<br/>成就就是不斷的打破。</span>
          </a>
          <a href="<?php echo PAGE_URL_UNBOXINGS;?>">
            <i class="icon-g"></i>
            <b>開箱文章</b>
            <span>OA 的玩具開箱文，<br/>意外與驚喜的收納盒。</span>
          </a>
        </div>
      </section>
    </article>

  </div>
</main>