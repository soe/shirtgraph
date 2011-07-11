<?php 
for($i=1; $i<=count($templates); $i++) {
?>
<a href="?step=2&t=<?= $i ?>"><div class="pic" style="float: left;">
	<img src="images/t<?= $i ?>.png" width="115" />		
</div></a>
<?php
}
?>
<div style="clear: both;"></div>