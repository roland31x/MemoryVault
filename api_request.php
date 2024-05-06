<?php
    function api_request($url, $type, $data, $auth_token) {
        $authorizationHeader = 'Authorization: Bearer ' . $auth_token;
        $headers = [
            'Content-type: application/json'
        ];

        if($auth_token) {
            array_push($headers, $authorizationHeader);
        }

        $httpoptions = [
            'method' => $type,
            'header' => $headers, 
        ];

        if($data && $type != "GET") {
            $httpoptions['content'] = json_encode($data);
        }

        $options = [
            'http' => $httpoptions,
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
        $context = stream_context_create($options);

        $response = @file_get_contents($url, false, $context);

        if($response === FALSE) {
            return false;
        }

        return json_decode($response, true);
    }

    $API_URL = 'https://localhost:7043/api/';
?>