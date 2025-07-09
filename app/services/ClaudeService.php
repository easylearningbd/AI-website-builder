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




}

