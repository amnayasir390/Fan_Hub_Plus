<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with('user')->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $feedback = $query->paginate(20)->withQueryString();
        return view('admin.feedback.index', compact('feedback'));
    }

    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status'      => ['required', 'in:new,reviewed,resolved'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);
        $feedback->update($request->only('status', 'admin_notes'));
        return back()->with('success', 'Feedback updated.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Feedback deleted.');
    }
}
