<?php

/**
 * @file
 * Theme the more link.
 *
 * - $view: The view object.
 * - $more_url: the url for the more link.
 * - $link_text: the text for the more link.
 *
 * @ingroup views_templates
 */
//page detail case-study
?>

<div class="more-link align-center">
  <a class="btn btn-line" href="<?php print $more_url ?>">
    <?php print $link_text; ?>
  </a>
</div>
