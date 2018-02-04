<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Portfolio;
use App\Service;
use App\People;

use DB;
use Mail;

class IndexController extends Controller
{
    public function execute(Request $request) {

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ]);

            $data = $request->all();

            Mail::send('emails.email', ['data' => $data], function($message) use ($data) {
                $message->from($data['email'], $data['name']);
                $message->to('vitold55@ukr.net');
                $message->subject('Test question');
            });

            if (count(Mail::failures()) == 0) {
                return redirect()->route('home')->with('status', 'Email was successfully sent!');
            }
        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();
        $tags = DB::table('portfolios')->distinct()->pluck('filter');

        $menu = [];
        foreach ($pages as $page) {
            $item = ['name' => $page->name, 'alias' => $page->alias];
            array_push($menu, $item);
        }

        return view('site.index', [
            'menu' => $menu,
            'pages' => $pages,
            'portfolios' => $portfolios,
            'services' => $services,
            'peoples' => $peoples,
            'tags' => $tags
        ]);
    }
}
