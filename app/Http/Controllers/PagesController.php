<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PagesController extends Controller
{
    public function execute() {
        if (view()->exists('admin.pages')) {
            $pages = Page::all();

            return view('admin.pages', [
                'title' => 'Pages',
                'pages' => $pages
            ]);
        }

        abort(404);
    }
}
