<?php

namespace App\Base;

use App\Services\ApiClient;

abstract class Model
{

    protected string $model;

    protected ?array $data = null;

    protected ApiClient $apiClient;

    public function __construct()
    {
        $this -> apiClient = new ApiClient('https://jsonplaceholder.typicode.com');
    }

    public function searchById(int $id): self
    {
        $this -> data = $this
            -> apiClient
            -> request('GET', "/{$this -> model}/{$id}")
            -> getJson();

        return $this;
    }

    public function searchAll(): self
    {
        $this -> data =  $this
            -> apiClient
            -> request('GET', "/{$this -> model}")
            -> getJson();

        return $this;
    }

    public function getData(?int $chunk = null, ?int $page = null): ?array
    {
        if ($chunk !== null && $page !== null) {
            return array_chunk($this -> data, $chunk)[$page];
        }

        return $this -> data;
    }
}