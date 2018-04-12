<?php
$pre = $data['pre'] ? $data['pre'] : $data['rand'];
$next = $data['next'] ? $data['next'] : $data['rand'];
?>
<div class="port-pager">
	<a class="csm-prev csm-button" href="<?php print url('node/'.$pre, array('absolute'=>TRUE))?>"><i class="fa fa-angle-left"></i></a>
	<a href="<?php print url('work', array('absolute'=>TRUE));?>"><p><?php print t('Show all our work')?></p></a>
	<a class="csm-next csm-button" href="<?php print url('node/'.$next, array('absolute'=>TRUE))?>"><i class="fa fa-angle-right"></i></a>
</div>