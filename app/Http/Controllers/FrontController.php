<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

    public function details(Course $course)
    {
        return view('front.details');
    }

    public function category(Category $category)
    {
        return view('front.category');
    }

    public function pricing()
    {
        return view('front.pricing');
    }

    public function checkout()
    {
        return view('front.checkout');
    }

    public function checkout_store()
    {
        return view('front.checkout_store');
    }
}
