<?php

namespace App\Services;

use Exception;

class ApiClient
{
    private string $baseUrl;

    private array $defaultOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,  
    ];

    private array $headers = [];

    private array $allowedMethods = [
        'POST', 'GET', 'PUT', 'DELETE', 'PATCH',
    ];

    private ?string $answer = null;


    public function __construct(string $baseUrl = '')
    {
        $this -> baseUrl = rtrim($baseUrl, '/');
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this -> baseUrl = rtrim($baseUrl, '/');
        return $this;
    }

    public function setHeader(string $key, string $value): self
    {
        $this -> headers[] = "{$key}: {$value}";
        return $this;
    }

    public function request(string $method, string $endpoint, ?array $data = null, array $params = []): self
    {
        if (!in_array($method, $this -> allowedMethods)) {
            throw new Exception('Method is not allowed.');
        }

        $ch = curl_init($this -> buildUrl($endpoint, $params));

        foreach ($this -> defaultOptions as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $this -> setHeader('Content-Type', 'application/json')
                -> setHeader('Accept', 'application/json');
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this -> headers);

        $this -> answer = curl_exec($ch);
        curl_close($ch); 
        
        return $this;
    }

    public function getRaw(): string
    {
        return $this -> answer;
    }

    public function getJson(): array
    {
        return json_decode($this -> answer, true);
    }

    private function buildUrl(string $uri, array $params = []): string
    {
        $url = $this -> baseUrl ? "{$this -> baseUrl}/" . ltrim($uri, '/') : $uri;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}