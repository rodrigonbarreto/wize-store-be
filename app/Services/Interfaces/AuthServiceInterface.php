<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    /**
     * @param  array<string, string>  $credentials
     * @return array<string, mixed>
     */
    public function authenticate(array $credentials): array;
}
