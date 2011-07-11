<script type="text/javascript">	
	function select_pic(pic) {	
		// check max pic
		if($('#max_pic').html() == $(".pic.selected").size() && $(pic).attr('class') == 'pic') {
			alert('Sorry, maximum number of selected photos has reached.');
		} else {
			$(pic).children(".tick").toggle();
			$(pic).toggleClass('selected');
			$('#min_pic').text($(".pic.selected").size());
		}
	}
	
	function submit_pics() {
		var pics = [];
		$(".pic.selected").each(function(index) {
			pics.push($(this).children("img").attr('src'));
		});
		$("#form_pics #pics").val(pics.toString());
		$("#form_pics").submit();		
	}
</script>
<?php
$pics = $instagram->getUserFeed();

// After getting the response, let's iterate the payload
$response = json_decode($pics, true);
?>
<div id="lr">
	<a href="#" class="next" onclick="submit_pics();">Submit</a>
	<a href="?step=1" class="back" onclick="">Back</a>
	<div id="center">
		<span id="min_pic">0</span><span> of </span><span id="max_pic"><?php echo $t['count']; ?></span><span> images selected</span>
	</div>
</div>
<div style="clear: both;"></div>

<form id="form_pics" action="?step=3" method="POST">
	<input type="hidden" name="step" value="3" />
	<input type="hidden" name="pics" id="pics" value="" />
	<input type="hidden" name="t" value="<?= $tR ?>" />
</form>
<?php
foreach ($response['data'] as $data) {
    $link = $data['link'];
    $id = $data['id'];
    $caption = $data['caption']['text'];
    $author = $data['caption']['from']['username'];
    $thumbnail = $data['images']['thumbnail']['url'];
?>
<div class="pic" style="float: left;" id="<?= $id ?>" onclick="select_pic(this);">
    <img src="<?= $thumbnail ?>" title="<?= htmlentities($caption) ?>" alt="<?= htmlentities($caption) ?>" width="115" />
	<div class="tick">v</div>
</div>
<?php
}
?>
<div style="clear: both;"></div>
