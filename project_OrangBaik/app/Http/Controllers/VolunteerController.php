<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\Relawan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VolunteerNotificationController;
use App\Models\VolunteerNotification;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Different views for admin and volunteer
        if (Auth::user()->usertype === 'admin') {
            // Admin sees all volunteer events with complete details
            $volunteers = Volunteer::with('relawan')->get();
            return view('volunteer.admin_index', compact('volunteers'));
        } else {
            // Volunteers see available events
            $volunteers = Volunteer::where('status', 'aktif')->get();
            
            // Get user's volunteer profile if exists
            $relawan = Relawan::where('user_id', Auth::id())->first();
            
            return view('volunteer.index', compact('volunteers', 'relawan'));
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only admin can create volunteer events
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('volunteer.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        return view('volunteer.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only admin can store new volunteer events
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('volunteer.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'nama_acara' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,dalam proses,selesai',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/volunteer'), $imageName);
            $data['image_url'] = '/images/volunteer/' . $imageName;
        }
        
        Volunteer::create($data);
        
        return redirect()->route('volunteer.index')->with('success', 'Acara volunteer berhasil dibuat!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $volunteer = Volunteer::with('relawan')->findOrFail($id);
        
        // Get user's volunteer profile if exists
        $relawan = Relawan::where('user_id', Auth::id())->first();
        $isJoined = false;
        
        if ($relawan) {
            $isJoined = $relawan->volunteer->contains($id);
        }

        // Get available volunteers for admin
        $relawanTersedia = null;
        if (Auth::user()->usertype === 'admin') {
            $relawanTersedia = Relawan::whereNotIn('id', $volunteer->relawan->pluck('id'))->get();
            return view('volunteer.admin-show', compact('volunteer', 'relawan', 'isJoined', 'relawanTersedia'));
        }
        
        return view('volunteer.show', compact('volunteer', 'relawan', 'isJoined'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Only admin can edit volunteer events
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('volunteer.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $volunteer = Volunteer::findOrFail($id);
        
        return view('volunteer.edit', compact('volunteer'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Only admin can update volunteer events
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('volunteer.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'nama_acara' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,dalam proses,selesai',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $volunteer = Volunteer::findOrFail($id);
        $data = $request->except('image');
        
        // Save original data for comparison to determine what changed
        $originalData = [
            'nama_acara' => $volunteer->nama_acara,
            'lokasi' => $volunteer->lokasi,
            'tanggal_mulai' => $volunteer->tanggal_mulai,
            'tanggal_selesai' => $volunteer->tanggal_selesai,
            'status' => $volunteer->status
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($volunteer->image_url && file_exists(public_path($volunteer->image_url))) {
                unlink(public_path($volunteer->image_url));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/volunteer'), $imageName);
            $data['image_url'] = '/images/volunteer/' . $imageName;
        }
        
        $volunteer->update($data);
        
        // Check what changed and send notifications to relawan
        $changesMessage = [];
        
        if ($originalData['nama_acara'] !== $data['nama_acara']) {
            $changesMessage[] = "Nama acara diubah dari '{$originalData['nama_acara']}' menjadi '{$data['nama_acara']}'";
        }
        
        if ($originalData['lokasi'] !== $data['lokasi']) {
            $changesMessage[] = "Lokasi diubah dari '{$originalData['lokasi']}' menjadi '{$data['lokasi']}'";
        }
        
        if ($originalData['tanggal_mulai'] !== $data['tanggal_mulai']) {
            $changesMessage[] = "Tanggal mulai diubah dari '" . date('d/m/Y', strtotime($originalData['tanggal_mulai'])) . "' menjadi '" . date('d/m/Y', strtotime($data['tanggal_mulai'])) . "'";
        }
        
        if ($originalData['tanggal_selesai'] !== $data['tanggal_selesai']) {
            $changesMessage[] = "Tanggal selesai diubah dari '" . date('d/m/Y', strtotime($originalData['tanggal_selesai'])) . "' menjadi '" . date('d/m/Y', strtotime($data['tanggal_selesai'])) . "'";
        }
        
        if ($originalData['status'] !== $data['status']) {
            $changesMessage[] = "Status acara diubah dari '{$originalData['status']}' menjadi '{$data['status']}'";
        }
        
        // If there are changes, send notification to all relawan in this event
        if (!empty($changesMessage)) {
            $title = "Perubahan pada acara '{$data['nama_acara']}'";
            $message = "Berikut perubahan pada acara volunteer yang Anda ikuti:\n" . implode("\n", $changesMessage);
            
            // Send notification to all relawan in this event
            VolunteerNotificationController::notifyVolunteers($id, $title, $message, 'warning');
        }
        
        return redirect()->route('volunteer.index')->with('success', 'Acara volunteer berhasil diperbarui!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Only admin can delete volunteer events
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('volunteer.index')->with('error', 'Anda tidak memiliki izin!');
        }
        
        $volunteer = Volunteer::findOrFail($id);
        
        // Remove image if exists
        if ($volunteer->image_url && file_exists(public_path($volunteer->image_url))) {
            unlink(public_path($volunteer->image_url));
        }
        
        // Notify registered volunteers about the cancellation
        VolunteerNotificationController::notifyVolunteers(
            $volunteer->id,
            'Pembatalan Acara: ' . $volunteer->nama_acara,
            "Acara volunteer '{$volunteer->nama_acara}' yang Anda ikuti telah dibatalkan. Mohon maaf atas ketidaknyamanannya.",
            'warning'
        );

        // Detach all relawan
        $volunteer->relawan()->detach();
        
        // Delete volunteer event
        $volunteer->delete();
        
        return redirect()->route('volunteer.index')->with('success', 'Acara volunteer berhasil dihapus!');
    }
    
    /**
     * Update volunteer event status.
     */
    public function updateVolunteerStatus(Request $request, $id)
    {
        // Only admin can update volunteer event status
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'status' => 'required|in:aktif,dalam proses,selesai'
        ]);
        
        $volunteer = Volunteer::findOrFail($id);
        $oldStatus = $volunteer->status;
        $newStatus = $request->status;
        
        $volunteer->update(['status' => $newStatus]);
        
        // If status has changed, notify all relawan in this event
        if ($oldStatus !== $newStatus) {
            $statusMessages = [
                'aktif' => 'Acara ini sekarang aktif dan menerima pendaftaran relawan baru.',
                'dalam proses' => 'Acara ini sekarang sedang berlangsung. Pastikan Anda hadir sesuai jadwal.',
                'selesai' => 'Acara ini telah selesai. Terima kasih atas partisipasi Anda.'
            ];
            
            $title = "Status acara '{$volunteer->nama_acara}' telah berubah";
            $message = "Status acara volunteer yang Anda ikuti telah berubah dari '{$oldStatus}' menjadi '{$newStatus}'.
{$statusMessages[$newStatus]}";
            
            // Send notification to all relawan in this event
            VolunteerNotificationController::notifyVolunteers($id, $title, $message, 'info');
        }
        
        // If volunteer event is completed, update the status of all volunteers in this event
        if ($newStatus === 'selesai') {
            foreach ($volunteer->relawan as $relawan) {
                // Update pivot table with status_kehadiran if needed
                // $volunteer->relawan()->updateExistingPivot($relawan->id, ['status_kehadiran' => 'hadir']);
            }
        }
        
        return redirect()->back()->with('success', 'Status acara volunteer diperbarui!');
    }
    
    /**
     * Allow a volunteer to join an event.
     */
    public function gabungVolunteer(Request $request, $id)
    {
        // Check if user is authenticated and has relawan profile
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $relawan = Relawan::where('user_id', Auth::id())->first();
        
        if (!$relawan) {
            return redirect()->route('relawan.create')
                ->with('error', 'Anda harus mendaftar sebagai relawan terlebih dahulu!');
        }
        
        $volunteer = Volunteer::findOrFail($id);
        
        // Check if volunteer event is active
        if ($volunteer->status !== 'aktif') {
            return redirect()->back()->with('error', 'Acara volunteer ini tidak menerima pendaftaran!');
        }
        
        // Check if relawan already joined this volunteer event
        if ($volunteer->relawan()->where('relawan_id', $relawan->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar dalam acara volunteer ini!');
        }
        
        // Check if volunteer quota is full
        if ($volunteer->relawan()->count() >= $volunteer->kuota_relawan) {
            return redirect()->back()->with('error', 'Kuota relawan untuk acara ini sudah penuh!');
        }
        
        // Add relawan to volunteer event
        $volunteer->relawan()->attach($relawan->id);
        
        // Notify registered volunteers about the update
        VolunteerNotificationController::notifyVolunteers(
            $volunteer->id,
            'Update Acara: ' . $volunteer->nama_acara,
            "Ada pembaruan pada acara volunteer '{$volunteer->nama_acara}' yang Anda ikuti. Silahkan cek detail acara untuk informasi terbaru.",
            'info'
        );
        
        // Send notification to the relawan
        VolunteerNotification::create([
            'relawan_id' => $relawan->id,
            'volunteer_id' => $volunteer->id,
            'title' => 'Pendaftaran Berhasil: ' . $volunteer->nama_acara,
            'message' => "Selamat! Anda telah berhasil terdaftar sebagai relawan untuk acara '{$volunteer->nama_acara}'.

Detail acara:
Tanggal: " . date('d/m/Y', strtotime($volunteer->tanggal_mulai)) . " - " . date('d/m/Y', strtotime($volunteer->tanggal_selesai)) . "
Lokasi: {$volunteer->lokasi}

Silahkan cek halaman detail acara untuk informasi lebih lanjut.",
            'type' => 'success'
        ]);
        
        return redirect()->back()->with('success', 'Anda berhasil bergabung dengan acara volunteer ini!');
    }
    
    /**
     * Add a volunteer to an event.
     */
    public function tambahRelawan(Request $request, $id)
    {
        // Only admin can add volunteers
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }

        $request->validate([
            'relawan_id' => 'required|exists:relawans,id'
        ]);

        $volunteer = Volunteer::findOrFail($id);
        $relawan = Relawan::findOrFail($request->relawan_id);

        // Check if volunteer is already in the event
        if ($volunteer->relawan->contains($relawan->id)) {
            return redirect()->back()->with('error', 'Relawan sudah bergabung dalam acara ini!');
        }
        
        // Check if event has reached its volunteer quota
        $currentVolunteers = $volunteer->relawan->count();
        if ($volunteer->kuota_relawan > 0 && $currentVolunteers >= $volunteer->kuota_relawan) {
            return redirect()->back()->with('error', 'Kuota relawan untuk acara ini sudah penuh!');
        }

        // Add volunteer to event
        $volunteer->relawan()->attach($relawan->id);

        return redirect()->back()->with('success', 'Relawan berhasil ditambahkan ke acara!');
    }

    /**
     * Remove a volunteer from an event.
     */
    public function hapusRelawan($volunteer_id, $relawan_id)
    {
        // Only admin can remove volunteers
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }

        $volunteer = Volunteer::findOrFail($volunteer_id);
        $relawan = Relawan::findOrFail($relawan_id);

        // Remove volunteer from event
        $volunteer->relawan()->detach($relawan->id);

        return redirect()->back()->with('success', 'Relawan berhasil dihapus dari acara!');
    }

    /**
     * Update volunteer attendance status.
     */
    public function updateKehadiran(Request $request, $volunteer_id, $relawan_id)
    {
        // Only admin can update attendance status
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin!');
        }
        
        $request->validate([
            'status_kehadiran' => 'required|in:belum hadir,hadir,tidak hadir'
        ]);
        
        $volunteer = Volunteer::findOrFail($volunteer_id);
        $relawan = Relawan::findOrFail($relawan_id);
        
        // Update pivot table with attendance status
        $volunteer->relawan()->updateExistingPivot($relawan->id, [
            'status_kehadiran' => $request->status_kehadiran
        ]);
        
        return redirect()->back()->with('success', 'Status kehadiran relawan berhasil diperbarui!');
    }
}
