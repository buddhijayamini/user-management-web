<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function store(array $data) : object;

    public function login(array $data) : object;
}
