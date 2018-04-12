<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */

/* superhero_portfolio_image show follow lightbox2 */
//foreach ($content['field_picture']['#items'] as $id => $value{
//$content_image =  theme('image', array(
//  'path' => file_create_url($value['uri']),
//  'attributes' => array('class' => 'new-album-image')
//));
//$options = array(
//  'attributes' => array('rel' => 'lightbox[roadtrip]'),
//  'html' => TRUE,
//);
//$conten_href = l($content_image, file_create_url($value['uri']), $options);
//}
?>
<?php if ($content['field_layout_type']['#items'][0]['value'] == '2'): ?>
<div id="node-<?php print $node->nid; ?>" class="case-study-special <?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="introduction-scope">
    <div class="container info">
      <div class="case-introduction">
        <?php if (!empty($content['field_introduction'][0]['#markup']) &&$content['field_introduction']['#label_display'] != 'hidden'): ?>
          <h3 class="title"><?php print render($content['field_introduction']['#title']); ?></h3>
        <?php endif; ?>
        <div class="info-regular"><?php print render($content['field_introduction'][0]['#markup']); ?></div>
      </div>
      <div class="case-scope">
        <?php if (!empty($content['field_scope'][0]['#markup']) && $content['field_scope']['#label_display'] != 'hidden'): ?>
          <h3 class="title line"><?php print render($content['field_scope']['#title']); ?></h3>
        <?php endif; ?>
        <div class="info-regular"><?php print render($content['field_scope'][0]['#markup']); ?></div>
        <?php if(isset($content['field_scope_pic']['#items'][0]['uri'])): ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php if(isset($content['field_scope_pic'][0]['#item']['fid'])): ?>
    <div class="sope-pic">
      <div class="container align-center">
        <?php print render($content['field_scope_pic']); ?>
      </div>
    </div>
  <?php endif; ?>
  <div class="description-picture">
    <div class="container">
      <?php if(!empty($content['field_new_journey'][0]['#markup'])): ?>
        <div class="picture_info">
          <?php if(!isset($content['field_scope_pic'][0]['#item']['fid'])): ?>
            <?php if(isset($content['field_journey_picture']['#items'][0]['uri'])): ?>
              <div class="pic align-center"><?php print render($content['field_journey_picture']); ?></div>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($content['field_new_journey']['#label_display'] != 'hidden'): ?>
            <h3 class="title"><?php print render($content['field_new_journey']['#title']); ?></h3>
          <?php endif; ?>
          <div class="info-regular"><?php print render($content['field_new_journey'][0]['#markup']); ?></div>


          <?php if(isset($content['field_scope_pic'][0]['#item']['fid'])): ?>
            <?php if(isset($content['field_journey_picture']['#items'][0]['uri'])): ?>
              <div class="pic align-center"><?php print render($content['field_journey_picture']); ?></div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php if(!empty($content['field_challenge'][0]['#markup'])): ?>
        <div class="picture_info right">
          <?php if(!isset($content['field_scope_pic'][0]['#item']['fid'])): ?>
            <?php if(isset($content['field_challenge_picture'][0]['#item']['uri'])): ?>
              <div class="pic align-center"><?php print render($content['field_challenge_picture']); ?></div>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($content['field_challenge']['#label_display'] != 'hidden'): ?>
            <h3 class="title"><?php print render($content['field_challenge']['#title']); ?></h3>
          <?php endif; ?>
          <div class="info-regular"><?php print render($content['field_challenge'][0]['#markup']); ?></div>

          <?php if(isset($content['field_scope_pic'][0]['#item']['fid'])): ?>
            <?php if(isset($content['field_challenge_picture'][0]['#item']['uri'])): ?>
              <div class="pic align-center"><?php print render($content['field_challenge_picture']); ?></div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="our-solutions">
    <div class="container">
      <div class="row">
        <?php if(!empty($content['field_case_study_our_solutions']['#items'])): ?>
          <?php if ($content['field_case_study_our_solutions']['#label_display'] != 'hidden'): ?>
            <h3 class="large-title line"><?php print render($content['field_case_study_our_solutions']['#title']); ?></h3>
            <?php print render($content['field_case_study_our_solutions']); ?>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php if(isset($content['field_title_results'][0]['#markup'])): ?>
  <div class="case-results">
    <div class="container">
      <h3 class="large-title line"><?php print render($content['field_title_results'][0]['#markup']); ?></h3>
      <?php if(isset($content['field_info_results'][0]['#markup'])): ?>
        <div class="info-results"><?php print render($content['field_info_results'][0]['#markup']); ?></div>
      <?php endif; ?>
      <?php if(!empty($content['field_case_study_element_result']['#items'])): ?>
        <?php print render($content['field_case_study_element_result']); ?>
      <?php endif; ?>
      <?php if(!empty($content['field_case_study_fun_facts']['#items'])): ?>
          <?php print render($content['field_case_study_fun_facts']); ?>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
  <?php if(!empty($content['field_going_forward'][0]['#markup'])): ?>
    <div class="going_forward">
      <div class="container">
        <div class="row">
          <?php if (!empty($content['field_going_forward'][0]['#markup']) && $content['field_going_forward']['#label_display'] != 'hidden'): ?>
            <h3 class="large-title line"><?php print render($content['field_going_forward']['#title']); ?></h3>
          <?php endif; ?>
          <div class="info-regular col-sm-8 col-sm-offset-2"><?php print render($content['field_going_forward'][0]['#markup']); ?></div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php if(isset($content['field_forward_pic'])): ?>
    <div class="pic_forward">
      <?php print render($content['field_forward_pic']); ?>
    </div>
  <?php endif; ?>
</div>
<?php else: ?>
  <div id="node-<?php print $node->nid; ?>" class="case-study-normal <?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="container">
      <div class="info-header">
        <h1 class="title"><?php print $title; ?></h1>
        <p class="subtitle"><?php print render($content['field_subtitle'][0]['#markup']); ?></p>
      </div>
      <div class="row">
        <?php if(isset($content['field_case_study_information']['#items']) && !empty($content['field_case_study_information']['#items'])): ?>
            <?php print render($content['field_case_study_information']); ?>
        <?php endif; ?>
      </div>

      <div class="row">
        <?php
          $view_block = module_invoke('views','block_view','so_case_study-case_study_other');
          print render($view_block['content']);
        ?>
      </div>
    </div>
  </div>

<?php endif; ?>
