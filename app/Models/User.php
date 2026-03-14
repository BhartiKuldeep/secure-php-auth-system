<?php

namespace App\Models;

use App\Core\Database;

final class User
{
    public static function create(array $attributes): array
    {
        $now = date('Y-m-d H:i:s');
        $isVerified = (bool) ($attributes['verified'] ?? false);

        return Database::insert('users', [
            'name' => trim($attributes['name']),
            'email' => strtolower(trim($attributes['email'])),
            'password' => password_hash($attributes['password'], PASSWORD_DEFAULT),
            'role' => $attributes['role'] ?? 'user',
            'email_verified_at' => $isVerified ? $now : null,
            'verification_token' => $isVerified ? null : self::hashToken(bin2hex(random_bytes(32))),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public static function all(): array
    {
        $users = Database::all('users');
        usort($users, fn (array $a, array $b) => strcmp($b['created_at'], $a['created_at']));
        return $users;
    }

    public static function find(int $id): ?array
    {
        return Database::first('users', fn (array $user) => (int) $user['id'] === $id);
    }

    public static function findByEmail(string $email): ?array
    {
        $needle = strtolower(trim($email));
        return Database::first('users', fn (array $user) => $user['email'] === $needle);
    }

    public static function findByVerificationToken(string $token): ?array
    {
        $hashed = self::hashToken($token);
        return Database::first('users', fn (array $user) => ($user['verification_token'] ?? null) === $hashed);
    }

    public static function markEmailVerified(int $id): void
    {
        Database::update('users', fn (array $user) => (int) $user['id'] === $id, function (array $user): array {
            $user['email_verified_at'] = date('Y-m-d H:i:s');
            $user['verification_token'] = null;
            $user['updated_at'] = date('Y-m-d H:i:s');
            return $user;
        });
    }

    public static function issueVerificationToken(int $id): string
    {
        $token = bin2hex(random_bytes(32));
        $hashed = self::hashToken($token);

        Database::update('users', fn (array $user) => (int) $user['id'] === $id, function (array $user) use ($hashed): array {
            $user['verification_token'] = $hashed;
            $user['updated_at'] = date('Y-m-d H:i:s');
            return $user;
        });

        return $token;
    }

    public static function updatePassword(int $id, string $password): void
    {
        Database::update('users', fn (array $user) => (int) $user['id'] === $id, function (array $user) use ($password): array {
            $user['password'] = password_hash($password, PASSWORD_DEFAULT);
            $user['updated_at'] = date('Y-m-d H:i:s');
            return $user;
        });
    }

    public static function verifyCredentials(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);
        if (! $user) {
            return null;
        }

        return password_verify($password, $user['password']) ? $user : null;
    }

    private static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }
}
