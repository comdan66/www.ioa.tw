<!DOCTYPE html>
<html lang="tw">
  <head>
    <?php echo isset ($meta) ? implode (DEV ? "\n" : '', $meta) : '';?>
    <title><?php echo (isset ($title) && $title ? $title . ' - ' : '') . MAIN_TITLE;?></title>
    <?php echo isset ($link) ? implode (DEV ? "\n" : '', $link) : '';?>
    <?php echo isset ($css) ? implode (DEV ? "\n" : '', $css) : '';?>
    <?php echo isset ($js) ? implode (DEV ? "\n" : '', $js) : '';?>
    <?php echo isset ($jsonLd) ? $jsonLd : '';?>
  </head>
  <body lang="zh-tw">
    <input type="checkbox" id="menu_ckb" class="_ckbh">
    <input type="checkbox" id="info_ckb" class="_ckbh">
<?php echo isset ($header) && $header ? $header : '';?>
<?php echo isset ($menu) && $menu ? $menu : '';?>
<?php echo isset ($info) && $info ? $info : '';?>
<?php echo isset ($main) && $main ? $main : '';?>
<?php echo isset ($scopes) && $scopes ? $scopes : '';?>
  </body>
</html>
