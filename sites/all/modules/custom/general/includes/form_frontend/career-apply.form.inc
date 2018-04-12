
<?php

/**************************************
 * Form Career Apply
 ***************************************/
/**
 * Implement hook_form
 */
function general_career_apply_job_form() {
	$form = array();
	$form['#attributes'] = array('class' => 'form-apply-job');

  $subject = drupal_get_title();

  //Code not important
  $node = menu_get_object('node');
  if(isset($node->field_offices['und'][0]['tid'])) {
    $tid_offices = $node->field_offices['und'][0]['tid'];
    $term_offices = taxonomy_term_load($tid_offices);
  }
  //End code not important

  $form['messages'] = array(
    '#type'   => 'markup',
    '#prefix' => '<div id="job_messages" class="job-careers-cv">',
    '#suffix' => '</div>',
  );

  $form['info_user'] = array(
    '#prefix' => '<div class="curriculum-vitae-form">',
    '#suffix' => '</div>',
    '#type'   => 'markup',
  );
  $form['info_user']['form_title'] = array(
    "#markup" => '<h3>'.t('APPLY THIS JOB').'</h3>',
  );

  //Code not important
  if(isset($term_offices)) {
    if (!empty($term_offices->description)) {
      $form['info_user']['candidate_info']["#markup"] = '<div class="info">' . $term_offices->description . '</div>';
    }
    if (!empty($term_offices->field_email)) {
      $form['info_user']['candidate_to_send'] = array('#type' => 'hidden', '#value' => $term_offices->field_email['und'][0]['value']);
    }
  }
  //End code not important

  $form['info_user']['candidate_username'] = array(
		'#type'       => 'textfield',
		'#size'       => 35,
    '#required'   => TRUE,
		'#attributes' => array('placeholder' => t('Name*')),
	);
  $form['info_user']['candidate_email'] = array(
		'#type'       => 'emailfield',
		'#size'       => 35,
    '#required'   => TRUE,
		'#attributes' => array('placeholder' => t('Email*'))
	);
  $form['info_user']['candidate_subject'] = array(
    '#type'           => 'textfield',
    '#attributes'     => array('placeholder' => t('Subject')),
    '#default_value'  => $subject,
  );
  $form['info_user']['candidate_attachment'] = array(
    '#title'      => t('Curriculum Vitae <span class="form-required">*</span>'),
    '#type'       => 'file',
    '#attributes' => array(
      'class'     => array('form-input-inline')
    )
  );
  $form['info_user']['candidate_message'] = array(
    '#type'       => 'textarea',
    '#size'       => 35,
    '#rows'	      => 7,
    '#maxlength'  => 128,
    '#required'   => TRUE,
    '#attributes' => array('placeholder' => t('Message *')),
  );
  $form['info_user']['button_form'] = array(
    '#prefix'     => '<div class="button-submit">',
    '#suffix'     => '</div>',
  );
  $form['info_user']['button_form']['submit'] = array(
		'#type'       => 'submit',
		'#value'      => t('Send'),
    '#attributes' => array('class' => array('btn-dark','btn-md')),
    '#ajax'       => array(
                  'callback' => 'ajax_general_career_apply_job_form_submit',
                  'wrapper' => 'general-career-apply-job-form',  //'job_messages'
                ),
	);
	return $form;
}

/**
 * Enter description here ...
 */
function ajax_general_career_apply_job_form_submit($form, &$form_state) {
  /*  validate form */
  $file_attachment = file_save_upload('candidate_attachment', array (
    'file_validate_extensions' => array('txt doc docx xls xlsx pdf ppt pps odt ods odp zip rar jpg jpeg gif png'),
    //"public://", FILE_EXISTS_REPLACE
  ));
  if ($file_attachment) {
    if ($file = file_move($file_attachment, 'public://curriculum_vitae/')) {
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $attachments = array(
        'filepath' => $file->uri,
        'filename' => $file->filename,
        'filemime' => $file->filemime,
        'list' => TRUE,
      );
      $form_state['values']['file_attachment'] = $attachments;
    }
    else {
      form_set_error('file', t('Failed to write the uploaded file the site\'s file folder.'));
    }
  } else {
    form_set_error('file', t('Curriculum Vitae field is required.'));
  }
  if (isset($form_state['values']['candidate_username'])) {
    if (!empty($form_state['values']['candidate_username'])) {
      if (strlen($form_state['values']['candidate_username']) < 2) {
        form_set_error('candidate_username', t('%candidate_username is less than 3 characters.', array('%candidate_username' => $form_state['values']['candidate_username'])));
      }
    } else {
      form_set_error('candidate_username_empty', t('Please input your username!'));
    }
  }
  if (isset($form_state['values']['candidate_email'])) {
    if (!empty($form_state['values']['candidate_email'])) {
      if (!valid_email_address($form_state['values']['candidate_email'])) {
        form_set_error('candidate_email', t('%candidate_email is an invalid e-mail address.', array('%candidate_email' => $form_state['values']['candidate_email'])));
      }
    } else {
      form_set_error('candidate_email_empty', t('Please input your e-mail address.'));
    }
  }
  if (isset($form_state['values']['candidate_subject'])) {
    if (empty($form_state['values']['candidate_subject'])) {
      form_set_error('candidate_subject_empty', t('Please input subject email.'));
    }
  }
  if (isset($form_state['values']['candidate_message'])) {
    if (empty($form_state['values']['candidate_message'])) {
      form_set_error('candidate_message_empty', t('Please input Message email.'));
    }
  }
  /*  End validate form */
  
  /* Aciton Submit */
  if (!form_get_errors()) {
    $values = $form_state['values'];

    // Get the to and from e-mail addresses. Code not important
    if(isset($form_state['values']['candidate_to_send'])){
      $to = $form_state['values']['candidate_to_send'];
    }else {
      $to = array(variable_get('career_email_to', 'job@smartosc.com'));
    }
    // End code not important
    //$to = array(variable_get('career_email_to', 'job@smartosc.com'));
    $from = $values['candidate_email'];

    //send mail
    if (is_array($to)) {
      foreach ($to as $mail) {
        drupal_mail('apply_cv', 'upload_cv_mail', trim($mail), language_default(), $values, $from);
      }
    } else {
      drupal_mail('apply_cv', 'upload_cv_mail', trim($to), language_default(), $values, $from);
    }

    //$messages_sent = drupal_set_message(t("Your informations was sent to our system. We will candidate you ASAP. Thanks!"), 'candidate_mail_sent');
    //$form['messages']["#markup"] = '<div class="job_messages">'.t("Your informations was sent to our system. We will candidate you ASAP. Thanks!").'</div>';
    drupal_set_message(t("Thank you! </br> Your informations was sent to our system. We will candidate you ASAP"), 'status');
    unset($form['info_user']);
  }
  //return $form['messages'];
  return $form;
}
/** Implements Hook_mail() */
function apply_cv_mail($key, &$message, $params) {
  if($key == 'upload_cv_mail') {
    //$message['headers']['Content-Type'] = 'text/html; charset=UTF-8; format=flowed';
    //$message['headers']['MIME-Version'] = '1.0';
    //$message['headers']['Content-Transfer-Encoding'] = '8Bit';
    //$message['headers']['X-Mailer'] = 'Drupal';
    $info_send = $params;
    $body = "Mail from: User: ". $info_send['candidate_username'] . ". Email: " . $info_send['candidate_email'];
    $message['subject'] = $info_send['candidate_subject'];
    $message['params']['attachments'][] = $info_send['file_attachment'];

    $message['body'][] = $info_send['candidate_message'];
    $message['body'][] = drupal_html_to_text($body);
  }
}