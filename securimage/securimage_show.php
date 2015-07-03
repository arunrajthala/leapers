<?php

include 'securimage.php';
$options = array(
	                 'captcha_type' => Securimage::SI_CAPTCHA_MATHEMATIC /* use math captcha */,
	);
$img = new securimage($options);

$img->show(); // alternate use:  $img->show('/path/to/background.jpg');

?>
