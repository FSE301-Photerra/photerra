<?php namespace Components\Utilities;
/**
 * Simple library of utilty functions that will be reused throughout the project
 */

/**
 * Accepts a photo object and attempts to upload the photo to the server. Will return a response of 
 * false on error.
 * @todo add validation to image upload
 * @param mixed $photo
 * @param string $photoField
 * @returns bool
 */
function uploadImageFile($photo, $photoField) {
    $uploadStatus = 1;
    $target_dir = __DIR__ . '/../pictures';

    try {
        // Make sure the target directory exists, if not then create it
        if (!file_exists(__DIR__ . '/..' . $target_dir)) {
            mkdir(__DIR__ . '/..' . $target_dir, 0700);
        }

        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (
            !isset($_FILES[$photoField]['error']) ||
            is_array($_FILES[$photoField]['error'])
        ) {
            throw new \RuntimeException('Invalid parameters.');
        }

        // Check $_FILES[$photoField]['error'] value.
        switch ($_FILES[$photoField]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \RuntimeException('Exceeded filesize limit.');
            default:
                throw new \RuntimeException('Unknown errors.');
        }

        // You should also check filesize here. 
        if ($_FILES[$photoField]['size'] > 2000000) {
            throw new \RuntimeException('Exceeded filesize limit.');
        }

        // DO NOT TRUST $_FILES[$photoField]['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES[$photoField]['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            throw new \RuntimeException('Invalid file format.');
        }

        // set the photos filename
        $photo->filename = sha1_file($_FILES[$photoField]['tmp_name']) . '.' . $ext;

        // You should name it uniquely.
        // DO NOT USE $_FILES[$photoField]['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        if (!move_uploaded_file(
            $_FILES[$photoField]['tmp_name'],
            sprintf('%s/%s',
                $target_dir,
                $photo->filename
            )
        )) {
            throw new \RuntimeException('Failed to move uploaded file.'.$asdf);
        }

    } catch (\RuntimeException $e) {
        error_log($e->getMessage());
        $uploadStatus = 0;

    }

    return $uploadStatus;
}
