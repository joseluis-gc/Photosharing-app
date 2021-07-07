<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function getCategories()
    {
        # code...
        $categories = Category::get();
        return $categories;
    }
}
