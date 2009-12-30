<?php //Using WordPress functions to retrieve the extracted EXIF information from database ?>
<div id="exif">
  <h3 class='comment-title exif-title'><?php _e('Images EXIF Data','mdr-theme-milly'); ?></h3>
  <div id="exif-data">
   <?php
      $imgmeta = wp_get_attachment_metadata( $id );

      // Convert the shutter speed retrieve from database to fraction
      if ((1 / $imgmeta['image_meta']['shutter_speed']) > 1)
      {
         if ((number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1)) == 1.3
         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.5
         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.6
         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 2.5){
            $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1, '.', '') ." ".__('second','mdr-theme-milly');
         }
         else{
           $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 0, '.', '') ." ".__('second','mdr-theme-milly');
         }
      }
      else{
         $pshutter = $imgmeta['image_meta']['shutter_speed'] ." ".__('seconds','mdr-theme-milly');
       }

       // Start to display EXIF and IPTC data of digital photograph
       echo "<p>" . date("d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp'])."</p>";
       echo "<p>" . $imgmeta['image_meta']['camera']."</p>";
       echo "<p>" . $imgmeta['image_meta']['focal_length']."mm</p>";
       echo "<p>f/" . $imgmeta['image_meta']['aperture']."</p>";
       echo "<p>" . $imgmeta['image_meta']['iso']."</p>";
       echo "<p>" . $pshutter . "</p>"
   ?>
</div>
<div id="exif-lable">
  <?php // EXIF Titles
  echo "<p><span>".__('Date Taken:','mdr-theme-milly')."</span>";
  echo "<p><span>".__('Camera:','mdr-theme-milly')."</span>";
  echo "<p><span>".__('Focal Length:','mdr-theme-milly')."</span>";
  echo "<p><span>".__('Aperture:','mdr-theme-milly')."</span>";
  echo "<p><span>".__('ISO:','mdr-theme-milly')."</span>";
  echo "<p><span>".__('Shutter Speed:','mdr-theme-milly')."</span>"; ?>
</div>

