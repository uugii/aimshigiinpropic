<?php
// šđžčć - keep utf-8 encoding
/**
* Femina Portal - Love Calculator Facebook application
* Config file with constants needed for Facebook app
* 
* LICENSE: This source file is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License 3
* as published by the Free Software Foundation.
*
* @author     INFORBIRO - Information Technology and Marketing Agency (www.inforbiro.com) <office@inforbiro.com>
* @copyright  Femina Portal - Female Internet Portal (www.FeminaPortal.com) <info@feminaportal.com>
* @license    GNU General Public License 3, see gpl_license_v3.0.txt
* @link       http://www.inforbiro.com; http://www.feminaportal.com
* @demo       http://apps.facebook.com/fp-love-calculator/
* @source       http://www.inforbiro.com/blog-eng/free-viral-facebook-application-with-step-by-step-tutorial/


*include_once ('lib/facebook.php'); // Facebook client library
*include_once ('config.php'); // Config file
 */
require_once "facebook.php";
 
$appapikey = "563804056997004";
$appsecret = "50fe395ded06af9a3f0f2e55879fa106";
 
$facebook = new Facebook($appapikey, $appsecret);
 
$user_id = $facebook->require_login();
 
$my_array = $facebook->api_client->users_getInfo($user_id,"first_name,pic_big");
 
// getting user name and profile picture
$text = $my_array[0][first_name];
$pic = $my_array[0][pic_big];
 
// core function: creation of the horror picture
create_pic($user_id,$text,$pic);
 
$has_permission = $facebook->api_client->users_hasAppPermission("photo_upload");
 
if($has_permission and $_GET[pub]){
    $response_array = $facebook->api_client->photos_upload("temp/".$user_id.".jpg", "", "Та энэ Application-ийг туршиж үзэхийг хүсвэл энэ хаягаар зочилно уу~!---> http://apps.facebook.com/aimshigiinpropic", $user_id);
}
 
?>




/**
* Function generates random number between 1 and 100 for passed names
*
* @param string $firstName
* @param string $secondName
* @return int Random number between 1 and 100
*/




<?php
 
// this is the core function.
// giving an user id, a text (user first name) and an url (path to the user profile picture)
// creates the horror picture
 
function create_pic($id,$text,$url){
    
    // creation of a new image, the final one
    $im = imagecreatetruecolor(500,500);
    // importing profile picture
    $profile = imagecreatefromjpeg($url);
    // importing transparent mirror image
    $mirror = imagecreatefrompng("mirror.png");
    
    // retrieving profile picture size
    $sizes = getimagesize($url);
    
    $x_dim = $sizes[0];
    $y_dim = $sizes[1];
    
    // mirror transparency is 265x335, so I resize the profile picture
    // to fit this size, keeping widht/height ratio
    if($x_dim<265 or $y_dim<335){
        $mult = max(265/$x_dim,335/$y_dim);
        $final_x = $x_dim*$mult;
        $final_y = $y_dim*$mult;
    }
    
    // pasting the resized profile picture on the final image
    imagecopyresampled($im,$profile,250-$final_x/2,300-$final_y/2,0,0,$final_x,$final_y,$x_dim,$y_dim);
    // pasting the mirror on the final image
    imagecopyresampled($im,$mirror,0,0,0,0,500,500,500,500);
    
    // creating some colors
    $color = imagecolorallocate($im, 125, 0, 0);
    $shadow = imagecolorallocate($im, 0, 0, 0);
    
    // this is the path of the font I am using
    $font = "SF Gushing Meadow.ttf";
    
    // starting at font size 0
    $size = 0;
    // boolean variable to determine if the font fits on the picture
    $it_fits = true;
    // increasing font zize by one unit until it won't fit anymore
    do{
         $last_dim = $dim;
         $size++;
         $dim = imageftbbox($size, 0, $font, $text);
         if($dim[4]-$dim[6]>500){
              $it_fits=false;
         }
    } while($it_fits);
    
    // adding the text
    $center = floor((500-$last_dim[4]+$last_dim[6])/2);
    imagettftext($im, $size-1, 0, $center, $last_dim[7]*-1+10, $shadow, $font, $text);
    imagettftext($im, $size-1, 0, $center-1, $last_dim[7]*-1+9, $color, $font, $text);
    
    // saving the image
    imagejpeg($im,"temp/".$id.".jpg",80);
    // freeing memory
    imagedestroy($im);
    imagedestroy($profile);
    imagedestroy($mirror);
}
 
?>
<script>
     function grant() {
         document.setLocation("http://apps.facebook.com/aimshigiinpropic/?pub=1");
     }
</script>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<style>
     <?php echo htmlentities(file_get_contents("style.css", true)); ?>
</style>	
<h2><fb:name uid="<?php echo $user_id; ?>" useyou="false" linked="false" firstnameonly="true"></fb:name> та өөрийнхөө аймшигийн профайл зураг чинь:</h2>
<ul>
    <li><a href = "http://www.facebook.com/anisanMedremj/" target = "_blank">Анисан Мэдрэмж хуудсаар зочлохоо мартуузай~!</a></li>
</ul>

</html>
