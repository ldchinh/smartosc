<?php
function smartosc_theme_settings_general(&$form,&$form_state) {
	$form['general_settings'] = array(
		'#type' => 'fieldset',
		'#title' => t('General')
	);

  // Page 404
  $form['general_settings']['page_not_found'] = array(
    '#type' => 'fieldset',
    '#title' => t('Page 404'),
    '#weight' => 1,
  );
  $form['general_settings']['page_not_found']['not_found_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => theme_get_setting('not_found_title') ? theme_get_setting('not_found_title') : t('Sorry, Page not found !'),
    '#attributes' => array(
      'class' => array('input-border big')
    ),
  );
  $form['general_settings']['page_not_found']['not_found_body'] = array(
    '#type'=>'text_format',
    '#format'=>'html',
    '#title' => t('Content'),
    '#resizable' => FALSE,
    '#rows' => 5,
    '#default_value' => theme_get_setting('not_found_body') ? theme_get_setting('not_found_body')['value'] : '',
    '#description' => t('The following text will be added in page 404.'),
    '#attributes' => array(
      'class' => array('input-border')
    )
  );

  // Link FAQS
  $form['general_settings']['careers_faqs'] = [
    '#type' => 'fieldset',
    '#title' => t('Link FAQS'),
    '#open' => TRUE,
  ];
  $form['general_settings']['careers_faqs']['faqs_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => theme_get_setting('faqs_title'),
  );
  $form['general_settings']['careers_faqs']['faqs_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Path'),
    '#default_value' => theme_get_setting('faqs_path'),
  );
}