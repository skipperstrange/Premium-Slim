<?php

$config["auth"] =  [
    "path" => ["/edit"], /* or ["/api", "/admin"] */
    "attribute" => "decoded_token_data",
    "secret" => JWT_SECRET,
    "algorithm" => ["HS256"],
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
];