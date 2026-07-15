<?php

namespace TalentFlow\Api;

class Client
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            get_option('talentflow_api_url', 'http://api:8000'),
            '/'
        );
    }

    public function health(): array
    {
        $response = wp_remote_get($this->baseUrl . '/health');

        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
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

    public function analyzeCV(string $filePath, string $jobDescription = ''): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/cv/analyze',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'file' => new \CURLFile(
                    $filePath,
                    'application/pdf',
                    basename($filePath)
                ),
                'job_description' => $jobDescription
            ]
        ]);

        $response = curl_exec($curl);

        if ($response === false) {

            return [
                'success' => false,
                'message' => curl_error($curl)
            ];
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($status !== 200) {

            return [
                'success' => false,
                'message' => "HTTP {$status}"
            ];
        }

        return [
            'success' => true,
            'body' => json_decode($response, true)
        ];
    }
}