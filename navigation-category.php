<?php 
$pre = previous_posts_link('1');
$next = next_posts_link('1');
if (isset($pre, $next)) { ?>
  <div class="navigation">
    <div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
    <div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
    <div class="clearfloatthick">&nbsp;</div>
  </div>
<?php } ?>
