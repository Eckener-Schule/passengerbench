<?php
echo '<pre>';

function getConfig() {
    return require("../config" . DIRECTORY_SEPARATOR . "config.php");
}

require_once('../classes/DBConnection.php');

$conn = DBConnection::getInstance();

$result = $conn->executeQueryPrepared('SELECT firstname, lastname, email, license_plate FROM person WHERE firstname LIKE ?', array('%e%'));
print_r($result);

echo '</pre>';