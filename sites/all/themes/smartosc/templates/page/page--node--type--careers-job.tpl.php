<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>

<div id="page-wrapper" <?php print $attributes; ?>>

  <?php if ($page['fixed_header']): ?>
    <div class="region-fixed-header">
      <?php print render($page['fixed_header']); ?>
    </div>
  <?php endif; ?>

  <div class="section section-header">
    <div class="region-logo col-xs-12 col-sm-3">
      <?php if ($logo): ?>
        <div class="site-logo">
          <a href="<?php print $front_page; ?>" title="<?php print t('SmartOSC'); ?>" rel="home" id="logo">
            <img src="<?php print $logo; ?>" alt="<?php print t('SmartOSC'); ?>" width="180" height="24" class="logo-default"/>
            <img src="<?php echo '/'.drupal_get_path('theme', 'smartosc') .'/logo-white.png'; ?>" alt="<?php print t('SmartOSC'); ?>" width="180" height="24" class="logo-white"/>
          </a>
        </div>
      <?php endif; ?>
    </div>
    <div class="region-menu col-xs-12 col-sm-9">
      <?php print render($page['header']); ?>
    </div>
  </div>

  <div class="main-wrapper-content clearfix">

    <?php if ($page['branding']): ?>
      <div class="section section-branding">
        <?php print render($page['branding']); ?>
      </div>
    <?php endif; ?>

    <div class="container"><?php print $messages; ?></div>

    <?php if ($page['highlighted']): ?>
      <div class="section section-highlights">
        <div class="container">
          <div class="row">
            <?php print render($page['highlighted']); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($page['content_top']): ?>
      <div class="section section-content-top">
        <?php print render($page['content_top']); ?>
      </div>
    <?php endif; ?>

    <div class="section section-content">
      <?php if ($breadcrumb): ?>
        <div id="breadcrumb">
          <div class="container">
            <div class="row">
              <?php print $breadcrumb; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <div class="container">
        <div class="row">
          <?php if ($page['sidebar_second']): ?>
          <div id="content" class="col-md-9">
            <a id="main-content"></a>
              <?php if ($tabs): ?>
            <div class="tabs-primary"><?php print render($tabs); ?></div><?php endif; ?>
              <?php print render($page['help']); ?>
              <?php if ($action_links): ?>
            <ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
              <?php print render($page['content']); ?>
          </div>
          <?php else: ?>
          <div id="content">
            <a id="main-content"></a>
              <?php if ($tabs): ?>
            <div class="tabs-primary"><?php print render($tabs); ?></div><?php endif; ?>
              <?php print render($page['help']); ?>
              <?php if ($action_links): ?>
            <ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
              <?php print render($page['content']); ?>
          </div>
          <?php endif; ?>
          <?php if ($page['sidebar_second']): ?>
            <div id="sidebar-second" class="col-md-3 sidebar">
              <?php print render($page['sidebar_second']); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php if ($page['content_bottom']): ?>
      <div class="section section-content-bottom">
        <?php print render($page['content_bottom']); ?>
      </div>
    <?php endif; ?>

    <?php if ($page['description']): ?>
      <div class="section section-description">
        <div class="container">
          <div class="row">
          <?php print render($page['description']); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($page['info']): ?>
      <div class="section section-info">
        <div class="container">
          <div class="row">
          <?php print render($page['info']); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($page['bottom']): ?>
      <div class="section section-bottom">
        <?php print render($page['bottom']); ?>
      </div>
    <?php endif; ?>
  </div>


  <div class="section section-fixed-bottom">
    <?php if ($page['footer']): ?>
      <div class="section section-footer">
        <div class="container">
          <div class="row">
            <?php print render($page['footer']); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <div class="section section-footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <?php print render($page['footer_first']); ?>
          </div>
          <div class="col-xs-12 col-sm-6">
            <?php print render($page['footer_second']); ?>
          </div>
          <div class="col-xs-12 col-sm-3">
            <?php print render($page['footer_third']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>