<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of all public announcements.
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(9);
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Display the specified announcement.
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.show', compact('announcement'));
    }
}
