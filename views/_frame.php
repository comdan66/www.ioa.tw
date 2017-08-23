<!DOCTYPE html>
<html lang="tw">
  <head>
    <?php echo isset ($meta) && $meta ? $meta : '';?>
    <?php echo isset ($title) && $title ? $title : '';?>
    <?php echo isset ($link) && $link ? $link : '';?>
    <?php echo isset ($css) && $css ? $css : '';?>
    <?php echo isset ($js) && $js ? $js : '';?>
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
