<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use Illuminate\Http\Request;

class AdminChatbotController extends Controller
{
    public function index(Request $request)
    {
        $faqs = ChatbotFaq::orderBy('sort_order')->paginate(20);
        return view('admin.chatbot.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.chatbot.form');
    }

    public function store(Request $request)
    {
        ChatbotFaq::create($this->validateFaq($request));
        return redirect()->route('admin.chatbot.index')->with('success', 'FAQ created.');
    }

    public function edit(ChatbotFaq $chatbotFaq)
    {
        return view('admin.chatbot.form', ['faq' => $chatbotFaq]);
    }

    public function update(Request $request, ChatbotFaq $chatbotFaq)
    {
        $chatbotFaq->update($this->validateFaq($request));
        return redirect()->route('admin.chatbot.index')->with('success', 'FAQ updated.');
    }

    public function destroy(ChatbotFaq $chatbotFaq)
    {
        $chatbotFaq->delete();
        return back()->with('success', 'FAQ deleted.');
    }

    private function validateFaq(Request $request): array
    {
        $validated = $request->validate([
            'question'   => ['required', 'string', 'max:255'],
            'answer'     => ['required', 'string'],
            'category'   => ['nullable', 'string', 'max:100'],
            'keywords'   => ['nullable', 'string'],
            'is_active'  => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['keywords']  = $request->filled('keywords') ? array_map('trim', explode(',', $request->keywords)) : null;
        return $validated;
    }
}
