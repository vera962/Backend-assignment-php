<?php

class Image{
public function fetchingImage(){

    // URL of the image you want to fetch
    $imageUrl = 'https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg'; 
    $localFilePath = 'C:\Program Files\Ampps\www\backendAssignmentPhp\resources\image.jpg';
    
    // Use file_get_contents() to fetch the image data from the URL
    $imageData = file_get_contents($imageUrl);
    
    // if ($imageData !== false) {
    //     // Use file_put_contents() to save the image data to a local file
    //     if (file_put_contents($localFilePath, $imageData) !== false) {
    //         echo "Image saved successfully to $localFilePath";
    //     } else {
    //         echo "Failed to save the image to $localFilePath";
    //     }
    // } else {
    //     echo "Failed to fetch image data from $imageUrl";
    // }
}
}

$image = new Image();
$image->fetchingImage();

?>