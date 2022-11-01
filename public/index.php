<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Login\Management\PHP\App\Router;
use Login\Management\PHP\Controller\HomeController;
use Login\Management\PHP\Controller\UserController;
use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Middleware\IsNotLoginMiddleware;
use Login\Management\PHP\Middleware\MandatoryLoginMiddleware;

Database::getConnection('prod');

// Home Controller
Router::get("GET", "/", HomeController::class, "index", [IsNotLoginMiddleware::class]);
Router::get("GET", "/dashboard", HomeController::class, "index", [MandatoryLoginMiddleware::class]);

//User Controller
Router::get("GET", "/user/register", UserController::class, "register", [IsNotLoginMiddleware::class]);
Router::get("POST", "/user/register", UserController::class, "postRegister", [IsNotLoginMiddleware::class]);
Router::get("GET", "/user/login", UserController::class, "login", [IsNotLoginMiddleware::class]);
Router::get("POST", "/user/login", UserController::class, "postLogin", [IsNotLoginMiddleware::class]);
Router::get("GET", "/user/logout", UserController::class, "logout", [MandatoryLoginMiddleware::class]);
Router::get("GET", "/setting/account", UserController::class, "accountSettings", [MandatoryLoginMiddleware::class]);
Router::get("POST", "/setting/account", UserController::class, "postUpdateEmail", [MandatoryLoginMiddleware::class]);
Router::get("GET", "/setting/password", UserController::class, "passwordSettings", [MandatoryLoginMiddleware::class]);
Router::get("POST", "/setting/password", UserController::class, "postUpdatePassword", [MandatoryLoginMiddleware::class]);

// Run the router
Router::run();
