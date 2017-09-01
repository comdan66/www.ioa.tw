<main id="main" class='pvid' data-id='<?php echo $license['id'];?>' data-orm='Article'>
  <div>
    
    <article class="p p580 ar">
      <header style="margin-bottom: 8px;">
        <h1><?php echo $license['title'];?></h1>
        <span style="font-size: 11px;color: rgba(145, 145, 145, 1);"><?php echo $license['bio'];?></span>
      </header>

      <section class="s"><?php echo $license['content'];?></section>
      <time title="最後編輯日期"><?php echo datetime2Format ($license['updated_at'], 'Y.m.d');?></time>
    </article>

  </div>
</main>