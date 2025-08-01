<?php

namespace App\Http;

class Request
{
    protected $get;
    protected array $post;
    protected $files;
    protected $server;
    protected $cookies;
    protected $headers;

    public static function capture() : self {
        return new static(
            $_GET,
            $_POST,
            $_FILES,
            $_SERVER,
            $_COOKIE,
            getallheaders()
        );
    }

    public function __construct(
        array $get = [],
        array $post = [],
        array $files = [],
        array $server = [],
        array $cookies = [],
        array $headers = []
    ) {
        $this->get = $get;
        $this->post = $post;
        $this->files = $files;
        $this->server = $server;
        $this->cookies = $cookies;
        $this->headers = $headers;
    }

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function header(string $key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    public function file(string $key)
    {
        return $this->files[$key] ?? null;
    }

    public function uri()
    {
        return parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH);
    }
}