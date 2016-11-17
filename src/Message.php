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
        } else {
            return false;
        }
    }
    
    public function setMessageCreationDate($messageDate) {
        if (is_a($messageDate, 'DateTime')) {
            $this->messageCreationDate = $messageDate;
        } else {
            return false;
        }
     
    }
    
    //reszta po kolacji...
    
    
    
    
    
    
    
    
    
    
    
    
    
}

