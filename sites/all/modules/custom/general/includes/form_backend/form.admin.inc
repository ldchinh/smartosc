<?php
/**
 * reviewed, Nov 2nd 2012
 */
/**
 * @file
 */


/**
 * Form builder; The general site information form.
 *
 * @ingroup forms
 * @see system_settings_form()
 */
function system_smartosc_settings($form) {
  $form = array();

  //Form apply career
  $form['career'] = array(
    '#weight' => '1',
    '#collapsed' => '',
    '#type' => 'fieldset',
    '#collapsible' => '1',
    '#title' => t('Career Configuration'),
  );
  $form['career']['career_email_to'] = array(
  		'#title' => t('Email: '),
  		'#description' => t('Please input email to  for "SIGN UP FOR CAREER NEWS"'),
  		'#type' => 'textfield',
  		'#default_value' => variable_get('career_email_to', 'job@smartosc.com'),
  );

  //Form apply dotmailer & Form News have category White Paper
  $form['insights'] = array(
    '#weight' => '2',
    '#collapsed' => '',
    '#type' => 'fieldset',
    '#collapsible' => '1',
    '#title' => t('Insights Configuration'),
  );
  $form['insights']['dotmailer_contact'] = array(
    '#collapsed' => '',
    '#type' => 'fieldset',
    '#collapsible' => '1',
    '#title' => t('News Letter Dotmailer'),
  );
  $form['insights']['dotmailer_contact']['username_dotmailer_api'] = array(
    '#title' => t('Email Dotmailer Access API: '),
    '#type' => 'textfield',
    '#size' => 40,
    '#description' => t('<small>Get Account API: <i>Login to dotmailer => profile => Access=> API user</i></small>'),
    '#default_value' => variable_get('username_dotmailer_api', 'apiuser-e821b153b259@apiconnector.com'),
  );
  $form['insights']['dotmailer_contact']['password_dotmailer_api'] = array(
    '#title' => t('Password Dotmailer Access API: '),
    '#type' => 'textfield',
    '#size' => 20,
    '#default_value' => variable_get('password_dotmailer_api', 'SmartOSC346LCY!'),
    '#attributes' => array(
      'placeholder' => t('password'),
    ),
  );
  $form['insights']['dotmailer_contact']['addressbookId_dotmailer_api'] = array(
    '#title' => t('Id Address Book Dotmailer: '),
    '#type' => 'textfield',
    '#size' => 20,
    '#default_value' => variable_get('addressbookId_dotmailer_api', '1935031'),
    '#description' => t('It\'s a ID of "Address Book" in List Contact. Example: https://r1-app.dotmailer.com/Contacts/ListContacts.aspx?i=1935031'),
  );
  $form['insights']['dotmailer_contact']['form_info'] = array(
    '#collapsed' => '',
    '#type' => 'fieldset',
    '#collapsible' => '1',
    '#title' => t('Form Info'),
  );
  $form['insights']['dotmailer_contact']['form_info']['form_dotmailer_title'] = array(
    '#title' => t('Title Subscribe:'),
    '#type' => 'textfield',
    '#size' => 40,
    '#default_value' => variable_get('form_dotmailer_title', 'Get insights like this in your inbox'),
  );
  $form['insights']['dotmailer_contact']['form_info']['domailer_email_receive'] = array(
    '#title' => t('Email: '),
    '#description' => t('Please input email to receive mail'),
    '#type' => 'textfield',
    '#default_value' => variable_get('domailer_email_receive', 'info@smartosc.com'),
  );
  $form['insights']['dotmailer_contact']['form_info']['form_dotmailer_message'] = array(
    '#title' => t('Message Success:'),
    '#type' => 'textfield',
    '#default_value' => variable_get('form_dotmailer_message', 'Thank you, you have been successfully subscribed'),
  );

  $form['insights']['questions_contact'] = array(
    '#collapsed' => '',
    '#type' => 'fieldset',
    '#collapsible' => '1',
    '#title' => t('Questions Contact Configuration'),
  );
  $form['insights']['questions_contact']['questions_contact_email_to'] = array(
    '#title' => t('Email: '),
    '#description' => t('Please input email to receive mail'),
    '#type' => 'textfield',
    '#default_value' => variable_get('questions_contact_email_to', 'info@smartosc.com'),
  );

  //Form Contact
  $form['contact_info'] = array(
    '#weight' => '3',
    '#collapsed' => '',
    '#type' => 'fieldset',
    '#collapsible' => '1',
    '#title' => t('Contact Configuration'),
  );
  $form['contact_info']['contact_title'] = array(
    '#title' => t('Page Title: '),
    '#type' => 'textfield',
    '#default_value' => variable_get('contact_title', 'How can we help you?'),
  );
  
  return system_settings_form($form);
}