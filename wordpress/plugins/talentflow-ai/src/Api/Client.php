<?php

namespace TalentFlow\Api;

class Client
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            get_option('talentflow_api_url', 'http://api:8000'),
            '/'
        );

        $this->timeout = (int) get_option('talentflow_timeout', 5);
    }

    public function health(): array
    {
        return $this->request('GET', '/health');
    }

    public function analyzeCV(): array
    {
        return $this->request('POST', '/cv/analyze');
    }

    private function request(string $method, string $endpoint): array
    {
        $response = wp_remote_request(
            $this->baseUrl . $endpoint,
            [
                'method'  => $method,
                'timeout' => $this->timeout,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }

        $statusCode = wp_remote_retrieve_response_code($response);

        if ($statusCode !== 200) {
            return [
                'success' => false,
                'message' => "HTTP {$statusCode}",
            ];
        }

        return [
            'success' => true,
            'body' => json_decode(
                wp_remote_retrieve_body($response),
                true
            ),
        ];
    }
}