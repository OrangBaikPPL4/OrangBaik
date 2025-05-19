<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

use App\Http\Middleware\Admin;

class EdukasiController extends Controller
{

    public function __construct()
    {
        // Memastikan hanya admin yang dapat membuat, mengedit, atau menghapus konten edukasi
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Edukasi::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
    
        return view('edukasi.index', [
            'edukasi' => $query->orderBy('created_at', 'desc')->get(),
            'selectedCategory' => $request->category ?? '',
        ]);
    }
    
    /**
     * Display a listing of the resource for admin management.
     */
    public function adminIndex(Request $request)
    {
        $query = Edukasi::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
    
        return view('edukasi.admin-index', [
            'edukasi' => $query->orderBy('created_at', 'desc')->get(),
            'selectedCategory' => $request->category ?? '',
        ]);
    }
    
    /**
     * Display the menu for edukasi management.
     */
    public function menu()
    {
        return view('edukasi.menu');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('edukasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'video_file' => 'nullable|mimes:mp4,mov,avi|max:1000000',
            'video_link' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('video_file')) {
            $validated['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        Edukasi::create($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Konten edukasi berhasil ditambahkan.');    }

    /**
     * Display the specified resource.
     */
    public function show(Edukasi $edukasi)
    {
    $query = Edukasi::where('id', '!=', $edukasi->id);

    if (filled(request('category'))) {
        $query->where('category', request('category'));
    }
    

    $kontenLain = $query->orderBy('created_at', 'desc')->take(9)->get();

    return view('edukasi.show', compact('edukasi', 'kontenLain'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edukasi $edukasi)
    {
        return view('edukasi.edit', compact('edukasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'video_file' => 'nullable|mimes:mp4,mov,avi|max:1000000',
            'video_link' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $edukasi->image);
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('video_file')) {
            Storage::delete('public/' . $edukasi->video_file);
            $validated['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        $edukasi->update($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Konten edukasi berhasil diperbarui.');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edukasi $edukasi)
{
    if ($edukasi->image && Storage::exists('public/' . $edukasi->image)) {
        Storage::delete('public/' . $edukasi->image);
    }

    if ($edukasi->video_file && Storage::exists('public/' . $edukasi->video_file)) {
        Storage::delete('public/' . $edukasi->video_file);
    }

    $edukasi->delete();

    return redirect()->route('admin.edukasi.index')->with('success', 'Konten edukasi berhasil dihapus.');
}

}
