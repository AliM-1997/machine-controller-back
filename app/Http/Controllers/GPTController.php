<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GPTController extends Controller
{
    public function generateText(Request $request)
    {
        $apiKey = env('OPENAI_API_KEY');
    
        // Get the documentation text from the request
        $documentation = $request->input('prompt');
    
        // Refined prompt with clear instructions
        $prompt = "Please extract the maximum standard pressure and temperature values from the following documentation. Documentation: " . $documentation;
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'max_tokens' => 200, // Increase token limit if needed
        ]);
    
        return $response->json();
    }
    
    

}
