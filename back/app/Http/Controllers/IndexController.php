<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        $title = 'Русскоязычный сайт фанатов английской Премьер-Лиги';
        return view('index')->with('title', $title);
    }
}
