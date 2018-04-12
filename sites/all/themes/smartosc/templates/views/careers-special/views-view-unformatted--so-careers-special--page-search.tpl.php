<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php //krumo($rows);
	$tree = taxonomy_get_tree(4);
  	$arr_tax = array();
  	$data = array();
  	$group =array();
  	foreach($tree as $term) {
  		$groups[$term->tid]['name'] = $term->name;
  		$groups[$term->tid]['data'] = array();
  		foreach ($rows as $id => $row) {
	  		if(strpos($row, '>' . $term->name . '</a>') !== false){
		  		$groups[$term->tid]['data'][] = str_replace('>' . $term->name . '</a>', '></a>', $row);
	  	
	  		}
  			
  		}
  	}
  	//echo '<pre>'; print_r($group);die;
  	
?>
<?php foreach ($groups as $id => $group): ?>
	<?php if(!empty($group['data'])) :?>
	<div class="career-group">
	  <div class="group-career-title"><?php print $group['name']?></div>
	  <div class="group-career-data">
		<?php foreach ($group['data'] as $data):?>
		    <?php print $data; ?>
		<?php endforeach;?>
	  </div>
  </div>
  <?php endif;?>
<?php endforeach; ?>