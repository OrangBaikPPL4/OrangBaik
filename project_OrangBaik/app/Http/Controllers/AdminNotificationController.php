<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\RequestBantuan;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of the notifications for the authenticated admin.
     */
    public function index()
    {
        // Ensure the user is an admin
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }
        
        // Get all notifications for this admin
        $notifications = AdminNotification::where('admin_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.notifications.index', compact('notifications'));
    }
    
    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        
        // Ensure the notification belongs to the authenticated admin
        if ($notification->admin_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke notifikasi ini!');
        }
        
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai telah dibaca.');
    }
    
    /**
     * Mark all notifications as read for the authenticated admin.
     */
    public function markAllAsRead()
    {
        // Ensure the user is an admin
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }
        
        AdminNotification::where('admin_id', Auth::id())
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
        $notification = AdminNotification::findOrFail($id);
        
        // Ensure the notification belongs to the authenticated admin
        if ($notification->admin_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke notifikasi ini!');
        }
        
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
    
    /**
     * Create a notification for all admins.
     * This is used by the system to notify admins about new requests.
     */
    public static function notifyAdmins($requestId, $title, $message, $type = 'info')
    {
        $request = RequestBantuan::findOrFail($requestId);
        
        // Get all admin users
        $admins = User::where('usertype', 'admin')->get();
        
        foreach ($admins as $admin) {
            AdminNotification::create([
                'admin_id' => $admin->id,
                'request_id' => $requestId,
                'title' => $title,
                'message' => $message,
                'type' => $type
            ]);
        }
        
        return true;
    }
}
