<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Page;


class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin/pages/index')->with('pages', $pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/pages/create');
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
        $page['user_id'] = Auth::user()->user_id;
        $page = Page::create($page);
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman ditambahkan');
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
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('admin/pages/edit')->with('page', $page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'page_title' => 'required',
            'page_content' => 'required'
        ]);

        $page = Page::where('slug', $slug)->first();

        $page->fill([
            'page_title' => $request->input('page_title'),
            'page_content' => $request->input('page_content')
        ]);
        $page['user_id'] = Auth::user()->user_id;
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $title = $page->page_title;
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', $title . " successfully deleted");
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
           'file' => 'required|file|image'
        ]);

        $file = $request->file('file');
        $filename = md5($file->getClientOriginalName(). time()) .'.'. $file->getClientOriginalExtension();

        $file->move(public_path('/uploads'), $filename);

        return response()->json(['location' => '/uploads/'.$filename]);

    }
}
