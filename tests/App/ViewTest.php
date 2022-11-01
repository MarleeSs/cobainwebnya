<?php

namespace Login\Management\PHP\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender()
    {
        View::render('Home/index', [
            "Marleess"
        ]);

        $this->expectOutputRegex('[Marleess]');
        $this->expectOutputRegex('[bootstrap.min.css]');
    }
}
