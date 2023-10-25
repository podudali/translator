<?php

namespace App\Model;

use Nette;
use Nette\Database\Explorer;
use Orhanerday\OpenAi\OpenAi;

class TranslatorModel {

    private $database;
    public function __construct(Explorer $database){
        $this->database = $database;
    }

    public function getChatBot(string $userMessage, $lang = 'rus'): string {
        
        $keys = $this->database->table('test');
        foreach ($keys as $key) {
            $token = $key->token;
        }
        $key = $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "model" => "gpt-3.5-turbo",
            "messages" => array(
                array("role" => "user", "content" => $userMessage)
            ),
            "temperature" => 0.7
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer $key"
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        $answer = $result["choices"][0]["message"]["content"];
        return $answer;
    }
}