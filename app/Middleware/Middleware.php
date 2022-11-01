<?php

namespace Login\Management\PHP\Middleware;

interface Middleware
{
    function before(): void;

}