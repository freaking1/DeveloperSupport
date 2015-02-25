<?
function drawRating($rating) {
   $width = $_GET['width'];
   $height = $_GET['height'];
   if ($width == 0) {
     $width = 102;
   }
   if ($height == 0) {
     $height = 10;
   }

   $rating = $_GET['rating'];
   $ratingbar = (($rating/100)*$width)-2;

   $image = imagecreate($width,$height);
   //colors
   $back = ImageColorAllocate($image,255,255,255);
   $border = ImageColorAllocate($image,0,0,0);
   $red = ImageColorAllocate($image,255,60,75);
   $fill = ImageColorAllocate($image,44,81,150);

   ImageFilledRectangle($image,0,0,$width-1,$height-1,$back);
   ImageFilledRectangle($image,1,1,$ratingbar,$height-1,$fill);
   ImageRectangle($image,0,0,$width-1,$height-1,$border);
   imagePNG($image);
   imagedestroy($image);
}

Header("Content-type: image/png");
drawRating($rating);

?>