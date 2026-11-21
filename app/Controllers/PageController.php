<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Static About page identifying the developer. No database queries.
     */
    public function about(): View
    {
        return view('about', [
            'developer' => config('developer'),
        ]);
    }
}
