<?php
declare(strict_types=1);

namespace Framework\Session;


/**
 * Created by PhpStorm at 05.12.2023
 *
 * @PHPSession
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @package Framework\Session
 */
class PHPSession implements SessionInterface, \ArrayAccess
{

    public function __construct()
    {
        $this->ensureSessionStarted();
    }



    /**
     * @inheritDoc
    */
    public function get(string $key, $default = null): mixed
    {
         return $_SESSION[$key] ?? $default;
    }




    /**
     * @inheritDoc
    */
    public function set(string $key, $value): void
    {
         $_SESSION[$key] = $value;
    }





    /**
     * @inheritDoc
    */
    public function delete(string $key): void
    {
         unset($_SESSION[$key]);
    }





    /**
     * @inheritDoc
    */
    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }





    /**
     * @return void
    */
    private function ensureSessionStarted(): void
    {
         if (session_status() === PHP_SESSION_NONE) {
             session_start();
         }
    }



    /**
     * @inheritDoc
    */
    public function offsetExists(mixed $offset): bool
    {
         return $this->has($offset);
    }




    /**
     * @inheritDoc
    */
    public function offsetGet(mixed $offset): mixed
    {
         return $this->get($offset);
    }





    /**
     * @inheritDoc
    */
    public function offsetSet(mixed $offset, mixed $value): void
    {
         $this->set($offset, $value);
    }




    /**
     * @inheritDoc
    */
    public function offsetUnset(mixed $offset): void
    {
         $this->delete($offset);
    }
}