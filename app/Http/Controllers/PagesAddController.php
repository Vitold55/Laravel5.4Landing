<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Page;

class PagesAddController extends Controller
{
    public function execute(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->except('_token');

            $validator = Validator::make($input,[
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required'
            ], [
                'required' => 'Field :attribute can not be empty',
                'unique' => 'Field :attribute must be unique'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $fileOriginName = $file->getClientOriginalName();
                $input['images'] = $fileOriginName;

                $file->move(public_path() . '/assets/img', $fileOriginName);
            } else {
                $input['images'] = '';
            }

            $page = new Page();
            $page->fill($input);

            if ($page->save()) {
                return redirect()->route('pages')->with('status', 'Page was successfully saved!');
            } else {
                return redirect()->back()->withErrors('Something went wrong!');
            }

        }

        if (view()->exists('admin.pages_add')) {
            return view('admin.pages_add', [
                'title' => 'Add new page'
            ]);
        }

        abort(404);
    }
}
