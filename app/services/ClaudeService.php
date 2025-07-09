<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService {

    private string $apiKey;
    private string $baseUrl = 'https://api.anthropic.com';

    public function __construct(){
        $this->apiKey = config('services.claude.api_key');
        Log::info('Cladue API KEY: ' . $this->apiKey);
    }

public function generateWebsite(string $prompt, array $context = []): array {
    try {
       $systemPrompt = $this->buildSystemPrompt();
       $userPrompt = $this->buildUserPrompt($prompt,$context);

       $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'content-type' => 'application/json',
            'anthropic-version' => '2023-06-01'
       ])->timeout(120)->post($this->$baseUrl . '/v1/messages',[
            'model' => 'claude-3-5-sonnet-20241022',
            'max_tokens' => 4000,
            'system' => $systemPrompt,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $userPrompt
                ] 
            ]
                ]);
        if ($response->successful()) {
           $data = $response->json();
           return $this->parseClaudeResponse($data['content'][0]['text'], $context);
        }
        throw new \Exception('Claude API Request failed' . $response->body());

    } catch (\Exception $e) {
        Log::error('Claude API Error:' . $e->getMessage());
        throw $e;
    }  
}

private function buildSystemPrompt(): string {
    
}







}

