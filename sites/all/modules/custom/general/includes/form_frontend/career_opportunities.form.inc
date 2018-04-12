
<?php

/**************************************
 * Form career of page opportunities
 ***************************************/
function general_form_views_exposed_form_alter(&$form, &$form_state) {
	if( $_GET['q'] == 'career/opportunities') {
		$department = !empty($_GET['department']) ? $_GET['department']: '';
		$office =  !empty($_GET['office']) ? $_GET['office']: '';
		$options = career::getSearchOptions($department, $office);
		
		$old_department = $form['department']['#options'];
		$options['department']['All'] = t('All Departments');
		$department_options = array_intersect_key($old_department,$options['department']);
		$department_options['All'] = t('All Departments');
		$form['department']['#options'] = $department_options;
		
		$old_office = $form['office']['#options'];
		$options['office']['All'] = t('All Offices');
		$office_options = array_intersect_key($old_office,$options['office']);
		$office_options['All'] = t('All Offices');
		$form['office']['#options'] = $office_options;

    $form['submit']['#attributes']['class'][] = 'btn-md';
	}
}
/**
 * Implements hook_views_query_alter
 * Finds the correct view, and calls a relevant callback
 */
function general_views_query_alter(&$view, &$query) {
  switch($view->name) {
    case 'so_careers_special':
      if ($view->current_display == 'page_search') {
        $query->orderby[0]=array('field'=>'weight_weights_weight', 'direction'=> 'ASC');
        $query->orderby[1]=array('field'=>'node_created', 'direction'=> 'DESC');
        $query->fields['weight_weights_weight'] = array('field'=>'weight','table'=> 'weight_weights', 'alias'=>  'weight_weights_weight');
        $query->field_aliases['weight_weights'] = array('weight'=> 'weight_weights_weight');
        $query->tables['node']['weight_weights'] = array('count'=>1, 'alias'=>'weight_weights');
        $pjoin = new views_join();
        $pjoin->table = 'weight_weights';
        $pjoin->field = 'entity_id';
        $pjoin->left_table = 'node';
        $pjoin->left_field = 'nid';
        $pjoin->type = 'left';
        $pjoin->definition = array(
          'left_field' => 'nid',
          'field'	=>	'entity_id',
          'table' => 'weight_weights',
          'left_table' => 'node',
        );
        $pjoin->extra_type = 'AND';
        $pjoin->adjusted = 1;
        $query->table_queue['weight_weights'] = array(
          'table'=> 'weight_weights',
          'num'=>1,
          'alias' => 	'weight_weights',
          'join' => $pjoin,
        );
      }
      break;
  }
}