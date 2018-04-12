<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($view->result as $key =>$row): ?>
<?php 
$image_path = $row->field_field_picture[0]['raw']['uri'];
$title_image =  theme('image', array('path' => file_create_url($image_path), 'attributes' => array('class' => 'port-album-image')));
$title = $row->node_title;
$title_job = $row->field_field_subtitle[0]['raw']['value'];
$desc = strip_tags($row->field_body[0]['raw']['value']);
?>
<div <?php if ($classes_array[$key]) { print ' class="' . $classes_array[$key] .' grid-item"';  } else {  print ' class="grid-item"'; } ?>>
      <div class="grid-masory-item">
        <?php print $title_image;?>
        <div class="content-effect-wrap">
          <div class="content-effect-wrap-item">
            <div class="content-effect-desc-warp">
              <div class="side-inner">
                <div class="content-effect-title">
                  <a><?php echo $title;?></a>
                  <p class="title-job"><?php echo $title_job;?></p>
                  <p class="des"><?php echo $desc;?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<?php endforeach;?>
<div class="views-row grid-item">
    <div class="grid-masory-item">
      <div class="this-could-be-you">
        <?php
        $vars = array(
          'path' => '/sites/all/themes/smartosc/images/about/passion-12.jpg',
          'alt' => 'career opportunities',
          'attributes' => array('class' => 'last-img'),
        );
        $image = theme_image($vars);
        print l($image,'careers', array('html'=>true, 'attributes' => array('alt'=>'this-could-be-you', 'title'=>t('this could be you'), 'width'=>'240', 'height'=>'183')))
        ?>
      </div>
    </div>
</div>
