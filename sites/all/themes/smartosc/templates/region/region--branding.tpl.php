<?php

/**
 * @file
 * Default theme implementation to display a region.
 *
 * Available variables:
 * - $content: The content for this region, typically blocks.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - region: The current template type, i.e., "theming hook".
 *   - region-[name]: The name of the region with underscores replaced with
 *     dashes. For example, the page_top region would have a region-page-top class.
 * - $region: The name of the region variable as defined in the theme's .info file.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 *
 * @see template_preprocess()
 * @see template_preprocess_region()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<?php if($banner_article && isset($banner_default)): ?>
  <div class="banner-content" style="background-image: url(<?php print $banner_default; ?>)">
    <div class="container align-center">
      <div class="banner-inner">
          <div class="align-center description-title">
            <div class="col-md-10 col-md-offset-1">
              <?php print $banner_description; ?>
            </div>
          </div>
      </div>
    </div>
  </div>
<?php elseif($banner_article && isset($banner_image)): ?>
  <div class="banner-content" style="background-image: url(<?php print $banner_image; ?>)">
    <div class="container align-center">
      <div class="banner-inner">
          <div class="align-center description-title">
            <div class="col-md-10 col-md-offset-1">
              <h1 class="title"><?php print $title_node; ?></h1>
              <p><?php print $author_name; ?></p>
              <p><?php print t('Written on ').$created_date; ?></p>
            </div>
          </div>
      </div>
    </div>
  </div>
<?php elseif($banner_careers_job): ?>
  <div class="banner-content commont-banner" style="background-image: url(<?php print $banner_image; ?>)">
      <div class="banner-inner">
          <div class="container align-center">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12 careers-detail-banner">
              <h1 class="title"><?php print $title_node; ?></h1>
              <?php if (isset($banner_location)): ?>
                <div class="offices"><i class="fa fa-map-marker" aria-hidden="true"></i><?php print $banner_location; ?></div>
              <?php endif; ?>
              <?php if (!empty($banner_description)): ?>
                <div class="introduction"><?php print $banner_description; ?></div>
              <?php endif; ?>
            </div>
          </div>
      </div>
    </div>
  </div>
<?php elseif($banner_case_study): ?>
  <?php if(isset($template_normal)): ?>
    <div class="banner-basic" style="background-image: url(<?php print $banner_image; ?>)">
      <div class="container align-center">
      </div>
    </div>
  <?php else: ?>
    <div class="banner-recent" style="background-image: url(<?php print $banner_image; ?>)">
      <div class="header_info">
        <div class="container">
          <div class="col-md-8 col-md-offset-2 align-content">
            <h1 class="title"><?php print $banner_title; ?></h1>
            <p class="subtitle"><?php print $banner_description; ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>

<?php if ($content): ?>
  <div class="<?php print $classes; ?>">
    <?php print $content; ?>
  </div>
<?php endif; ?>
