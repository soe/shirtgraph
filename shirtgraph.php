<?php

function shirtgraph() {
	$step = $_REQUEST['step'];
	if(!$step) $step = 0;

	rHeader($step);

	rFooter($step);	
}

function rHeader($step = 1) {
	?>
	<html>
	<head>
		<title>ShirtGraph - wear your memories</title>
		<link rel="stylesheet" href="./css/style.css" type="text/css" />
	<?php if($step) { ?>
		<script src="js/jquery-1.5.1.min.js" type="text/javascript"></script> 
		<script src="js/jquery-ui-1.8.11.custom.min.js" type="text/javascript"></script> 
		<script src="js/jquery.ui.swappable.js" type="text/javascript"></script>
	<?php } ?>
	</head>
		
	<body>		
		<div id="container">	
			<div id="header">
				<a href="http://shirtgraph.com/index.php" id="header"><h1>ShirtGraph
					<span style="font-size: 80%; color: #ffe27f; font-weight: normal; font-style: italic;">
						- Wear your memories...
					</span>
				</h1></a>
				<?php rNavigation($step); ?>
			</div>
	
	<div id="wrapper">
		<div id="content">
	<?php
	
}

function rFooter($step = 1) {
	?>
		</div>
	</div>
	<div id="footer">
		<a href="http://spreadshirt.com" target="_blank">Powered by SpreadShirt</a>
		<a href="mailto:shirtgraph@gmail.com" style="float: right;">Contact</a>
		<div class="clear"></div>
	</div>
	<br /><br />
	</div>
	</body></html>
	<?php
}

function rNavigation($step = 1) {
	if(!$step) return;
	?>
	<div id="navigation">
		<a href="http://shirtgraph.com/index.php?step=1"><div id="<?php if($step == 1) echo 'selected'; ?>">
			Step 1
			<br /><span>Choose a shirt design</span>
		</div></a>
		<div id="<?php if($step == 2) echo 'selected'; ?>">
			Step 2
			<br /><span>Choose photos</span>
		</div>
		<div id="<?php if($step == 3) echo 'selected'; ?>">
			Step 3
			<br /><span>Arrange your photos</span>
		</div>	
		<div id="<?php if($step == 4) echo 'selected'; ?>">
			Step 4
			<br /><span>Finalize your shirt</span>
		</div>
	</div>
	<?php
}

?>