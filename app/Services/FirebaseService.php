<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected Database $database;

    public function __construct()
    {
        $factory = (new Factory)
    ->withServiceAccount(storage_path('desynat-firebase-adminsdk-fbsvc-511856a90e.json'))
    ->withDatabaseUri('https://desynat-default-rtdb.firebaseio.com');


        // $factory = (new Factory)
        //     ->withServiceAccount(storage_path('ichrono-firebase-adminsdk-fbsvc-bc66e0b097.json'));

        $this->database = $factory->createDatabase();
    }

    // public function sendMessage(string $room, array $message): string
    // {
    //     $newMessage = $this->database
    //         ->getReference("chats/{$room}")
    //         ->push($message);

    //     return $newMessage->getKey();
    // }

            public function sendMessage(string $room, array $message): string
        {
            // Step 1: Create a new reference and get its unique Firebase key
            $newMessageRef = $this->database
                ->getReference("chats/{$room}")
                ->push(); // this generates the key, but doesn't write data yet

            $msgId = $newMessageRef->getKey();

            // Step 2: Add the generated key as 'id' in your message array
            $message['id'] = $msgId;

            // Step 3: Write the message data using the generated key
            $newMessageRef->set($message);

            return $msgId;
        }


    public function getMessages(string $room): array
    {

        return $this->database
            ->getReference("chats/{$room}")
            ->orderByChild('timestamp')
            ->getValue() ?? [];
    }

    public function updateMessage(string $room, string $messageId, array $data): void
    {
        $this->database
            ->getReference("chats/{$room}/{$messageId}")
            ->update($data);
    }

     public function countUnreadMessages($room, $currentUserId)
    {
        $messages = $this->getMessages($room);
        $count = 0;

        foreach ($messages as $msg) {
            if (isset($msg['id']) && $msg['id'] != $currentUserId && (!isset($msg['read_status']) || $msg['read_status'] == 0)) {
                $count++;
            }
        }

        return $count;
    }




}