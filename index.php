<?php
/*
	KORAY KIRCAOGLU
	OhShiftLabs.com
*/
function readGPSinfoEXIF($image_full_name)
{
   $exif=exif_read_data($image_full_name, NULL, true);
   if(!isset($exif['GPS']['GPSLatitude'])){
	   return false;
   }elseif(!$exif || $exif['GPS']['GPSLatitude'] == '') {
       return false;
   } else {
	$lat_ref = $exif['GPS']['GPSLatitudeRef']; 
	$lat = $exif['GPS']['GPSLatitude'];
	list($num, $dec) = explode('/', $lat[0]);
		$lat_s = $num / $dec;
	list($num, $dec) = explode('/', $lat[1]);
		$lat_m = $num / $dec;
	list($num, $dec) = explode('/', $lat[2]);
		$lat_v = $num / $dec;
 
	$lon_ref = $exif['GPS']['GPSLongitudeRef'];
	$lon = $exif['GPS']['GPSLongitude'];
	list($num, $dec) = explode('/', $lon[0]);
		$lon_s = $num / $dec;
	list($num, $dec) = explode('/', $lon[1]);
		$lon_m = $num / $dec;
	list($num, $dec) = explode('/', $lon[2]);
		$lon_v = $num / $dec;
 
	$gps_int = array($lat_s + $lat_m / 60.0 + $lat_v / 3600.0, $lon_s + $lon_m / 60.0 + $lon_v / 3600.0);
	return $gps_int;
	}
}

function gmap($data){
	if(!is_array($data)) $data = array(1,1);
	$imgurl = "http://maps.google.com/maps/api/staticmap?center=".$data[0].",".$data[1];
	$imgurl.="&zoom=17&size=400x400&maptype=hybrid&sensor=false";
	$imgurl.="&markers=color:blue%7Clabel:x%7C".$data[0].",".$data[1];
	return $imgurl;
}


?>
<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OhShiftLabs</title>
<meta http-equiv="Content-Language" content="tr">
<meta name="description" content="OhShiftLabs IMG GPS Data Extractor">
<meta name="keywords" content="OhShiftLabs">
<style>
body {
	font-family:Helvetica,Arial;
	background: rgb(242,245,246);
	background: -moz-linear-gradient(top, rgba(242,245,246,1) 0%, rgba(227,234,237,1) 37%, rgba(200,215,220,1) 100%); 	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(242,245,246,1)), color-stop(37%,rgba(227,234,237,1)), color-stop(100%,rgba(200,215,220,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(242,245,246,1) 0%,rgba(227,234,237,1) 37%,rgba(200,215,220,1) 100%); 	background: -o-linear-gradient(top, rgba(242,245,246,1) 0%,rgba(227,234,237,1) 37%,rgba(200,215,220,1) 100%);
	background: linear-gradient(to bottom, rgba(242,245,246,1) 0%,rgba(227,234,237,1) 37%,rgba(200,215,220,1) 100%); 	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f5f6', endColorstr='#c8d7dc',GradientType=0 );
}
</style>
</head>
<body>
<div class="main" id="main">
	<div style="float:right">GPS Data Extractor <a href="http://www.ohshiftlabs.com/">OhShift</a><br> To read GPS info, php exif must be installed/activated.</div>
	<h1>Images in 'imgs' folder</h1>
	<?php
	$directory = "imgs/"; 
	$images = glob($directory . "*.jpg");
 
 	foreach($images as $image)
	{
		echo '<img src="'.$image.'" height="400" border="0" />';
		echo '<img src="'.gmap(readGPSinfoEXIF($image)).'" border="0" alt="" />';
		echo "<br/>";
	}
		
	?>
</div>
</body>
</html>