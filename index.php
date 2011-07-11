<?php

require_once('shirtgraph.php');
require_once('config.php');

$step = (int) $_REQUEST['step'];
if(!$step) $step = 0;

$tR = (int) $_REQUEST['t'];

if($step) {
	session_start();

	require_once('lib/Instagram.php');

	// Instantiate the API handler object
	$instagram = new Instagram($instagram_config);
	$instagram->setAccessToken($_SESSION['InstagramAccessToken']);
}
// templates
$templates = array();

// array(x, y, width, height) - configure layout and position for photos
$templates[1] = array('id' => 1, 'name' => '1', 'row' => 1, 'col' => 1);
$templates[1][0] = array(410, 180, 580, 580);


$templates[2] = array('id' => 3, 'name' => '2', 'row' => 1, 'col' => 2);
$templates[2][0] = array(240, 180, 450, 450);
$templates[2][1] = array(710, 180, 450, 450);

$templates[3] = array('id' => 3, 'name' => '3', 'row' => 1, 'col' => 3);
$templates[3][0] = array(180, 200, 320, 320);
$templates[3][1] = array(540, 200, 320, 320);
$templates[3][2] = array(900, 200, 320, 320);

$templates[4] = array('id' => 4, 'name' => '4', 'row' => 1, 'col' => 4);
$templates[4][0] = array(160, 200, 250, 250);
$templates[4][1] = array(440, 200, 250, 250);
$templates[4][2] = array(720, 200, 250, 250);
$templates[4][3] = array(1000, 200, 250, 250);

$templates[5] = array('id' => 5, 'name' => '5', 'row' => 1, 'col' => 5);
$templates[5][0] = array(120, 200, 220, 220);
$templates[5][1] = array(360, 200, 220, 220);
$templates[5][2] = array(600, 200, 220, 220);
$templates[5][3] = array(840, 200, 220, 220);
$templates[5][4] = array(1080, 200, 220, 220);

$templates[6] = array('id' => 1, 'name' => '1', 'row' => 2, 'col' => 1);
$templates[6][0] = array(450, 180, 500, 500);

$templates[6][0] = array(450, 700, 500, 500);

$templates[7] = array('id' => 3, 'name' => '2', 'row' => 2, 'col' => 2);
$templates[7][0] = array(250, 180, 440, 440);
$templates[7][1] = array(710, 180, 440, 440);

$templates[7][2] = array(250, 640, 440, 440);
$templates[7][3] = array(710, 640, 440, 440);

$templates[8] = array('id' => 3, 'name' => '3', 'row' => 2, 'col' => 3);
$templates[8][0] = array(180, 200, 320, 320);
$templates[8][1] = array(540, 200, 320, 320);
$templates[8][2] = array(900, 200, 320, 320);

$templates[8][3] = array(180, 540, 320, 320);
$templates[8][4] = array(540, 540, 320, 320);
$templates[8][5] = array(900, 540, 320, 320);

$templates[9] = array('id' => 4, 'name' => '4', 'row' => 2, 'col' => 4);
$templates[9][0] = array(160, 200, 250, 250);
$templates[9][1] = array(440, 200, 250, 250);
$templates[9][2] = array(720, 200, 250, 250);
$templates[9][3] = array(1000, 200, 250, 250);

$templates[9][4] = array(160, 470, 250, 250);
$templates[9][5] = array(440, 470, 250, 250);
$templates[9][6] = array(720, 470, 250, 250);
$templates[9][7] = array(1000, 470, 250, 250);

$templates[10] = array('id' => 5, 'name' => '5', 'row' => 2, 'col' => 5);
$templates[10][0] = array(120, 200, 220, 220);
$templates[10][1] = array(360, 200, 220, 220);
$templates[10][2] = array(600, 200, 220, 220);
$templates[10][3] = array(840, 200, 220, 220);
$templates[10][4] = array(1080, 200, 220, 220);

$templates[10][5] = array(120, 460, 220, 220);
$templates[10][6] = array(360, 460, 220, 220);
$templates[10][7] = array(600, 460, 220, 220);
$templates[10][8] = array(840, 460, 220, 220);
$templates[10][9] = array(1080, 460, 220, 220);

$t = $templates[$tR];
$t['count']= $t['row'] * $t['col'];

if($step != 4) rHeader($step);

switch ($step) {
    case 0:
        require_once('step_start.php');
        break;
    case 1:
        require_once('step_shirts.php');
        break;
    case 2:
        require_once('step_pics.php');
        break;
    case 3:
        require_once('step_sort.php');
        break;
    case 4:
        require_once('step_final.php');
        break;
}

rFooter($step);

?>