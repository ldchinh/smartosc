<?php
function smartosc_theme_settings_top(&$form,&$form_state) {
	$form['head_settings'] = array(
		'#type' => 'fieldset',
		'#title' => t('Head')
	);

	// Google analytics
	$form['head_settings']['google_analytics'] = [
		'#type' => 'fieldset',
		'#title' => t('Google analytics'),
		'#open' => TRUE,
	];
	$form['head_settings']['google_analytics']['google_tracking_id'] = [
		'#type' => 'textfield',
		'#title' => t('Tracking ID'),
		'#description' => t("<a href='https://support.google.com/analytics/answer/1032385'>property ID</a> of the Google Analytics"),
		'#default_value' => theme_get_setting('google_tracking_id'),
		'#size' => 40
	];
	// Facebook Remarketing
	$form['head_settings']['facebook_remarketing'] = [
		'#type' => 'fieldset',
		'#title' => t('Facebook Remarketing'),
		'#open' => TRUE,
	];
	$form['head_settings']['facebook_remarketing']['facebook_pixel_id'] = [
		'#type' => 'textfield',
		'#title' => t('Facebook Pixel ID'),
		'#description' => t("<a href='https://developers.facebook.com/docs/ads-for-websites/website-custom-audiences/getting-started'>Custom Audience pixel</a> From Your Website "),
		'#default_value' => theme_get_setting('facebook_pixel_id'),
		'#size' => 40
	];
}