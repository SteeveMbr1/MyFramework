<?php

namespace MyFramework\Controller;

class Controller extends AbstractController
{


    public function index()
    {
        $this->render('home', ['name' => 'toto']);
    }
}
