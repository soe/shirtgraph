<?php

$pics = explode(',', $_POST['pics']);

if($_POST['order'])	
	$order = explode(',', str_replace(array('listItem[]=', '&'), array('', ','), $_POST['order']));
else
	$order = range(0, $t['count']-1);


$montage_image = imagecreatetruecolor(1400,1400);
$white = imagecolorallocate($montage_image,255,255,255);
$black = imagecolorallocate($montage_image,0,0,0);

imagealphablending($montage_image, false);
$col = imagecolorallocatealpha($montage_image,255,255,255,127);
imagefilledrectangle($montage_image,0,0,1400,1400,$col);
imagealphablending($montage_image,true);

$x_index = 0;
$y_index = 0;

$images = array();

foreach($order as $o) {
	$images[] = $pics[$o];
}

for($i=0; $i<count($t); $i++) {
    $p = $t[$i];

	if(!$images[$i]) continue;
	
    $current_image = imagecreatefromjpeg($images[$i]);
    
    // Get new sizes
    list($width, $height) = getimagesize($images[$i]);
    if($width != $p[2]) {
        $current_image_r = imagecreatetruecolor($p[2], $p[3]);
        // Resize
        imagecopyresized($current_image_r, $current_image, 0, 0, 0, 0, $p[2], $p[3], $width, $height); 
        $current_image = $current_image_r;
    }

    imagecopymerge($montage_image, $current_image, $p[0], $p[1], 0, 0, $p[2], $p[3], 100);
    imagealphablending($montage_image,true);
    imagedestroy($current_image);
}


imagealphablending($montage_image, false);
imagesavealpha($montage_image, true);

//header("content-type: image/png");
//imagepng($montage_image, null, 100);

$image_name = uniqid();
imagepng($montage_image, './shirts/'.$image_name.'.png');
imagedestroy($montage_image);

?>

<html>
<head>
	<title>ShirtGraph - wear your memories</title>
	<link rel="stylesheet" href="./css/style.css" type="text/css" />
	<!--<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-8229911-5']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>-->
    <style type="text/css">
    body, div, p, td, form, input, select, textarea {
        font: 12px Helvetica, Verdana, Arial, sans-serif;
    }

    .appearanceSelector {
        margin: 4px;
        border: black solid 2px;
        float: left;
        width: 22px;
        height: 18px;
        color: black;
        cursor: pointer;
    }

    .sizeSelector {
        margin: 4px;
        border: black solid 2px;
        float: left;
        width: 40px;
        height: 24px;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
        cursor: pointer;
    }

    .price {
        position:absolute;
        right: 10px;
        top: 0px;
        font-size: 38px;
        font-weight: bold;
    }

    .selected {
        border-color: orange;
        color: orange;
    }

    .disabled {
        background-color: lightgray;
        cursor: default;
    }

    .sizes {
        position: absolute;
        top: 5px;
        left: 280px;
        width: 200px;
    }

    .appearances {
        position: absolute;
        top: 5px;
        left: 10px;
        width: 250px;
    }

    .menu {
        position:absolute;
        margin-top: 500px;
        width: 680px;
        height: 100px;
        border-top: 2px solid black;
        border-bottom: 1px solid black;
    }

    .designer {
        position:absolute;
    }

    .application {
        position: absolute;
        width: 680px;
        height: 610px;
		margin-top: 0;
     }

    .submitButton {
        right: 10px;
        bottom: 10px;
        width: 150px;
        position: absolute;
        background-color: orange;
        color: white;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }
    </style>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/feedreader.js"></script>
    <script type="text/javascript" src="js/ext/raphael.js"></script>
    <script type="text/javascript" src="js/simplomat.js"></script>
    <script type="text/javascript" src="js/spreadshirtapi.js"></script>
    <script type="text/javascript" src="js/ext/Anzeigen_400.font.js"></script>
    <script>
        var spreadshirtAPI = null;
        var simplomat = null;
        var currentSize = null;
        var currentAppearance = null;
        var design = null;
        var synchronized = false;
        var initId = null;

        window.onload = function () {
            spreadshirtAPI = new SpreadshirtAPI("eu", "349431", true);
            simplomat = new Simplomat();
            simplomat.initCallback = function() {
                $("#sizes").html("");
                for (var i = 0; i < this.product.sizes.length; i++) {
                    var size = this.product.sizes[i];
                    var availableSizes = this.product.getAvailableSizes();
                    var available = false;
                    for (var j = 0; j < availableSizes.length; j++) {
                        if (availableSizes[j] == size.id) {
                            available = true;
                            break;
                        }
                    }
                    var onclick = "";
                    var state = "";
                    if (available) {
                        onclick = "javascript:simplomat.product.changeSize('" +  size.id + "')";
                    } else {
                       state = " disabled";
                    }
                    $("#sizes").append("<div id=\"size_" + size.id + "\" class=\"sizeSelector " + state + "\" onclick=\"" + onclick + "\">" + size.name + "</div>");
                }
                $("#appearances").html("");
                for (var i = 0; i < this.product.appearances.length; i++) {
                    var appearance = this.product.appearances[i];
                    $("#appearances").append("<img id=\"appearance_" + appearance.id + "\" class=\"appearanceSelector\" onclick=\"javascript:simplomat.product.changeAppearance('" +  appearance.id + "')\" src=\"" + appearance.imageUrl + "\" width=\"30\" height=\"30\"/>");
                }
                currentAppearance = simplomat.product.appearanceId;
                $('#appearance_' + currentAppearance).addClass('selected');
            };
            simplomat.priceChangedCallback = function() {
                $("#price").html(this.product.getFormatedPrice());
            };
            simplomat.sizeChangedCallback = function() {
                if (currentSize != null)
                    $('#size_' + currentSize).removeClass('selected');
                currentSize = simplomat.product.sizeId;
                $('#size_' + currentSize).addClass('selected');
            };
            simplomat.appearanceChangedCallback = function() {
                if (currentAppearance != null)
                    $('#appearance_' + currentAppearance).removeClass('selected');
                currentAppearance = simplomat.product.appearanceId;
                $('#appearance_' + currentAppearance).addClass('selected');

                $("#sizes").html("");
                for (var i = 0; i < this.product.sizes.length; i++) {
                    var size = this.product.sizes[i];
                    var availableSizes = this.product.getAvailableSizes();
                    var available = false;
                    for (var j = 0; j < availableSizes.length; j++) {
                        if (availableSizes[j] == size.id) {
                            available = true;
                            break;
                        }
                    }
                    var onclick = "";
                    var state = "";
                    if (available) {
                        onclick = "javascript:simplomat.product.changeSize('" +  size.id + "')";
                    } else {
                       state = " disabled";
                    }
                    $("#sizes").append("<div id=\"size_" + size.id + "\" class=\"sizeSelector " + state + "\" onclick=\"" + onclick + "\">" + size.name + "</div>");
                }
                if (currentSize != null && $('#size_' + currentSize) != null)
                    $('#size_' + currentSize).addClass('selected');
            };
            simplomat.errorCallback = function(errorCode, errorMessage) {
                alert(errorMessage);
            };
            simplomat.init("designer", 660, spreadshirtAPI, false, false, null, "6", "1", null, "digi", 10, -35, 680, 500);

            simplomat.product.currentView.addDesign("shirts/<?= $image_name ?>.png", null, true);

            setTimeout(function () {
                for (i in simplomat) {
                    simplomat.R.safari();
                }
            });
        };
    </script>
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
	<div id="content" style="height: 660px;">
	<a name="app"></a>	
		<form id="form_final" action="?step=3" method="POST">
			<input type="hidden" name="step" value="3" />
			<input type="hidden" name="pics" id="pics" value="<?php echo $_POST['pics']; ?>" />
			<input type="hidden" name="t" value="<?= $tR ?>" />
			<input type="submit" value="Back" style="color: #444; text-decoration: underline; background: #ddd; border: 1px solid #eee; padding: 6px 28px; font-size: 114%;cursor:hand;"/>
		</form>
	<div class="application">
	    <div style="position: absolute; right: 50px; height: 50px; width: 41px;">
			<img src="img/spreadshirt_logo.jpg" alt="Spreadshirt Logo" style="height: 100px; width: 82px;"/>
		</div>
	    <div id="designer" class="designer">&nbsp;</div>
	    <div class="menu">
	        <form action="javascript:simplomat.createProductAndCheckout();">
	            <div id="appearances" class="appearances"></div>
	            <div id="sizes" class="sizes"></div>
	            <div id="price" class="price">0,00</div>
	            <input class="submitButton" type="button" name="Buy Now!" value="Buy Now!" onclick="javascript:simplomat.createProductAndCheckout();"/>
	        </form>
	    </div>
		<div style="clear: both;"></div>
	</div>
	