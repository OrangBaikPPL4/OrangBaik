<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqFeedback;

class FaqFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = FaqFeedback::latest()->paginate(10);
        return view('admin.faq.feedback.index', compact('feedbacks'));
    }

    /**
     * Mark feedback as addressed.
     */
    public function markAsAddressed($id)
    {
        $feedback = FaqFeedback::findOrFail($id);
        $feedback->update(['is_addressed' => true]);
        
        return redirect()->route('admin.faq.feedback.index')->with('success', 'Feedback berhasil ditandai sebagai sudah ditangani.');
    }

    /**
     * Delete feedback.
     */
    public function destroy($id)
    {
        $feedback = FaqFeedback::findOrFail($id);
        $feedback->delete();
        
        return redirect()->route('admin.faq.feedback.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
