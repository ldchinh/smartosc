<?php
	$list_department = array();
	foreach ($data as $key =>$item) {
		$list_department['items'][] = l($item[0] . ' (' . $item[1] . ')','taxonomy/term/'.$key, array('attributes' => array('class' => array('sidebar','right-link', 'carrer-detail-sidebar-link'), 'alt' =>$item[0])));
	}
?>

<div class="links-list">
	<?php print theme('item_list', $list_department); ?>
</div>
