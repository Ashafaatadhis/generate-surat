<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::all();
        return view('dashboard.links.index', compact('links'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unique_kode_link' => 'required|unique:links',
            'kuota' => 'required|integer|min:0',
        ]);


        Link::create($request->all());

        return redirect()->route('dashboard.links.index')->with('success', 'Link created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        return view('dashboard.links.edit', compact('link'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'unique_kode_link' => 'required|unique:links,unique_kode_link,' . $link->id,
            'kuota' => 'required|integer|min:0',
        ]);

        $link->update($request->all());

        return redirect()->route('dashboard.links.index')->with('success', 'Link updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('dashboard.links.index')->with('success', 'Link deleted successfully!');
    }
}
