<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerNotification;
use App\Models\Relawan;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;

class VolunteerNotificationController extends Controller
{
    /**
     * Display a listing of the notifications for the authenticated user.
     */
    public function index()
    {
        // Get the authenticated user's relawan profile
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan) {
            return redirect()->route('relawan.create')
                ->with('error', 'Anda harus mendaftar sebagai relawan terlebih dahulu!');
        }
        
        // Get all notifications for this relawan
        $notifications = VolunteerNotification::where('relawan_id', $relawan->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('volunteer.notifications.index', compact('notifications', 'relawan'));
    }
    
    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = VolunteerNotification::findOrFail($id);
        
        // Ensure the notification belongs to the authenticated user
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan || $notification->relawan_id !== $relawan->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke notifikasi ini!');
        }
        
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai telah dibaca.');
    }
    
    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan) {
            return redirect()->back()->with('error', 'Anda harus mendaftar sebagai relawan terlebih dahulu!');
        }
        
        VolunteerNotification::where('relawan_id', $relawan->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai telah dibaca.');
    }
    
    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $notification = VolunteerNotification::findOrFail($id);
        
        // Ensure the notification belongs to the authenticated user
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan || $notification->relawan_id !== $relawan->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke notifikasi ini!');
        }
        
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
    
    /**
     * Create a notification for all volunteers in an event.
     * This is used by the system to notify volunteers about changes.
     */
    public static function notifyVolunteers($volunteerId, $title, $message, $type = 'info')
    {
        $volunteer = Volunteer::findOrFail($volunteerId);
        
        // Get all relawan in this volunteer event
        $relawans = $volunteer->relawan;
        
        foreach ($relawans as $relawan) {
            VolunteerNotification::create([
                'relawan_id' => $relawan->id,
                'volunteer_id' => $volunteerId,
                'title' => $title,
                'message' => $message,
                'type' => $type
            ]);
        }
        
        return true;
    }
}
