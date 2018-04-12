
<?php

/****************************************************
 * Form news letter dotmail
 ***************************************************/
/**
 * Implement hook_form
 */
function news_letter_dotmailer_form() {
  $form = array();
  $form['#attributes'] = array('class' => 'news-letter-dotmailer');

  $form['messages'] = array(
    '#type' => 'markup',
  );

  $title_form = variable_get('form_dotmailer_title');
  if(!empty($title_form)) {
    $form['news_dotmailer']['slogan_news_letter'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="title-dotmailer"><h4>' . t($title_form) . '</h4></div>',
    );
  }

  $form['news_dotmailer']['info_news_letter'] = array(
    '#prefix' => '<div class="form-dotmailer input-form-inline">',
    '#suffix' => '</div>',
    '#type' => 'markup',
  );
  $form['news_dotmailer']['info_news_letter']['dotmailer_username'] = array(
    '#type' => 'textfield',
    '#size' => 35,
    '#required' => TRUE,
    '#attributes' => array(
      'placeholder' => t('Name*'),
      //'required' => 'required',
    ),
  );
  $form['news_dotmailer']['info_news_letter']['dotmailer_email'] = array(
    '#type' => 'emailfield',
    '#size' => 35,
    '#required' => TRUE,
    '#attributes' => array(
      'placeholder' => t('Email*'),
      //'required' => 'required',
    )
  );
  $form['news_dotmailer']['info_news_letter']['button_form'] = array(
    '#prefix' => '<div class="button-submit">',
    '#suffix' => '</div>',
  );
  $form['news_dotmailer']['info_news_letter']['button_form']['submit'] = array(
    '#type'   => 'submit',
    '#value'  => t('Subscribe'),
    '#attributes' => array('class' => array('btn-blue')),
    '#ajax'       => array(
      'callback' => 'ajax_news_letter_dotmailer',
      'wrapper' => 'news-letter-dotmailer-form',
    ),
  );
  return $form;
}
function ajax_news_letter_dotmailer($form, &$form_state) {
  $values = $form_state['values'];

  /*  validate form */
  if (isset($values['dotmailer_username'])) {
    if (!empty($values['dotmailer_username'])) {
      if (strlen($values['dotmailer_username']) < 2) {
        form_set_error('dotmailer_username', t('%dotmailer_username is less than 2 characters.', array('%dotmailer_username' => $values['dotmailer_username'])));
      }
    } else {
      form_set_error('dotmailer_username', t('Please input your username!'));
    }
  }
  if (isset($values['dotmailer_email'])) {
    if (!empty($values['dotmailer_email'])) {
      if (!valid_email_address($values['dotmailer_email'])) {
        form_set_error('dotmailer_email', t('%dotmailer_email is an invalid e-mail address.', array('%dotmailer_email' => $values['dotmailer_email'])));
      }
    } else {
      form_set_error('dotmailer_email', t('Please input your e-mail address.'));
    }
  }

  /* Submit form*/
  if (!form_get_errors()) {
      $email_user = $values['dotmailer_email'];
      $name_user = $values['dotmailer_username'];

      //Send Email
      $to = array(variable_get('domailer_email_receive', 'job@smartosc.com'));
      $from = $email_user;
      if (is_array($to)) {
        foreach ($to as $mail) {
          drupal_mail('letter', 'dotmail_letter_mail', trim($mail), language_default(), $values, $from);
        }
      } else {
        drupal_mail('letter', 'dotmail_letter_mail', trim($to), language_default(), $values, $from);
      }

      // Send Data to Dotmail
      $dotuser = variable_get('username_dotmailer_api');
      $dotpass = variable_get('password_dotmailer_api');
      $dotadressbook = variable_get('addressbookId_dotmailer_api');

      /* Adding contact to dotmailer address book using API Rest
      https://stackoverflow.com/questions/29681030/adding-contact-to-dotmailer-address-book-using-api*/

      error_reporting(E_ALL);
      ini_set('display_errors', '1');
      $content = [
        'email' => $email_user,
        'EmailType' => 'Html',
        "dataFields" => array(
          array(
            "key" => "FULLNAME",
            "value" => $name_user,
          ),
        ),
      ];
      $url = "https://api.dotmailer.com/v2/address-books/".$dotadressbook."/contacts";

      //initialise curl session
      $ch = curl_init();
      //curl options
      curl_setopt($ch, CURLAUTH_BASIC, CURLAUTH_DIGEST);
      curl_setopt($ch, CURLOPT_USERPWD, $dotuser . ':' . $dotpass);
      curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($content));
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

      curl_setopt($ch, CURLOPT_TIMEOUT, 10);

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/json'));
      //curl execute and json decode the response
      json_decode(curl_exec($ch));
      //close curl session
      curl_close($ch);

      // messages & hiden
      //setrawcookie('cookie_email', $email_user, time() + 3600 * 24 * 180, '/');

      $messages_success = variable_get('form_dotmailer_message', 'Thank you, you have been successfully subscribed');
      $form['messages']["#markup"] = '<div class="newsletter_messages">'.t($messages_success).'</div>';;
      unset($form['news_dotmailer']);
  }
  return $form;
}

/** Implements Hook_form_submit() */
//function news_letter_dotmailer_form_submit($form, &$form_state) {
//  $values = $form_state['values'];


//    $email_user = $values['dotmailer_email'];
//    $name_user = $values['dotmailer_username'];
//
//    $dotuser = variable_get('username_dotmailer_api', 'apiuser-e821b153b259@apiconnector.com');
//    $dotpass = variable_get('password_dotmailer_api', 'SmartOSC346LCY!');
//    $dotadressbook = variable_get('addressbookId_dotmailer_api', '1935031');

//    /* Add contact to dotmailer address book using SoapClient */
//    $client = new SoapClient('http://apiconnector.com/api.asmx?WSDL', array('trace' => true));
//    $var_name = new SoapVar("JohnSmithJunior", XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");//
//    $dataFields = array("Keys" => array("FULLNAME"), "Values" => array($var_name));
//
//    $client->AddContactToAddressBook(
//      array(
//        'username' => 'apiuser-e821b153b259@apiconnector.com',
//        'password' => 'SmartOSC346LCY!',
//        'addressbookId' => '1935031',
//        'contact' => array(
//          "Email" => "someemail@gmail.com",
//          'Postcode' => 'none',
//          "OptInType" => "Single",
//          "EmailType" => "Html",
//          "ID" => '1935031',
//          "AudienceType" => "Unknown",
//          'DataFields' => $dataFields,
//        ),
//      )
//    );


//}




/** Implements Hook_mail() */
function letter_mail($key, &$message, $params) {
  if($key == 'dotmail_letter_mail') {
    $infos = $params;
    $subject = t("Sign up for news letter");

    $body   = "Dear, \r\n Informations of user: \r\n Username: ". $infos['dotmailer_username'] .
      " \r\n Email: " . $infos['dotmailer_email'];
    $message['subject'] = str_replace(array("\r", "\n"), '', $subject);
    $message['body'][] = drupal_html_to_text($body);
  }
}