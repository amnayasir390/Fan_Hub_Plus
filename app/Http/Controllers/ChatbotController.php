<?php

namespace App\Http\Controllers;

use App\Models\ChatbotFaq;
use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function message(Request $request)
    {
        $request->validate(['message' => ['required', 'string', 'max:500']]);

        $userMessage = trim($request->message);
        $sessionId   = $request->session()->getId();
        $userId      = auth()->id();

        // Store user message
        ChatHistory::create([
            'user_id'    => $userId,
            'session_id' => $sessionId,
            'role'       => 'user',
            'message'    => $userMessage,
        ]);

        // Find best matching FAQ
        $response = $this->findBestResponse($userMessage);

        // Store bot response
        ChatHistory::create([
            'user_id'    => $userId,
            'session_id' => $sessionId,
            'role'       => 'bot',
            'message'    => $response,
        ]);

        return response()->json(['response' => $response]);
    }

    public function history(Request $request)
    {
        $history = ChatHistory::where('session_id', $request->session()->getId())
            ->orderBy('created_at')
            ->take(50)
            ->get(['role', 'message', 'created_at']);

        return response()->json($history);
    }

    protected function findBestResponse(string $message): string
    {
        $msgLower = Str::lower($message);

        $faqs = ChatbotFaq::where('is_active', true)->get();

        $bestScore = 0;
        $bestFaq   = null;

        foreach ($faqs as $faq) {
            $score = 0;

            // Check keywords
            if ($faq->keywords) {
                foreach ($faq->keywords as $keyword) {
                    if (Str::contains($msgLower, Str::lower($keyword))) {
                        $score += 2;
                    }
                }
            }

            // Check question words similarity
            $questionWords = explode(' ', Str::lower($faq->question));
            foreach ($questionWords as $word) {
                if (strlen($word) > 3 && Str::contains($msgLower, $word)) {
                    $score += 1;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestFaq   = $faq;
            }
        }

        if ($bestFaq && $bestScore >= 2) {
            return $bestFaq->answer;
        }

        // Fallback greetings / help
        if (preg_match('/\b(hi|hello|hey|greetings)\b/i', $message)) {
            return "👋 Hey there! Welcome to Fan Hub Plus! I\'m your fandom guide. You can ask me about categories, how to bookmark content, upcoming events, merchandise, or anything about the platform. What would you like to explore?";
        }

        if (preg_match('/\b(bye|goodbye|thanks|thank you)\b/i', $message)) {
            return "🌟 You\'re welcome! Come back anytime — there\'s always something new to discover on Fan Hub Plus. Happy exploring!";
        }

        return "🤔 I\'m not sure about that specific topic, but I\'m here to help! You can ask me about:\n• Platform features (search, filters, bookmarks)\n• Fandom categories (Anime, Gaming, K-Pop...)\n• Finding events near you\n• Merchandise and upcoming releases\n• How to submit your own fan content\n\nWhat would you like to know?";
    }
}
