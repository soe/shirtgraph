<script type="text/javascript"> 
	$(document).ready(function() {
		$("#sort").swappable({
			items: '.item',
			cursorAt: {top:-10},
			update: function () {
				$('#order').val($('#sort').swappable('serialize'));
			}
		});		
	});
	function submit_sort() {
		$("#form_sort").submit();		
	}
</script>
<div id="lr">
	<a href="#" class="next" onclick="submit_sort();">Finalize</a>
	<a href="?step=2&t=<?= $tR ?>" class="back" onclick="">Back</a>
	<div id="center">
		<span>Position your photos per your preference</span>
	</div>
</div>
<div style="clear: both;"></div>
<form id="form_sort" action="?step=4#app" method="POST">
	<input type="hidden" name="step" value="4" />
	<input type="hidden" name="pics" id="pics" value="<?php echo $_POST['pics']; ?>" />
	<input type="hidden" name="order" id="order" value="" />
	<input type="hidden" name="t" value="<?= $tR ?>" />
</form>
<?php
$width = 144 * $t['col'];

$pics = explode(',', $_POST['pics']);
?>
<p><ul id="sort" style="margin:0 auto; width:<?php echo $width; ?>;"> 
	
<?php for($i=0; $i < $t['count']; $i++) { ?>
	<li id="listItem_<?php echo $i; ?>"  class="item" > 
		<div class="pic"><img src="<?php if(strlen($pics[$i])) echo $pics[$i]; else echo "images/blank.jpg"; ?>" width="115" height="115" class="handle"></div> 
	</li> 
<?php } ?>						

</ul></p>
<div style="clear:both;"></div>
<?php

?>