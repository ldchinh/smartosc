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
global $base_url;
global $language_url;
$current_lag = $language_url->language;
//$show_work = $current_lag == "ja" ? '実績一覧を表示' : t('Show all our work');
?>
<?php if ($content): ?>
  <div class="<?php print $classes; ?>">
    <div class="bt-menu">
      <div class="nav-toggle">
        <span class="text-menu"><?php print t('Menu'); ?></span>
        <div class="icon inline-middle">
          <span class="two-line"></span>
          <span class="one-line"></span>
          <span class="two-line"></span>
        </div>
      </div>
    </div>
    <?php print $content; ?>
  </div>
<?php else: ?>
  <div class="<?php print $classes; ?>">
    <div class="bt-menu">
      <div class="nav-toggle">
        <span class="text-menu"><?php print t('Menu'); ?></span>
        <div class="icon inline-middle">
          <span class="two-line"></span>
          <span class="one-line"></span>
          <span class="two-line"></span>
        </div>
      </div>
    </div>
    <div class="lang-dropdown">
      <div class="active">
        <?php if($current_lag == "ja"): ?>
          <a><?php print t('日本語'); ?></a>
          <a class="mobile"><?php print t('日本語'); ?></a>
        <?php else: ?>
          <a><?php print t('English'); ?></a>
          <a class="mobile"><?php print t('En'); ?></a>
        <?php endif; ?>
        <span class="arrow"></span>
      </div>
      <ul class="list-unstyled">
        <li class="move">
          <?php if($current_lag != "ja"): ?>
            <a href="<?php print $base_url . '/ja'; ?>"><?php print t('日本語'); ?></a>
          <?php else: ?>
            <a href="<?php print $base_url . '/en'; ?>"><?php print t('English'); ?></a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
<?php endif; ?>