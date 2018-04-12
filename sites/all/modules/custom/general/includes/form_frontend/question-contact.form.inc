
<?php

/****************************************************
 * Form Contact Question =for=> "White Paper" of Insights
 ***************************************************/
/**
 * Implement hook_form
 */
function general_questions_contact_form() {
	$form = array();
	$form['#attributes'] = array('class' => 'form-question-contact');

  $form['messages'] = array(
    '#type'   => 'markup',
    '#prefix' => '<div id="faqs_messages" class="faqs-contact">',
    '#suffix' => '</div>',
  );

  $form['questions_contact'] = array(
    '#prefix' => '<div class="questions-form-contact">',
    '#suffix' => '</div>',
    '#type'   => 'markup',
  );
  $form['questions_contact']['user_name'] = array(
		'#type'       => 'textfield',
		'#size'       => 35,
    '#required'   => TRUE,
		'#attributes' => array('placeholder' => t('Name*')),
	);
  $form['questions_contact']['user_email'] = array(
		'#type'       => 'emailfield',
		'#size'       => 35,
    '#required'   => TRUE,
    '#attributes' => array('placeholder' => t('Email*')),
	);
  $form['questions_contact']['user_company'] = array(
    '#type'       => 'textfield',
    '#size'       => 35,
    '#attributes' => array('placeholder' => t('Company')),
  );
  $form['questions_contact']['question_message'] = array(
    '#type'       => 'textarea',
    '#size'       => 35,
    '#rows'	      => 7,
    '#maxlength'  => 128,
    '#required'   => TRUE,
    '#attributes' => array('placeholder' => t('Message*')),
  );
  $form['questions_contact']['button_form'] = array(
    '#prefix'     => '<div class="button-submit">',
    '#suffix'     => '</div>',
  );
  $form['questions_contact']['button_form']['submit'] = array(
		'#type'       => 'submit',
		'#value'      => t('Send'),
    '#attributes' => array('class' => array('btn-dark','btn-md')),
    '#ajax'       => array(
                  'callback' => 'ajax_general_questions_contact_form_submit',
                  'wrapper' => 'general-questions-contact-form',  //'faqs_messages'
                ),
	);
	return $form;
}

/**
 * Enter description here ...
 */
function ajax_general_questions_contact_form_submit($form, &$form_state) {
  $values = $form_state['values'];
  /*  validate form */
  if (isset($values['user_name'])) {
    if (empty($values['user_name'])) {
      form_set_error('candidate_username_empty', t('Please input your username!'));
    }
  }
  if (isset($values['user_email'])) {
    if (!empty($values['user_email'])) {
      if (!valid_email_address($values['user_email'])) {
        form_set_error('user_email', t('%user_email is an invalid e-mail address.', array('%user_email' => $values['user_email'])));
      }
    } else {
      form_set_error('candidate_email_empty', t('Please input your e-mail address.'));
    }
  }
  if (isset($values['question_message'])) {
    if (empty($values['question_message'])) {
      form_set_error('candidate_message_empty', t('Please input Message'));
    }
  }
  /*  End validate form */


  /* Aciton Submit */
  if (!form_get_errors()) {
    $mail_to_adress = variable_get('questions_contact_email_to', 'info@smartosc.com');
    $to = preg_split('/[\s,]+/', $mail_to_adress);
    $from = $values['user_email'];

    //send mail
    if (is_array($to)) {
      foreach ($to as $mail) {
        drupal_mail('questions_contact_receive', 'contact_mail_faqs', trim($mail), language_default(), $values, $from);
      }
    } else {
      drupal_mail('questions_contact_receive', 'contact_mail_faqs', trim($to), language_default(), $values, $from);
    }

    $form['messages']["#markup"] = '<div class="alert align-left alert-success">'.t("Thank you for contacting us. We will get back to you within 24 hours").'</div>';
    //drupal_set_message(t("Thank you! </br> Your questions was sent to our system."), 'status');
    unset($form['questions_contact']);
  }
  return $form;
}

/** Implements Hook_mail() */
function questions_contact_receive_mail($key, &$message, $params) {
  if($key == 'contact_mail_faqs') {
    $info_send = $params;
    $subject = t("Have any questions?");
    $message['subject'] = str_replace(array("\r", "\n"), '', $subject);
    $message['body'][] = $info_send['question_message'];
    $body   = "\r\n Informations of user: \r\n Username: ". $info_send['user_name'] . " \r\n Email: " . $info_send['user_email'] . " \r\n Company: " . $info_send['user_company'];
    $message['body'][] = drupal_html_to_text($body);
  }
}