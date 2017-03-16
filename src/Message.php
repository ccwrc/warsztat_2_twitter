<?php

class Message {
    private $messageContent;
    private $messageCreationDate;
    private $messageId;
    private $messageRead;
    private $messageReceiverId;
    private $messageReceiverVisible;
    private $messageSenderId;
    private $messageSenderVisible;

    public function __construct() {
        $this->messageContent = "";
        $this->messageCreationDate = "";
        $this->messageId = -1;
        $this->messageRead = 0;
        $this->messageReceiverId = 0;
        $this->messageReceiverVisible = 0;
        $this->messageSenderId = 0;
        $this->messageSenderVisible = 0;
    }

    public function getMessageContent() {
        return $this->messageContent;
    }

    public function getMessageCreationdate() {
        return $this->messageCreationDate;
    }

    public function getMessageId() {
        return $this->messageId;
    }

    public function getMessageRead() {
        return $this->messageRead;
    }

    public function getMessageReceiverId() {
        return $this->messageReceiverId;
    }

    public function getMessageReceiverVisible() {
        return $this->messageReceiverVisible;
    }

    public function getMessageSenderId() {
        return $this->messageSenderId;
    }

    public function getMessageSenderVisible() {
        return $this->messageSenderVisible;
    }

    public function setMessageContent($messageContent) {
        if (is_string($messageContent) && (strlen($messageContent) <= 25000)) {
            $this->messageContent = $messageContent;
            return $this;
        } else {
            return false;
        }
    }

    public function setMessageCreationDate($messageDate) {
        if (DateTime::createFromFormat("Y-m-d H:i:s", $messageDate)) {
            $this->messageCreationDate = $messageDate;
        } else {
            return false;
        }
    }

    public function setMessageRead($isRead) {
        if ($isRead === 0 || $isRead === 1) {
            $this->messageRead = $isRead;
            return $this;
        } else {
            return false;
        }
    }

    public function setMessageReceiverId($messageReceiverId) {
        if (is_numeric($messageReceiverId) && $messageReceiverId > 0) {
            $this->messageReceiverId = $messageReceiverId;
            return $this;
        } else {
            return false;
        }
    }

    public function setMessageReceiverVisible($messageReceiverVisible) {
        if ($messageReceiverVisible === 0 || $messageReceiverVisible === 1) {
            $this->messageReceiverVisible = $messageReceiverVisible;
            return $this;
        } else {
            return false;
        }
    }

    public function setMessageSenderId($messageSenderId) {
        if (is_numeric($messageSenderId) && $messageSenderId > 0) {
            $this->messageSenderId = $messageSenderId;
            return $this;
        } else {
            return false;
        }
    }

    public function setMessageSenderVisible($messageSenderVisible) {
        if ($messageSenderVisible == 0 || $messageSenderVisible == 1) {
            $this->messageSenderVisible = $messageSenderVisible;
            return $this;
        } else {
            return false;
        }
    }

    static public function loadMessageById(mysqli $conn, $messageId) {
        $messageId = $conn->real_escape_string($messageId);
        $sql = "SELECT * FROM message WHERE message_id = $messageId";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedMessage = new Message();
            $loadedMessage->messageContent = $row['message_content'];
            $loadedMessage->messageCreationDate = $row['message_creation_date'];
            $loadedMessage->messageId = $row['message_id'];
            $loadedMessage->messageRead = $row['message_read'];
            $loadedMessage->messageReceiverId = $row['message_receiver_id'];
            $loadedMessage->messageReceiverVisible = $row['message_receiver_visible'];
            $loadedMessage->messageSenderId = $row['message_sender_id'];
            $loadedMessage->messageSenderVisible = $row['message_sender_visible'];

            return $loadedMessage;
        } else {
            return null;
        }
    }

    static public function loadAllMessagesBySenderId(mysqli $conn, $senderId) {
        $senderId = $conn->real_escape_string($senderId);
        $ret = [];
        $sql = "SELECT * FROM message WHERE message_sender_id = $senderId &&"
                . "message_sender_visible = 0";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->messageContent = $row['message_content'];
                $loadedMessage->messageCreationDate = $row['message_creation_date'];
                $loadedMessage->messageId = $row['message_id'];
                $loadedMessage->messageRead = $row['message_read'];
                $loadedMessage->messageReceiverId = $row['message_receiver_id'];
                $loadedMessage->messageReceiverVisible = $row['message_receiver_visible'];
                $loadedMessage->messageSenderId = $row['message_sender_id'];
                $loadedMessage->messageSenderVisible = $row['message_sender_visible'];
                $ret[$loadedMessage->messageId] = $loadedMessage;
            }
        }
        return $ret;
    }

    static public function loadAllCutMessagesBySenderId(mysqli $conn, $senderId) {
        $senderId = $conn->real_escape_string($senderId);
        $ret = [];
        $sql = "SELECT substring(message_content,1,30) as message_content, message_creation_date,"
                . "message_id, message_read, message_receiver_id, "
                . "message_receiver_visible, message_sender_id, "
                . "message_sender_visible FROM message WHERE message_sender_id = $senderId &&"
                . "message_sender_visible = 0 ORDER BY message_creation_date DESC";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->messageContent = $row['message_content'];
                $loadedMessage->messageCreationDate = $row['message_creation_date'];
                $loadedMessage->messageId = $row['message_id'];
                $loadedMessage->messageRead = $row['message_read'];
                $loadedMessage->messageReceiverId = $row['message_receiver_id'];
                $loadedMessage->messageReceiverVisible = $row['message_receiver_visible'];
                $loadedMessage->messageSenderId = $row['message_sender_id'];
                $loadedMessage->messageSenderVisible = $row['message_sender_visible'];
                $ret[$loadedMessage->messageId] = $loadedMessage;
            }
        }
        return $ret;
    }

    static public function loadAllMessagesByReceiverId(mysqli $conn, $receiverId) {
        $receiverId = $conn->real_escape_string($receiverId);
        $ret = [];
        $sql = "SELECT * FROM message WHERE message_receiver_id = $receiverId &&"
                . "message_receiver_visible = 0";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->messageContent = $row['message_content'];
                $loadedMessage->messageCreationDate = $row['message_creation_date'];
                $loadedMessage->messageId = $row['message_id'];
                $loadedMessage->messageRead = $row['message_read'];
                $loadedMessage->messageReceiverId = $row['message_receiver_id'];
                $loadedMessage->messageReceiverVisible = $row['message_receiver_visible'];
                $loadedMessage->messageSenderId = $row['message_sender_id'];
                $loadedMessage->messageSenderVisible = $row['message_sender_visible'];
                $ret[$loadedMessage->messageId] = $loadedMessage;
            }
        }
        return $ret;
    }

    static public function loadAllCutMessagesByReceiverId(mysqli $conn, $receiverId) {
        $receiverId = $conn->real_escape_string($receiverId);
        $ret = [];
        $sql = "SELECT substring(message_content,1,30) as message_content, message_creation_date,"
                . "message_id, message_read, message_receiver_id, "
                . "message_receiver_visible, message_sender_id, "
                . "message_sender_visible FROM message WHERE message_receiver_id = $receiverId &&"
                . "message_receiver_visible = 0 ORDER BY message_creation_date DESC";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->messageContent = $row['message_content'];
                $loadedMessage->messageCreationDate = $row['message_creation_date'];
                $loadedMessage->messageId = $row['message_id'];
                $loadedMessage->messageRead = $row['message_read'];
                $loadedMessage->messageReceiverId = $row['message_receiver_id'];
                $loadedMessage->messageReceiverVisible = $row['message_receiver_visible'];
                $loadedMessage->messageSenderId = $row['message_sender_id'];
                $loadedMessage->messageSenderVisible = $row['message_sender_visible'];
                $ret[$loadedMessage->messageId] = $loadedMessage;
            }
        }
        return $ret;
    }

    public function saveToDb(mysqli $conn) {
        if ($this->messageId == -1) {
            $statement = $conn->prepare("INSERT INTO message(message_content, "
                    . "message_creation_date, "
                    . "message_read, message_receiver_id, message_receiver_visible, "
                    . "message_sender_id, message_sender_visible) VALUES(?,?,?,?,?,?,?)");
            $statement->bind_param('ssiiiii', $this->messageContent, $this->messageCreationDate, $this->messageRead, $this->messageReceiverId, $this->messageReceiverVisible, $this->messageSenderId, $this->messageSenderVisible);
            if ($statement->execute()) {
                $this->messageId = $statement->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }

}
