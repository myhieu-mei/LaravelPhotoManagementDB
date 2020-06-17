<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    function index(){
        $categories= Category::all();
        echo "<pre>" . json_encode($categories, JSON_PRETTY_PRINT). "</pre>";
    }
}
