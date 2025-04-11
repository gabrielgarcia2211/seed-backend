<?php

namespace App\Interfaces\User;

interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByEmail($email);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
}