<?php namespace Components\Utilities;
/**
 * Simple library of utilty functions that will be reused throughout the project
 */

/**
 * Accepts a photo object and attempts to upload the photo to the server. Will return a response of 
 * false on error.
 * @todo add validation to image upload
 * @todo add more robust error handling
 * @param mixed $photo
 * @param string $photoField
 * @returns bool
 */
function uploadImageFile($photo, $photoField) {
    $uploadStatus = 1;
    $target_dir = "pictures/";
    $target_file = $target_dir . $photo->fileName ;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Make sure that the file is not empty
    $sizeCheck = getimagesize($_FILES[$photoField]["tmp_name"]);
    if(!$sizeCheck) {
        $uploadStatus = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadStatus = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadStatus = 0;
    }

    // Check the mime type and make sure that this is an image file
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadStatus = 0;
    }

    // If the file is ok, then upload it to the server and make sure everything went ok
    if ($uploadStatus && !move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploadStatus = 0;
    }

    return $uploadStatus;
}
