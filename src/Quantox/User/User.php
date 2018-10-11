<?php

namespace Quantox\User;

use Quantox\Utils\Hasher;
use Quantox\Database\DbRepository;

class User
{
    protected $name;

    protected $email;

    protected $password;

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = Hasher::hash($password);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function create(): bool
    {
        $db = new DbRepository();

        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
        ];

        return $db->insert('users', $data);
    }
}
