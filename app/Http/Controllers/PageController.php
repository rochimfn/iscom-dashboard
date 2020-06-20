<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pages;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = $request->validate([
            'page_title' => 'required',
            'page_content' => 'required'
        ]);
        $page['user_id'] = 1;
        $page = Pages::create($page);
        $page->save();

        return redirect()->back()->with('success', 'Halaman ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $file = $request->file('upload');
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = md5($fileName. time()) . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('uploads'), $fileName);

        $location = asset('uploads/' . $fileName);
        $location = parse_url($location, PHP_URL_PATH);

        return json_encode(['location' => $location]);
    }
}
