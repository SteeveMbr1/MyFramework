<?php

namespace MyFramework\Controller;

use function MyFramework\Template\View;

abstract class AbstractController
{

    public function render(string $name, array $datas)
    {
        return View($name, $datas);
    }
}
