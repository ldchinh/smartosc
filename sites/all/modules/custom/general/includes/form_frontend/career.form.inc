
<?php


/**************************************
 * Form Career Newsletter
 ***************************************/
/**
 * Implement hook_form
 */
function general_career_new_form() {
	$form = array();
	$form['#attributes'] = array('class' => 'input-form-inline');


  $form['#prefix'] = '<div id="general_career_messages" class="careers-news-letter">';
  $form['#suffix'] = '</div>';

  $form['messages'] = array(
    '#type' => 'markup',
  );
  $form['info_contact'] = array(
    '#prefix' => '<div class="poll-form">',
    '#suffix' => '</div>',
    '#type' => 'markup',
  );
  $form['info_contact']['contact_username'] = array(
		'#type' => 'textfield',
		'#size' => 35,
    '#required' => TRUE,
		'#attributes' => array('placeholder' => t('Name*')),

	);
  $form['info_contact']['contact_email'] = array(
		'#type' => 'emailfield',
		'#size' => 35,
    '#required' => TRUE,
		'#attributes' => array('placeholder' => t('Email*'))
	);
  $form['info_contact']['button_form'] = array(
    '#prefix' => '<div class="button-submit">',
    '#suffix' => '</div>',
  );
  $form['info_contact']['button_form']['submit'] = array(
		'#type'   => 'submit',
		'#value'  => t('Submit'),
    '#attributes' => array('class' => array('btn-blue')),
    '#ajax' => array(
      'callback' => 'ajax_general_career_new_form_submit',
      'wrapper' => 'general_career_messages',
    ),
	);
	return $form;
}

/**
 *
 * Implement hook_validate
 * @param unknown_type $form
 * @param unknown_type $form_state
 */
//function general_career_new_form_validate(&$form, &$form_state) {
//	if(isset($form_state['values']['contact_username'])) {
//		if(!empty($form_state['values']['contact_username'])){
//		   if (strlen($form_state['values']['contact_username']) < 3) {
//		      form_set_error('contact_username', t('%contact_username is least than 3 characters.', array('%contact_username' => $form_state['values']['contact_username'])));
//		   }
//		}else {
//		      form_set_error('contact_username', t('Please input your username!'));
//		}
//	}
//	if(isset($form_state['values']['contact_email'])) {
//		if (!empty($form_state['values']['contact_email'])){
//		   if (!valid_email_address($form_state['values']['contact_email'])) {
//		      form_set_error('contact_email', t('%contact_email is an invalid e-mail address.', array('%contact_email' => $form_state['values']['contact_email'])));
//		    }
//		}else {
//	      form_set_error('contact_email', t('Please input your e-mail address.'));
//		}
//	}
//}

/**
 * Enter description here ...
 */
function ajax_general_career_new_form_submit($form, &$form_state) {
  /*  validate form */
  if (isset($form_state['values']['contact_username'])) {
    if (!empty($form_state['values']['contact_username'])) {
      if (strlen($form_state['values']['contact_username']) < 2) {
        form_set_error('contact_username', t('%contact_username is less than 2 characters.', array('%contact_username' => $form_state['values']['contact_username'])));
      }
    } else {
      form_set_error('contact_username', t('Please input your username!'));
    }
  }
  if (isset($form_state['values']['contact_email'])) {
    if (!empty($form_state['values']['contact_email'])) {
      if (!valid_email_address($form_state['values']['contact_email'])) {
        form_set_error('contact_email', t('%contact_email is an invalid e-mail address.', array('%contact_email' => $form_state['values']['contact_email'])));
      }
    } else {
      form_set_error('contact_email', t('Please input your e-mail address.'));
    }
  }
  /* Aciton Submit */
  if (!form_get_errors()) {
    $values = $form_state['values'];
    $values['sender']['contact_username'] = $values['contact_username'];
    $values['sender']['contact_email'] = $values['contact_email'];


    // Get the to and from e-mail addresses.
    $to = array(variable_get('career_email_to', 'job@smartosc.com'));
    $from = $values['sender']['contact_email'];

    //send mail
    if (is_array($to)) {
      foreach ($to as $mail) {
        drupal_mail('general', 'contact_mail', trim($mail), language_default(), $values, $from);
      }
    } else {
      drupal_mail('general', 'contact_mail', trim($to), language_default(), $values, $from);
    }

    //$messages_sent = drupal_set_message(t("Your informations was sent to our system. We will contact you ASAP. Thanks!"), 'contact_mail_sent');
    $form['messages']["#markup"] = '<div class="careers_messages">'.t("Thank you for contacting us. We will get back to you within 24 hours").'</div>';
    unset($form['info_contact']);
  }
  return $form;
}
///* Implements Hook_form_ID_alter() */
//function general_form_general_career_new_form_alter(&$form, &$form_state ) {
//  if ($node = menu_get_object()) {
//    if($node->type == 'careers_job') {
//      $form['contact_username']['#default_value'] = '';
//      $form['contact_email']['#default_value'] = '';
//    }
//  }
//}
/** Implements Hook_mail() */
function general_mail($key, &$message, $params) {
  if($key == 'contact_mail') {
    $infos = $params;
    $subject = t("Sign up for career news");
    $body   = "Dear, \r\n Informations of user: \r\n Username: ". $infos['contact_username'] . " \r\n Email: " . $infos['contact_email'];
    $message['subject'] = str_replace(array("\r", "\n"), '', $subject);
    $message['body'][] = drupal_html_to_text($body);
  }
}