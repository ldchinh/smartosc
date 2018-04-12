
<?php

/**************************************
* Form Contact
***************************************/
/**
 * Implements hook_form_FORM_ID_alter().
 */
function general_form_contact_site_form_alter(&$form, &$form_state) {
  $title = variable_get('contact_title', 'How can we help you?');

  drupal_set_title(t($title));
  $fieldsToRemove = array('subject', 'copy');
  foreach ($fieldsToRemove as $field) {
		if (isset($form[$field])) {
			unset($form[$field]);
		}
  }


	global $language_url;
	$current_lag = $language_url->language;
	$bid = $form['cid']['#default_value'];
	foreach ($form['cid']['#options'] as $key => $value) {
		if(strtolower($value) == $current_lag){
			$bid = $key;
		}
	}
	$form['cid'] = array('#type' => 'hidden', '#value' => $bid);


	$form['name']['#title'] = 'Your Name';
  $form['name']['#attributes'] = array('placeholder' => t('Your Name*'));
  $form['name']['#attributes']['required'] = 'required';
  $form['name']['#prefix'] = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 group-left">';
  $form['name']['#suffix']	= '</div>';
  $form['name']['#weight'] = 0;

  $form['phone']['#title'] = 'Phone Number';
  $form['phone']['#type'] = 'textfield';
  $form['phone']['#attributes'] = array('placeholder' => t('Phone Number'));
  $form['phone']['#prefix'] = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 group-right">';
  $form['phone']['#suffix']	= '</div>';
  $form['phone']['#weight'] = 1;

  $form['mail']['#title'] = t('Email Address');
  $form['mail']['#type'] = 'emailfield';
  $form['mail']['#attributes'] = array('placeholder' => t('Email Address*'));
  $form['mail']['#attributes']['required'] = 'required';
  $form['mail']['#prefix'] = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 group-left">';
  $form['mail']['#suffix']	= '</div>';
  $form['mail']['#weight'] = 2;

  $form['company']['#title'] = 'Company';
  $form['company']['#type'] = 'textfield';
  $form['company']['#attributes'] = array('placeholder' => t('Company'));
  $form['company']['#prefix'] = '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 group-right">';
  $form['company']['#suffix']	= '</div>';
  $form['company']['#weight'] = 3;

//  $arr_media = array(
//	'via Google' 	=> t('via Google'),
//	'via Facebook' 	=> t('via Facebook'),
//	'via LinkedIn' 	=> t('via LinkedIn'),
//	'via Twitter' 	=> t('via Twitter')
//  );

//  $form['via'] = array(
//	'#type' => 'select',
//	'#title' => 'How did you find us?',
//	'#empty_option' => t('How did you find us?'),
//	'#options' 	=>	$arr_media,
//	'#prefix'	=> '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 group-right">',
//	'#suffix'	=> '</div>',
//  '#weight'	=> 3,
//  );

  $form['message']['#title'] = 'Your Message';
  $form['message']['#attributes'] = array('placeholder' => t('Your Message*'));
  $form['message']['#attributes']['required'] = 'required';
  $form['message']['#prefix'] = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 group-message">';
  $form['message']['#suffix'] = '</div>';
  $form['message']['#weight'] = 4;

  $form['actions']['submit']['#value'] = t('Send Message');
  
//  $contact_intro = module_invoke('block', 'block_view','144');
//  $form['description'] = array(
//  		'#markup'=> '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 group-intro">' . $contact_intro['content'] . ' </div>'
//  );

  $form['actions']['#prefix'] = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
  $form['actions']['#suffix'] = '</div>';
 
  $order = array(
    'name',
	  'phone',
    'mail',
    //'via',
    'company',
  	'message',
    'submit'
  );
 
  foreach ($order as $key => $field) {
    $form[$field]['#weight'] = $key;
  }

  $form['#validate'] 	= array('general_contact_form_validation');
  $form['#submit'] 		= array('general_contact_form_submit');
}

function general_contact_form_submit($form, &$form_state) {
  $values = $form_state['values'];
	$values['category'] = contact_load($values['cid']);
	// $site_email = variable_get('site_mail', 'info@smartosc.com');
  //if (!$user->uid) {
  //  user_cookie_save(array_intersect_key($values, array_flip(array('name', 'mail'))));
  //}
  // Get the to and from e-mail addresses.
	$to = $values['category']['recipients'];
	$from = $values['mail'];

  // Send the e-mail to the recipients using the site default language.
  drupal_mail('general_contact', 'page_mail', $to, language_default(), $values, $from);

  // If the user requests it, send a copy using the current language.
//  if ($values['copy']) {
//	drupal_mail('contact', 'page_copy', $from, $language, $values, $from);
//  }

  // Send an auto-reply if necessary using the current language.
//  if ($values['category']['reply']) {
//	drupal_mail('contact', 'page_autoreply', $from, $language, $values, $to);
//  }

  flood_register_event('contact', variable_get('contact_threshold_window', 3600));
  watchdog('mail', '%sender-name (@sender-from) sent an e-mail regarding %category.', array('%sender-name' => $values['name'], '@sender-from' => $from));

  // Jump to home page rather than back to contact page to avoid
  // contradictory messages if flood control has been activated.
  drupal_set_message(t('Thank you for contacting us.<br/>We will get back to you within 24 hours.'));
  //$form_state['redirect'] = 'contact';
}

function general_contact_mail($key, &$message, $params) {
  $variables['!mail'] = $params['mail'];
  $variables['!name'] = $params['name'];
  $variables['!phone'] = $params['phone'];
  $variables['!company'] = $params['company'];
  //$variables['!via'] = $params['via'];
  $message['subject'] .= t('SmartOSC Contact Request | !mail', $variables);
  $message['body'][] = t('Contact name: !name', $variables);
  $message['body'][] = t('Phone number: !phone', $variables);
  $message['body'][] = t('Email address: !mail', $variables);
  $message['body'][] = t('Company: !company', $variables);
  //$message['body'][] = t('Find us by: !via', $variables);
  $message['body'][] = t('Message:');
  $message['body'][] = $params['message'];
}

/**
 * Validate for contact form.
 * @param array $form
 * @param array $form_state
 */
function general_contact_form_validation (&$form, &$form_state) {
  if (!valid_email_address($form_state['values']['mail'])) {
	form_set_error('mail', t('You must enter a valid e-mail address.'));
  }
}