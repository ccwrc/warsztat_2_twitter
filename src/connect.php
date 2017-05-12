<?php

function getDbConnection() {
    $dbServer = "localhost";
    $dbUsername = "las";
    $dbPassword = "tajnehaslo";
    $dbName = "las";

    $conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
    $conn->query("SET CHARSET UTF8");

    if ($conn->connect_error) {
        die("Brak połączenia z bazą danych, błąd: " . $conn->errno);
    }

    return $conn;
}
