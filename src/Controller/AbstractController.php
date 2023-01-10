<?php

namespace MyFramework\Controller;

use MyFramework\Template\View;

abstract class AbstractController
{

    public function render(string $name, array $datas)
    {
        return new View($name, $datas);
    }
}
