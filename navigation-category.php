<?php
$next = next_posts_link('1');
$previous = previous_posts_link('1');
if ($next == 1) {
  $nav = '1';
}

if ($previous == 1) {
  $nav = '1';
}
if ($nav == '1') { ?>
  <div class="navigation">
    <div class="txtalignleft"><?php previous_posts_link('&laquo; Newer Entries'); ?></div>
    <div class="txtalignright"><?php next_posts_link('Older Entries &raquo;') ?></div>
    <div class="clearfloatthick">&nbsp;</div>
  </div>
<?php } ?>
