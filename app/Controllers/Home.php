<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // pre(site_url("public/assets/"));
        return view('welcome_message');
    }
}
