<?php
/**
 * Custom Galeria Template settings
 */
function smartosc_css_alter(&$css) {
  // Remove css Module Drupal
  unset($css[drupal_get_path('module', 'views') . '/css/views.css']);
  // Remove css drupal
  $exclude = array(
    'misc/vertical-tabs.css' => FALSE,
    'modules/aggregator/aggregator.css' => FALSE,
    'modules/block/block.css' => FALSE,
    'modules/book/book.css' => FALSE,
    'modules/comment/comment.css' => FALSE,
    'modules/dblog/dblog.css' => FALSE,
    'modules/file/file.css' => FALSE,
    'modules/filter/filter.css' => FALSE,
    'modules/forum/forum.css' => FALSE,
    'modules/help/help.css' => FALSE,
    'modules/menu/menu.css' => FALSE,
    'modules/node/node.css' => FALSE,
    'modules/openid/openid.css' => FALSE,
    'modules/poll/poll.css' => FALSE,
    'modules/profile/profile.css' => FALSE,
    'modules/search/search.css' => FALSE,
    'modules/statistics/statistics.css' => FALSE,
    'modules/syslog/syslog.css' => FALSE,
    'modules/system/admin.css' => FALSE,
    'modules/system/maintenance.css' => FALSE,
    'modules/system/system.css' => FALSE,
    'modules/system/system.admin.css' => FALSE,
    //'modules/system/system.base.css' => FALSE,
    'modules/system/system.maintenance.css' => FALSE,
    'modules/system/system.theme.css' => FALSE,
    'modules/system/system.menus.css' => FALSE,
    'modules/system/system.messages.css' => FALSE,
    'modules/taxonomy/taxonomy.css' => FALSE,
    'modules/tracker/tracker.css' => FALSE,
    'modules/update/update.css' => FALSE,
    'modules/user/user.css' => FALSE,
  );
  $css = array_diff_key($css, $exclude);

}
function smartosc_js_alter(&$js) {
  // Remove js view infinite scroll
  unset($js[drupal_get_path('module', 'views_infinite_scroll') . '/views-infinite-scroll.js']);
}
function smartosc_menu_local_tasks(&$variables) {
  $output = '';
  if (!empty($variables ['primary'])) {
    $variables ['primary']['#prefix'] = '<ul class="tabs tab_primary">';
    $variables ['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables ['primary']);
  }
  if (!empty($variables ['secondary'])) {
    $variables ['secondary']['#prefix'] = '<ul class="tabs tab_secondary">';
    $variables ['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables ['secondary']);
  }
  return $output;
}
function smartosc_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data'  => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data'  => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data'  => '<a>…</a>',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            //'class' => array('pager-item'),
            'data'  => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('active'),
            'data'  => l($i, '#', array('fragment' => '','external' => TRUE)),
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            //'class' => array('pager-item'),
            'data'  => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data'  => '<a>…</a>',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }
    return '<div class="post-pagination">' . theme('item_list', array(
        'items' => $items,
        'attributes' => array('class' => array('pager')),
      )).'</div>';
  }
}
function smartosc_status_messages($variables) {
  $display = $variables['display'];
  $output = '';
  $status_heading = array(
    'status'  => t('Status message'),
    'error'   => t('Error message'),
    'warning' => t('Warning message'),
  );
  $status_class = array(
    'status'  => 'success',
    'error'   => 'danger',
    'warning' => 'warning',
  );

  /* Test Messages */
  //drupal_set_message(t("Don't panic!"), 'error');
  //drupal_set_message(t("Don't panic!"), 'status');
  //drupal_set_message(t("Don't panic!"), 'warning');

  foreach (drupal_get_messages($display) as $type => $messages) {
    $class = (isset($status_class[$type])) ? ' alert-' . $status_class[$type] : '';

    /* Alter Boostrap */
    //$output .= "<div class=\"alert fade in alert-block$class\">\n";
    //$output .= "  <a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>\n";
    //$output .= "<div class=\" raw \">\n";

    /* Alter Custom */
    $output .= '<div class="messages-content">';
    $output .= "<div class=\"alert align-left".$class."\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul class=\"list-unstyled\">\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }

    /* End alter Custom */
    $output .= "</div>\n";
    $output .= "</div>\n";

    /* End alter Boostrap */
    //$output .= "</div><!-- /raw -->\n";
    //$output .= "</div>\n";
  }

  return $output;
}

/* Remove http & https */
// function smartosc_process_html(&$vars){
//    // Remove http or https of header_html
//    foreach (array('head', 'styles', 'scripts') as $item) {
//      if (isset($vars[$item])) {
//        $vars[$item] = preg_replace('/(src|href|@import )(url\(|=)(")http(s?):/', '$1$2$3', $vars[$item]);
//      }
//    }
// }
/**
 * Changing markup of block language switcher
 */
function smartosc_links__locale_block(&$vars) {
  global $language;
  $lag = $language->language;
  $lang= $language->native;

  $items = array();
  if(isset($vars['links'])) {
    foreach ($vars['links'] as $key_lag => $info) {
      // display only translated links & don't show active link
      if (isset($info['href']) && $key_lag != $lag) {
        $name = $info['language']->native;
        $options = array('attributes' => array('class' => array('link-class')), 'language' => $info['language'], 'html' => true);
        $link = l($name, $info['href'], $options);
        $items[] = array('data' => $link, 'class' => array('move'));
      }
    }
  }

  // output
  $output = '<div class="lang-dropdown">';
  $output .='<div class="active">';
  $output .='<a>'.$lang.'</a>';

  if($lag == 'en')
    $output .='<a class="mobile">'.$lag.'</a>';
  else
    $output .='<a class="mobile">'.$lang.'</a>';

  $output .='<span class="arrow"></span>';
  $output .= '</div>';

  if(isset($vars['links'])) {
    $output .= theme_item_list(
      array(
        'items' => $items,
        'title' => '',
        'type' => 'ul',
        'attributes' => array('class' => array('list-unstyled'))
      ));
  }

  $output .= '</div>';
  return $output;
}
function smartosc_preprocess_html(&$vars) {
  global $base_url;

  drupal_add_css('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array('type' => 'external'));
  drupal_add_library('system', 'ui.core');
  drupal_add_library('system', 'ui.slider');

	// Enable Responsive
  $viewport = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1, maximum-scale=1',
    )
  );
  drupal_add_html_head($viewport, 'viewport');


  $node = menu_get_object('node');

  if(isset($node) && $node->type == 'case_study') {
    $path = drupal_get_path_alias();
    $aliases = explode('/', $path);
    $title_alias = end($aliases);

    $vars['classes_array'][] = 'page-case-study-'.drupal_clean_css_identifier($title_alias);
  }

  if(isset($node) && $node->type == 'article') {
    if(isset($node->field_banner['und'][0]['uri']) || (isset($node->field_default_banner['und'][0]['value']) && ($node->field_default_banner['und'][0]['value'] == "1"))){
      $vars['classes_array'][] = 'header-transparent';
    }
  }


  // Preloader
  $Picture_loading = $base_url.'/'.drupal_get_path('theme', 'smartosc').'/images/home/loader_pic.png';
  if (theme_get_setting('preloader_image')){
    $fid_preload_loading = theme_get_setting('preloader_image',null);
    $file = file_load($fid_preload_loading);
    if ($file) {
      $Picture_loading = file_create_url($file->uri);
    }
  }
  $picture = isset($Picture_loading) ? '<div class="loader-logo"><img src="'.$Picture_loading.'" alt=""/></div>' : '';

  $vars['preload'] = '';
  if (theme_get_setting('preload') == TRUE) {
    if (theme_get_setting('preloader_type') == 1) {
      $vars['preload'] = '<div class="page-loading"><div class="loader"></div><span class="text">'.t('Loading...').'</span></div>';
    } else if (theme_get_setting('preloader_type') == 2) {
      $vars['preload'] = '<div class="loader_page">
                              <div class="spinner">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                                <div class="rect6"></div>
                                <div class="rect7"></div>
                              </div>
                            </div>';
    } else if (theme_get_setting('preloader_type') == 3) {
      $vars['preload'] = "<div class='loader_page'><div class='preloader'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>";
    } else if (theme_get_setting('preloader_type') == 4) {
      $vars['preload'] = '<div id="loader-wrapper">
                              <div id="loader"></div>
                              ' . $picture . '
                              <div class="loader-section section-left"></div>
                              <div class="loader-section section-right"></div>
                          </div>';
    }
  }

	// Google analytics
	$google_tracking_id = theme_get_setting('google_tracking_id');
	if (!empty($google_tracking_id)) {
		$script = array(
			'#tag' => 'script',
			'#attributes' => array('type' => 'text/javascript'),
			'#value' => "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
                    
                    ga('create', '" . $google_tracking_id . "', 'auto');
                    ga('send', 'pageview');",
		);
		drupal_add_html_head($script, 'script');
	}

	// Facebook Remarketing
	$facebook_pixel_id = theme_get_setting('facebook_pixel_id');
	if (!empty($facebook_pixel_id)) {
		$face_script = array(
			'#tag' => 'script',
			'#attributes' => array('type' => 'text/javascript'),
			'#value' => "!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
											n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
											n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
											t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
											document,'script','//connect.facebook.net/en_US/fbevents.js');
											fbq('init', '".$facebook_pixel_id."');
											fbq('track', 'PageView');"
											);
		$noscript = array(
			'#theme' => 'html_tag',
			'#tag' => 'noscript',
			'#value' => '<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id="'.$facebook_pixel_id.'"&ev=PageView&noscript=1"/>',
		);
		drupal_add_html_head($noscript, 'noscript');
		drupal_add_html_head($face_script, 'script_facebook');
	}
}

/* Preprocess breadcrumb template */
//function smartosc_breadcrumb($variables) {
//	$breadcrumb = $variables ['breadcrumb'];
//	if (! empty ( $breadcrumb )) {
//		$output = '<div class="breadcrumb">' . implode ( '<span class="divider"></span>', $breadcrumb ) . '</div>';
//		return $output;
//	}
//}

/**
 * hook_preprocess_page
 */
function smartosc_preprocess_page(&$vars) {
  //$vars['attributes_array']['class'] = array('page-innerwrapper');

  // Redirect after goto link alias old
  $url = request_uri();
  if (strpos($url, "/news/") !== false) {
    $go_url = str_replace("/news/","/insights/",$url);
    drupal_add_http_header('Location', $go_url);
  }
  /* Change redirect 404 */
  //$page = $vars['page'];
  // $page_view = views_get_page_view();
  // if (!empty($page_view)) {
  //    $view_result = $page_view->result;
  //    if(empty($view_result)) {
  //      drupal_add_http_header('status', '404 Not Found');
  //    }
  // }

  /* Redirect link alias for taxonomy tags */
  // if($tax = menu_get_object('taxonomy_term', 2)) {
  //      drupal_goto(url('news/tag/'. $arg[2], array('absolute'=>true)));
  // }

	/* Render Region & section Banner For News Detail */
  if (isset($vars['node'])) {
    $node = $vars['node'];
    $node_type = $node->type;
    $vars['theme_hook_suggestions'][] = 'page__node__type__' . $node_type;

    if ($node_type == "article") {
      if (!isset($node->field_banner['und'][0]['uri'])) {
        $vars['no_banner'] = TRUE;
        // Date
        $vars['created_date'] = date('d F Y', $node->created);
        // Author
        $author = user_load($node->uid);
        $user_name = !empty($author->field_name_display) ? $author->field_name_display['und'][0]['value'] : $author->name;
        $vars['author_name'] = l($user_name, 'insights/user/' . $author->name);
      }
    } elseif ($node_type == 'case_study') {
      if(isset($node->field_layout_header['und'][0]['value']) && $node->field_layout_header['und'][0]['value'] == "1")
        $vars['attributes_array']['class'][] = 'page-not-gradien';
    } elseif ($node_type == 'html_page') {
        $vars['title'] = FALSE;
    }
  }

  // Theme-setting Not-found
  $vars['title_notfound'] = theme_get_setting('not_found_title') ? theme_get_setting('not_found_title') : t('Sorry, Page not found !');
  $vars['content_notfound'] = theme_get_setting('not_found_body') ? theme_get_setting('not_found_body')['value'] : '';
}

/**
 * hook_page_alter
 */
function smartosc_page_alter(&$page) {
  // Remove content default of front page
  if (drupal_is_front_page ()) {
    unset ( $page['content']['system_main']);
    unset ( $page['content']['#theme_wrappers']);
  }

  // All Region Header
  if(!isset($page['header']['#region'])) {
    $page['header']['#theme_wrappers'] = array('region');
    $page['header']['#region'] = 'header';
  }

  // Region Banner for Node Type
  $node = menu_get_object('node');
  if(isset($node)) {
    $have_banner = false;
    if ($node->type == "article") {
      if(isset($node->field_default_banner['und'][0]['value']) && $node->field_default_banner['und'][0]['value'] != "0")
        $have_banner = true;
    }
    if(isset($node->field_banner['und'][0]['uri']))
      $have_banner = true;

    if ($node->type == "article" && $have_banner || in_array($node->type,array('case_study','careers_job'))) {
      $page['branding']['#theme_wrappers'] = array('region');
      $page['branding']['#region'] = 'branding';
    }
    //elseif ($node->type == 'article') {
    //  /* Add class for body */
    //  $page['attributes_array']['class'][] = 'banner_news';
    //}
  }
}

/**
 * hook_preprocess_region
 */
function smartosc_preprocess_region(&$vars) {
	global $base_url;

	// Setting for Banner Header
  $node = menu_get_object('node');
	$vars['banner_article'] = FALSE;
  $vars['banner_case_study'] = FALSE;
  $vars['banner_careers_job'] = FALSE;

  if(isset($node)) {
    if ($node->type == "article") {
      $vars['banner_article'] = TRUE;
      //Picture
      $vars['title_node'] = $node->title;
      if (isset($node->field_banner['und'][0]['uri'])) {
        $vars['banner_image'] = image_style_url('banner_picture', $node->field_banner['und'][0]['uri']);
      }
      // Default picture
      if (isset($node->field_default_banner['und'][0]['value']) && $node->field_default_banner['und'][0]['value'] !=0) {
        $pic_fid = theme_get_setting('news_default_image');
        $vars['banner_default'] = $base_url . '/' . drupal_get_path('theme', 'smartosc') . '/images/news/news_banner.png';
        if (!empty($pic_fid)) {
          $file = file_load($pic_fid);
          if ($file) {
            $vars['banner_default'] = image_style_url('banner_picture', $file->uri);
          }
        }
        $vars['banner_description'] = theme_get_setting('news_description') ? theme_get_setting('news_description') : t('<h2>Insights</h2>');
      }

      // Date
      $vars['created_date'] = date('d F Y', $node->created);
      // Author
      $author = user_load($node->uid);
      $user_name = !empty($author->field_name_display) ? $author->field_name_display['und'][0]['value'] : $author->name;
      $vars['author_name'] = l($user_name, 'insights/user/' . $author->name);
      // News Type
      $type_id = $node->field_category['und'][0]['tid'];
      $type_name = $node->field_category['und'][0]['taxonomy_term']->name;
      $vars['taxonomy_type'] = l($type_name, 'news', array('query' => array('type' => $type_id)));
    }
    elseif ($node->type == "case_study") {
      $vars['banner_case_study'] = TRUE;
      // Picture
      $vars['banner_title'] = $node->title;
      if (isset($node->field_banner['und'][0]['uri'])) {
        $vars['banner_image'] = file_create_url($node->field_banner['und'][0]['uri']);
      }
      // Description
      if (isset($node->field_subtitle['und'][0]['value'])) {
        $vars['banner_description'] = $node->field_subtitle['und'][0]['value'];
      }
      // Normal layout
      if ($node->field_layout_type['und'][0]['value'] != '2') {
        $vars['template_normal'] = TRUE;
      }

    }
    elseif ($node->type == "careers_job") {
      $vars['banner_careers_job'] = TRUE;
      // Picture
      $pic_fid = theme_get_setting('jobs_detail_default_image');
      $vars['banner_image'] = $base_url . '/' . drupal_get_path('theme', 'smartosc') . '/images/career/banner.jpg';
      if (!empty($pic_fid)) {
        $file = file_load($pic_fid);
        if ($file) {
          $vars['banner_image'] = image_style_url('banner_picture', $file->uri);
        }
      }
      // Title
      $vars['title_node'] = $node->title;
      // Description
      if (isset($node->field_offices['und'][0]['tid'])) {
        $tid = $node->field_offices['und'][0]['tid'];
        $vars['banner_location'] = taxonomy_term_load($tid)->name;
      }
      if (isset($node->body['und'][0]['summary'])) {
        $vars['banner_description'] = $node->body['und'][0]['summary'];
      }
    }
  }
}

/**
 * hook_preprocess_node
 */
function smartosc_preprocess_node(&$vars) {
  global $user;

  global $base_url;
  global $language;
  $lag = $language->language;

	$node = $vars ['node'];
	$author = user_load($node->uid);
	$vars['user_image'] = !empty($author->picture->uri) ? $author->picture->uri : variable_get('user_picture_default');
	$vars['user_name'] 	= !empty($author->field_name_display) ? $author->field_name_display['und'][0]['value'] : $author->name;
	$vars['author_info'] = $author;

  $vars['faqs_text'] = theme_get_setting('faqs_title');
  $vars['faqs_link'] = $base_url.'/'.$lag.'/'.theme_get_setting('faqs_path');

  if ($node->type == "article") {
    if (isset($node->field_tags['und'])) {
      $tags_list = $node->field_tags['und'];
      foreach ($tags_list as $key => $item) {
        $name_tax = $item['taxonomy_term']->name;
        $path_name = preg_replace('@[^a-z0-9-]+@','-', strtolower($name_tax));

        $vars['tags_link'][$key]['text'] = $name_tax;
        $vars['tags_link'][$key]['path'] = "insights/tag/".$path_name;
      }
    }
  }elseif($node->type == "case_study"){
    $background = $node->field_background_scope['und'][0]['color'];
    $color = $node->field_color_scope['und'][0]['color'];

    $style_css = '';
    $header_color = $node->field_head_color['und'][0]['color'];
    if(!empty($header_color)){
      $style_css .= ".banner-recent .header_info{";
      $style_css .= 'color: ' . $header_color . ';';
      $style_css .= "}\n";
    }
    if (isset($node->field_layout_header['und'][0]['value'])) {
      $header_type = $node->field_layout_header['und'][0]['value'];
      if ($header_type == "1" && (!empty($background) || !empty($color))) {
        $style_css .= ".page-not-gradien .introduction-scope, .page-not-gradien .sope-pic{";
        if (!empty($background)) {
          $style_css .= 'background: ' . $background . ';';
        }
        if (!empty($color)) {
          $style_css .= 'color: ' . $color . ';';
        }
        $style_css .= "}\n";
      } elseif ($header_type == "2") {
        if (!empty($background)) {
          $hex_gra = rgb2hex($background);
          $style_css .= ".banner-recent:before{";
          $style_css .= 'background: -moz-linear-gradient(top, ' . hex2rgba($hex_gra, 0.01) . ' 0%, ' . hex2rgba($hex_gra, 0.06) . ' 4%, ' . hex2rgba($hex_gra, 0.15) . ' 9%, ' . hex2rgba($hex_gra, 0.27) . ' 13%, ' . hex2rgba($hex_gra, 0.58) . ' 25%, ' . hex2rgba($hex_gra, 0.82) . ' 33%, ' . hex2rgba($hex_gra, 0.94) . ' 39%,  ' . hex2rgba($hex_gra, 1) . ' 43%, ' . hex2rgba($hex_gra, 1) . ' 100%);
                      background: -webkit-linear-gradient(top, ' . hex2rgba($hex_gra, 0.01) . ' 0%, ' . hex2rgba($hex_gra, 0.06) . ' 4%, ' . hex2rgba($hex_gra, 0.15) . ' 9%, ' . hex2rgba($hex_gra, 0.27) . ' 13%, ' . hex2rgba($hex_gra, 0.58) . ' 25%, ' . hex2rgba($hex_gra, 0.82) . ' 33%, ' . hex2rgba($hex_gra, 0.94) . ' 39%,' . hex2rgba($hex_gra, 1) . ' 43%,' . hex2rgba($hex_gra, 1) . ' 100%);
                      background: linear-gradient(to bottom, ' . hex2rgba($hex_gra, 0.01) . ' 0%, ' . hex2rgba($hex_gra, 0.06) . ' 4%, ' . hex2rgba($hex_gra, 0.15) . ' 9%,' . hex2rgba($hex_gra, 0.27) . ' 13%, ' . hex2rgba($hex_gra, 0.58) . ' 25%, ' . hex2rgba($hex_gra, 0.82) . ' 33%, ' . hex2rgba($hex_gra, 0.94) . ' 39%,' . hex2rgba($hex_gra, 1) . ' 43%,' . hex2rgba($hex_gra, 1) . ' 100%);';
          $style_css .= "}\n";
          $style_css .= ".introduction-scope, .sope-pic{";
          $style_css .= 'background: ' . $background . ';';
          $style_css .= "}\n";
          //$style_css .= ".sope-pic:after{";
          //$style_css .= 'background: -moz-linear-gradient(top, ' . hex2rgba($hex_gra,1) . ' 0%, ' . hex2rgba($hex_gra,1) . ' 36%, ' . hex2rgba($hex_gra,0.94) . ' 42%, ' . hex2rgba($hex_gra,0.7) . ' 58%, ' . hex2rgba($hex_gra,0.58) . ' 66%, ' . hex2rgba($hex_gra,0.27) . ' 75%, ' . hex2rgba($hex_gra,0.15) . ' 81%, ' . hex2rgba($hex_gra,0.09) . ' 86%, ' . hex2rgba($hex_gra,0.06) . ' 89%, ' . hex2rgba($hex_gra,0.05) . ' 90%, ' . hex2rgba($hex_gra,0.04) . ' 91%, ' . hex2rgba($hex_gra,0.03) . ' 93%, ' . hex2rgba($hex_gra,0.02) . ' 97%, ' . hex2rgba($hex_gra,0.01) . ' 100%);
          //              background: -webkit-linear-gradient(top, ' . hex2rgba($hex_gra,1) . ' 0%,' . hex2rgba($hex_gra,1) . ' 36%,' . hex2rgba($hex_gra,0.94) . ' 42%,' . hex2rgba($hex_gra,0.7) . ' 58%,' . hex2rgba($hex_gra,0.58) . ' 66%,' . hex2rgba($hex_gra,0.27) . ' 75%,' . hex2rgba($hex_gra,0.15) . ' 81%,' . hex2rgba($hex_gra,0.09) . ' 86%,' . hex2rgba($hex_gra,0.06) . ' 89%,' . hex2rgba($hex_gra,0.05) . ' 90%,' . hex2rgba($hex_gra,0.04) . ' 91%,' . hex2rgba($hex_gra,0.03) . ' 93%,' . hex2rgba($hex_gra,0.02) . ' 97%,' . hex2rgba($hex_gra,0.01) . ' 100%);
          //              background: linear-gradient(to bottom, ' . hex2rgba($hex_gra,1) . ' 0%,' . hex2rgba($hex_gra,1) . ' 36%,' . hex2rgba($hex_gra,0.94) . ' 42%,' . hex2rgba($hex_gra,0.7) . ' 58%,' . hex2rgba($hex_gra,0.58) . ' 66%,' . hex2rgba($hex_gra,0.27) . ' 75%,' . hex2rgba($hex_gra,0.15) . ' 81%,' . hex2rgba($hex_gra,0.09) . ' 86%,' . hex2rgba($hex_gra,0.06) . ' 89%,' . hex2rgba($hex_gra,0.05) . ' 90%,' . hex2rgba($hex_gra,0.04) . ' 91%,' . hex2rgba($hex_gra,0.03) . ' 93%,' . hex2rgba($hex_gra,0.02) . ' 97%,' . hex2rgba($hex_gra,0.01) . ' 100%);';
          //$style_css .= "}\n";
        }
        if (!empty($color)) {
          $style_css .= ".banner-recent .header_info, .introduction-scope{";
          $style_css .= 'color: ' . $color . ';';
          $style_css .= "}\n";
        }
      }
    }
    drupal_add_css($style_css, array('type' => 'inline','weight' => '10','group' => CSS_THEME));
  } elseif($node->type == "careers_job"){
    if (in_array('HRO-editor', $user->roles) || in_array('administrator', $user->roles)) {
      $style_css = ".page-node ul.links{";
      $style_css .= "display: block; margin-top: 30px; padding-left: 20px;";
      $style_css .= "}\n";
      drupal_add_css($style_css, array('type' => 'inline','weight' => '10','group' => CSS_THEME));
    }
  }
}

/**
 *  Overwirte template_button
 */
function smartosc_button($vars) {
  $element = $vars['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  if (!isset($element['#attributes']['class']) || !in_array("btn", $element['#attributes']['class'])) {
    $element['#attributes']['class'][] = 'btn btn-primary form-' . $element['#button_type'];
  }
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }
  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}
/**
 * hook_form_alter
 */
function smartosc_form_alter(&$form, $form_state, $form_id) {
  if ($form_id == 'contact_site_form') {
    $form['actions']['submit']['#attributes']['class'][] = 'btn-dark btn-lg';
    $form['#attributes']['class'][] = 'col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12';
    //  unset($form['name']['#title']);
    //  unset($form['mail']['#title']);
    //  unset($form['message']['#title']);
    //  unset($form['phone']['#title']);
    //  unset($form['via']['#title']);
  }
  if($form_id == "views_exposed_form"){
    $view = $form_state['view'];
    if ($view->name == 'so_case_study' && $view->current_display == 'page_work') {
      $form['show_all']['#markup'] = '<span class="label-all">'.t('All').'</span>';
      $form['field_case_type_tid']['#options']['All'] = t('Type');
      $form['field_industry_tid']['#options']['All'] = t('Industry');
    }

    $form['type']['#options']['All'] = t('Show all');
  }
  if (stristr($form_id, "webform_client_form")) {
    $form['actions']['submit']['#attributes']['class'] = array('btn','btn-md', 'webform-submit');
  }
}

/**
 * template_preprocess_views_view
 */
function smartosc_preprocess_views_view(&$vars) {
  global $base_url;
  $view = $vars['view'];
  $name = $view->name;
  $display = $view->current_display;

  $path_theme = drupal_get_path('theme', 'smartosc');
  // Alter js view exposed ajax
  if($name == 'so_case_study' && isset($view->exposed_data)) {
    drupal_add_js("{$path_theme}/front-end/js/view-ajax/view-exposed-ajax.js", array('weight' => 7));
  }
  // Alter js view infinite scroll
  if ($view->query->pager->plugin_name == 'infinite_scroll') {
    drupal_add_js("{$path_theme}/front-end/js/view-ajax/view-infinite-alter.js", array('weight' => 6));
  }

  // Banner picture
  if($name == 'so_careers_special' && $display == 'slider') {
    $pic_fid = theme_get_setting('jobs_default_image');
    $vars['banner_image'] = $base_url.'/'.drupal_get_path('theme', 'smartosc') .'/images/career/banner-white.jpg';
    if (!empty($pic_fid)) {
      $file = file_load($pic_fid);
      if ($file) {
        $vars['banner_image'] = image_style_url('banner_picture', $file->uri);
      }
    }
  }
}
/**
 * hook_views_ajax_data_alter
 * see more at https://api.drupal.org/api/drupal/includes%21ajax.inc/group/ajax/7.x
 */
function smartosc_views_ajax_data_alter(&$commands, $view) {
  if(isset($view->exposed_data)) {
    foreach ($commands as &$command) {
      if (!empty($command['method']) && $command['method'] === 'replaceWith' && $command['command'] === 'insert') {
        $command['command'] = 'pagerViewFade';
        $command['effect'] = 'fade';
        $command['speed'] = '500';
        //$command['settings'] = array(
        //  'fade_duration' => 500,   //use js get by: response.settings.fade_duration;
        //);
      }
    }
  }
}

/***************************************************************************
  Function rgb to hex / Hex to rgba
 ***************************************************************************/
// returns the hex value
function rgb2hex($rgb) {
  $regex = '#\((([^()]+|(?R))*)\)#';
  if (preg_match_all($regex, $rgb ,$matches)) {
    $rgb_array = explode(',', implode(' ', $matches[1]));
  } else {
    $rgb_array = explode(',', $rgb);
  }

  $hex = "#";
  $hex .= str_pad(dechex($rgb_array[0]), 2, "0", STR_PAD_LEFT);
  $hex .= str_pad(dechex($rgb_array[1]), 2, "0", STR_PAD_LEFT);
  $hex .= str_pad(dechex($rgb_array[2]), 2, "0", STR_PAD_LEFT);

  return $hex;
}
// returns the rgba value
function hex2rgba($color, $opacity = false) {
  if ($color[0] == '#' ) $color = substr($color,1);
  if (strlen($color) == 6) {
    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
  } elseif (strlen($color) == 3 ) {
    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
  }

  $rgb =  array_map('hexdec', $hex);
  if($opacity){
    if(abs($opacity) > 1) $opacity = 1.0;
    $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
  } else {
    $output = 'rgb('.implode(",",$rgb).')';
  }

  return $output;
}