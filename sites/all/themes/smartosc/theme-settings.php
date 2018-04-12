<?php
require_once dirname(__FILE__) . '/inc/theme-settings-top.inc';
require_once dirname(__FILE__) . '/inc/theme-settings-header.inc';
require_once dirname(__FILE__) . '/inc/theme-settings-general.inc';
function smartosc_form_system_theme_settings_alter(&$form,&$form_state,$form_id = NULL) {
  smartosc_theme_settings_top($form,$form_state);
  smartosc_theme_settings_header($form,$form_state);
  smartosc_theme_settings_general($form,$form_state);
}