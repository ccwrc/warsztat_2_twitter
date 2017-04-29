<?php

// testowo uzyta w logon.php i messages.php
function checkNewMessages($userId, mysqli $conn) {
    $userId = $conn->real_escape_string($userId);
    
    if (!is_numeric($userId)) {
        return 0;
    }
    
    $sqlMessage = "SELECT * FROM message WHERE message_receiver_id ="
            . " $userId && message_read = 0 && message_receiver_visible = 0";
    $resultMessage = $conn->query($sqlMessage);
    if ($resultMessage->num_rows >= 1) {
        return $resultMessage->num_rows;
    }
    return 0;
}
