<?php namespace Models\Payment;
// Include the database if needed
require_once __DIR__ . '/../db.php';

class Payment {
    public $id;             // Unique id
    public $uid;            // assign payment to this user
    public $typeid;
    public $typeDesc;
    public $createdOn;

    /**
     * Saves a new payment
     */
    function save() {
        $query = sprintf("INSERT INTO Payments (uid, typeid)
                          VALUES (%u, %u)",
                         $this->uid, $this-typeid);

        $conn = \DB\getConnection();
        $result = $conn->query($query);
    }
}

/**
 * Gets a payment type id by the code. If there is no type that matches the code
 * provided, a zero is returned
 * @param string code
 * @return int
 */
function getTypeIdByCode($code) {
    $id = 0;

    // Run the query and get the user details
    $query = sprintf("SELECT id
                      FROM PaymentTypes
                      WHERE code = '%s'",
                     $code);

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    if ($result->num_rows) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
    }

    return $id;
}

/**
 * Gets the payment history of the given user
 * @param int uid
 * @return mixed
 */
function getByUser($uid) {
    // Run the query and get the user details
    $query = sprintf("SELECT p.id,
                             p.uid,
                             p.typeid,
                             p.createdOn,
                             pt.desc
                      FROM Payments p
                      INNER JOIN PaymentTypes pt ON pt.id = p.typeid
                      WHERE p.uid=%u
                      ORDER BY p.createdOn DESC",
                     $uid);

    $conn = \DB\getConnection();
    $result = $conn->query($query);

    return $result;
}

/**
 * Gets a count of the number of payments to increase upload limit
 * @param int uid
 * @return int
 */
function getCountByUser($uid) {
    $count = 0;

    // Run the query and get the user details
    $query = sprintf("SELECT COUNT(*) AS PaymentCount
                      FROM Payments
                      WHERE uid=%u
                        AND typeid = (
                            SELECT id
                            FROM PaymentTypes
                            WHERE code = 'il'
                        )",
                     $uid);

    $conn = \DB\getConnection();
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['PaymentCount'];

    return $count;
}
