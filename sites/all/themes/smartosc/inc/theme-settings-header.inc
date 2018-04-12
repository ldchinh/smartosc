<?php
function smartosc_theme_settings_header(&$form,&$form_state) {
	$form['header_settings'] = array(
		'#type' => 'fieldset',
		'#title' => t('Header')
	);

  //	Preloader
  $form['header_settings']['preloader'] = [
    '#type' => 'fieldset',
    '#title' => t('Preloader'),
    '#open' => TRUE,
  ];
  $form['header_settings']['preloader']['preload'] = array(
    '#type' => 'checkbox',
    '#title'        => t('Enable Preload'),
    '#description'  => t('Check here if you want the theme to use Preloader.'),
    '#attributes' => array(
      'class' => array('input-checkbox')
    ),
    '#default_value' => theme_get_setting('preload'),
  );
  $form['header_settings']['preloader']['preloader_type'] = array(
    '#type' => 'select',
    '#title' => t('Type'),
    '#states' => array(
      'visible' => array(
        ':input[name="preload"]' => array('checked' => TRUE),
      ),
    ),
    '#options' => array(
      1 => t('One'),
      2 => t('Two'),
      3 => t('Three'),
      4 => t('Four'),
    ),
    '#default_value' =>  theme_get_setting('preloader_type') ? theme_get_setting('preloader_type') : 1,
  );
  $form['header_settings']['preloader']['preloader_image'] = array(
    '#title'        => t('Upload Picture'),
    '#description'  => t('Images must be one of jpg, bmp, gif or png formats.'),
    '#type'         => 'managed_file',
    '#upload_location' => 'public://',
    '#states' => array(
      'visible' => array(
        ':input[name="preloader_type"]' => array('value' => '4'),
      ),
    ),
    '#attributes' => array(
      'class' => array('form-input-inline')
    ),
    '#default_value' => theme_get_setting('preloader_image'),
  );

  // Banner Jobs
  $form['header_settings']['jobs_default'] = [
    '#type' => 'fieldset',
    '#title' => t('Job Banner'),
    '#open' => TRUE,
  ];
  $form['header_settings']['jobs_default']['jobs_default_image'] = array(
    '#title'        => t('Upload Banner'),
    '#type'         => 'managed_file',
    '#description'  => t('Images must be one of jpg, bmp, gif or png formats.'),
    '#default_value' => theme_get_setting('jobs_default_image'),
    '#upload_location' => 'public://',
    '#attributes' => array(
      'class' => array('form-input-inline')
    )
  );
  $form['header_settings']['jobs_default']['jobs_detail_default_image'] = array(
    '#title'        => t('Upload Banner Job Detail'),
    '#type'         => 'managed_file',
    '#description'  => t('Images must be one of jpg, bmp, gif or png formats.'),
    '#default_value' => theme_get_setting('jobs_detail_default_image'),
    '#upload_location' => 'public://',
    '#attributes' => array(
      'class' => array('form-input-inline')
    )
  );

  // Banner News
  $form['header_settings']['news_default'] = [
    '#type' => 'fieldset',
    '#title' => t('News Banner Detail'),
    '#open' => TRUE,
  ];
  $form['header_settings']['news_default']['news_default_image'] = array(
    '#title'        => t('Upload Background'),
    '#type'         => 'managed_file',
    '#description'  => t('Images must be one of jpg, bmp, gif or png formats.'),
    '#default_value' => theme_get_setting('news_default_image'),
    '#upload_location' => 'public://',
    '#attributes' => array(
      'class' => array('form-input-inline')
    )
  );
  $form['header_settings']['news_default']['news_description'] = array(
    '#type' => 'textarea',
    '#resizable' => FALSE,
    '#rows' => 5,
    '#default_value' => theme_get_setting('news_description') ? theme_get_setting('news_description') : t('<h2>Insights</h2>'),
  );
}