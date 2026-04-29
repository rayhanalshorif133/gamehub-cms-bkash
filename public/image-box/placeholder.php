<?php
$size = isset($_GET['size']) ? intval($_GET['size']) : 15;
$color = isset($_GET['color']) ? $_GET['color'] : '000000';

// Validate color
$color = ltrim($color, '#');
if (!preg_match('/^[0-9a-fA-F]{6}$/', $color)) {
    $color = '000000';
}

// Convert hex to RGB
$R = hexdec(substr($color, 0, 2));
$G = hexdec(substr($color, 2, 2));
$B = hexdec(substr($color, 4, 2));

// Create image
$img = imagecreatetruecolor($size, $size);

// Allocate color
$bg = imagecolorallocate($img, $R, $G, $B);
imagefill($img, 0, 0, $bg);

// Output PNG
header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
exit;
?>
