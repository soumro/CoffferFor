<?php

namespace coffeforme\Kernel;

class Session
{
    public function __construct()
    {
        $this->initialize();
    }
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return (string) $_SESSION[$key] ?? '';
    }
    public function doesExists(string $key): bool
    {
        return !empty($_SESSION[$key]);
    }
    public function sets(array $data): void
    {
        foreach ($data as $key => $value) {
            echo $value;
            $this->set($key, $value);
        }
    }
    public function destroy(): void
    {
        if (!empty($_SESSION)) {
            $_SESSION = [];
            session_unset();
            session_destroy();
        }
    }

    private function isinitialize(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    private function initialize()
    {
        if (!$this->isinitialize()) {
            @session_start();
        }
    }
}