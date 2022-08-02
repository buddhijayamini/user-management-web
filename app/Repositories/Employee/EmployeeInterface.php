<?php

namespace App\Repositories\Employee;

interface EmployeeInterface
{
    public function getAll() : object;
    public function getPaginated() : object;
    public function getById(int $id) : object;
    public function store(array $addDetails) : object;
    public function update(int $id, array $newDetails) : bool;
    public function destroy(int $id) : bool;
}
