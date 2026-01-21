<?php

/**
 * User entity class representing a user in the system.
 * Maps to the 'users' table in the database.
 */
class User
{
    public ?int $user_id;
    public string $email;
    public string $password_hash;
    public string $first_name;
    public string $last_name;
    public ?string $avatar_url;
    public string $registration_date;

    /**
     * Constructor to initialize User properties.
     * @param array $data Associative array of user properties.
     */
    public function __construct(array $data = [])
    {
        $this->user_id = $data['user_id'] ?? null;
        $this->email = $data['email'] ?? '';
        $this->password_hash = $data['password_hash'] ?? '';
        $this->first_name = $data['first_name'] ?? '';
        $this->last_name = $data['last_name'] ?? '';
        $this->avatar_url = $data['avatar_url'] ?? null;
        $this->registration_date = $data['registration_date'] ?? '';
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getRegistrationDate(): string
    {
        return $this->registration_date;
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
