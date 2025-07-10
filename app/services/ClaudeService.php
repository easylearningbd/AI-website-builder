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
// End Method 

private function buildSystemPrompt(): string { 

    return "You are an expert web developer assistant. When generating websites, always respond with a JSON object containing 'html', 'css', and 'js' fields. 
        Use Bootstrap classes for styling instead of raw CSS unless specified otherwise. Include the Bootstrap CSS CDN in the HTML head. 
        Rules:
        1. Generate complete, functional, responsive HTML
        2. Include Bootstrap classes for modern styling
        3. Add JavaScript for interactivity when needed
        4. Use semantic HTML elements
        5. Ensure mobile responsiveness
        6. Include proper meta tags and structure
        7. Preserve and integrate existing CSS and JavaScript where applicable
        8. Use modern web standards
        9. Ensure NO extra text or content appears after the </body> tag in the HTML
        10. For placeholder images, use https://placehold.co/ with a default size of 300x200 (e.g., https://placehold.co/300x200) unless a specific size is requested

        Always wrap your response in JSON format like this:
        {
            \"html\": \"<!DOCTYPE html>...\",
            \"css\": \"body { ... }\", // Only include raw CSS if Bootstrap is not used
            \"js\": \"// JavaScript code here\"
        }"; 
}
// End Method 

private function buildUserPrompt(string $prompt, array $context = []): string {

    $userPrompt = "Create or update a website based on this request: {$prompt}\n\n";

    if (!empty($context['html_content'])) {
        $userPrompt .= "Current HTML:\n{$context['html_content']}\n\n";
    }

     if (!empty($context['css_content'])) {
        $userPrompt .= "Current CSS:\n{$context['css_content']}\n\n";
    }

     if (!empty($context['js_content'])) {
        $userPrompt .= "Current JavaScript:\n{$context['js_content']}\n\n";
    }

     $userPrompt .= "Generate the complete website code in JSON format. If updating, integrate the existing CSS and JavaScript where applicable. Ensure the Bootstrap CSS CDN is included in the HTML head. The HTML must be a valid, self-contained document with NO extra text after the </body> tag. For any placeholder images, use https://placehold.co/ with a default size of 300x200 (e.g., https://placehold.co/300x200) unless a specific size is specified in the prompt.";
       return $userPrompt;

}
// End Method 

private function parseClaudeResponse(string $response, array $context): array {

    // Try to extract Json from the response 
    $jsonStart = strpos($response, '{');
    $jsonEnd = strrpos($response, '}');

    if ($jsonStart !== false && $jsonEnd !== false) {
       $jsonStart = substr($response, $jsonStart, $jsonEnd - $jsonStart + 1);
       $decoded = json_decode($jsonStart, true);

       if ($decoded) {
        $html = $decoded['html'] ?? '';
        $html = $this->cleanHtml($html);

        if (stripos($html, '<html') === false && !empty($context['html_content'])) {
           $html = $this->ensureFullHtml($context['html_content'],$html);
        } elseif(strpos($html, '<html') === false) {
            $html = $this->ensureFullHtml($html);
        }

        /// Replace vai.placeholder.com with placehold.co
        $html = $this->replacePlaceholderImages($html);
        return [
            'html' => $html,
            'css' => $decoded['css'] ?? $context['css_content'] ?? '',
            'js' => $decoded['js'] ?? $context['js_content'] ?? '',
        ];
       } 
    }

    $html = $this->cleanHtml($response);
    if (!empty($context['html_content']) && stripos($html, '<html') === false) {
        $html = $this->ensureFullHtml($context['html_content'], $html);
    } elseif (stripos($html, '<html') === false) {
       $html = $this->ensureFullHtml($html);
    }

    $html = $this->replacePlaceholderImages($html);
        return [
            'html' => $html,
            'css' => $decoded['css'] ?? $context['css_content'] ?? '',
            'js' => $decoded['js'] ?? $context['js_content'] ?? '',
        ]; 
}
// End Method 

private function cleanHtml(string $html): string {

}
// End Method 










}

