<?php 
//$user = user_load($node->uid);
//$name_display = field_get_items('user', $user, 'field_name_display');
//$author =  !empty($name_display) ? $name_display[0]['value'] : $user->name;
//$date = date('d F Y', $node->created);
//$screen_news = field_get_items('node', $node, 'field_category');
//$tax_name = $screen_news[0]['taxonomy_term']->name;

$normal = true;
$content_special = "col-md-10 col-md-offset-1 col-xs-12";
if($content['field_category'][0]['#title'] == 'White Paper') {
  $normal = false;
  $content_special = "has-white-page";
}

?>
<div id="node-<?php print $node->nid; ?>" class="sh-blog item <?php print $classes; ?> <?php print $content_special; ?>"<?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <?php if (!$page): ?>
        <h2 class="blog-content-tile" <?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
     
    <div class="article-info">
      <?php print render($content['sharethis']);?>
    </div>   
        
    <div class="blog-content-tag">
      <div class="blog-content content"<?php print $content_attributes; ?>>
          <?php print render($content['body']);?>
          <?php
          // We hide the comments and links now so that we can render them later.
          hide($content['comments']);
          hide($content['links']);
          ?>
      </div>
      <?php if(isset($content['field_tags'])):?>
      <div class="blog-tags clearfix">
          <p class="tags-title"><i class="fa fa-tag"></i><?php print render($content['field_tags']['#title']); ?></p>
          <div class="list-tags">
            <?php //print render($content['field_tags']); ?>
            <?php foreach ($tags_link as $key => $value): ?>
              <?php print l($value['text'],$value['path']);?>
            <?php endforeach; ?>
          </div>
      </div>
      <?php endif; ?>
    </div>

    <?php if($normal): ?>
      <div class="author_info">
        <h3><?php print t("About the Author"); ?></h3>
        <div class="author-inner">
          <div class="author-image">
            <img src="<?php print image_style_url('thumbnail',$user_image); ?>" alt="author image">
          </div>
          <div class="author-detail">
            <h4><?php print render($user_name); ?></h4>
            <p><?php print render($author_info->field_information['und'][0]['value']); ?></p>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="picture-white-page">
        <?php print render($content['field_picture']); ?>
      </div>
      <div class="form-white-page">
        <h3><?php print t('Have any questions? Get in touch today.'); ?></h3>
        <?php print render($form_faqs_article); ?>
      </div>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
</div>

