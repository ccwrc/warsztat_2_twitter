<?php

function getDbConnection() {
    $DB_SERVER = "localhost";
    $DB_USERNAME = "las";
    $DB_PASSWORD = "tajnehaslo";
    $DB_DATABASE = "las";

    $conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);

    if ($conn->connect_error) {
       die("Brak połączenia z bazą danych, błąd: " . $conn->errno);
    }

    $setEncodingSql = "SET CHARSET utf8"; //poprawne zwracanie pl znakow
    $conn->query($setEncodingSql);

    return $conn; //pamietac o zamknieciu po kazdej operacji (close+null)
}

?>

