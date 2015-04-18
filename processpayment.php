<?php
$ROOT = __DIR__;
require $ROOT.'/app.php';
require $ROOT.'/models/User.php';
require_once $ROOT.'/models/Payment.php';
require $ROOT.'/components/auth.php';

use \Models\User as users;
use \Models\Payment as payments;
use \Components\Auth as auth;

// Do some checks to make sure they should be on this page
auth\requireLogin();

/*
 * Process the response from paypal and save the payment details
 */

try {
    $status = 'success';

    // Make sure the response is valid
    if (!isset($_GET['tx']) || $_GET['st'] !== "Completed" || !isset($_GET['tx']) || !isset($_GET['amt']) || !isset($_GET['item_number'])) {
        throw new Exception("Invalid response from paypal");
    }

    $token = $_GET['tx'];
    $amount = $_GET['amt'];

    // Look up the product code and make sure that it is valid
    $typeid = payments\getTypeIdByCode($_GET['item_number']);

    // Get the current user to assign the payment
    $currUser = users\getCurrentUser();

    // Populate the payment details
    $newPayment = new payments\Payment();
    $newPayment->uid = $currUser->id;
    $newPayment->typeid = $typeid;
    $newPayment->amount = $amount;
    $newPayment->token = $token;
    // Save the new payment
    $newPayment->save();

    // Make sure the payment was created successfully
    //if (!isset($newPayment->id)) {
      //  throw new Exception("Error saving payment details");
    //}

    // Show the confirmation message
} catch (Exception $e) {
    error_log($e->getMessage());
    $status = 'fail';
}


header('Location: /finishpayment.php?status='.$status);
