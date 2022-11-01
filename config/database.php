<?php

function getDataBaseConfig(): array
{
    return [
        "database" => [
            'test' => [
                "url" => "mysql:host=localhost;dbname=php_login_management_test",
                "user" => "root",
                "password" => "marleess771",
            ],
            'prod' => [
                "url" => "mysql:host=localhost;dbname=php_login_management",
                "user" => "root",
                "password" => "marleess771",
            ]
        ]
    ];
}
