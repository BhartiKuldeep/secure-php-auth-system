<?php

namespace App\Models;

use App\Core\Database;

final class PasswordReset
{
    public static function create(string $email): string
    {
        self::deleteByEmail($email);
        $token = bin2hex(random_bytes(32));

        Database::insert('password_resets', [
            'email' => strtolower(trim($email)),
            'token' => hash('sha256', $token),
            'expires_at' => date('Y-m-d H:i:s', time() + 3600),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $token;
    }

    public static function findValid(string $token): ?array
    {
        $hashed = hash('sha256', $token);
        $now = date('Y-m-d H:i:s');

        return Database::first('password_resets', function (array $record) use ($hashed, $now): bool {
            return $record['token'] === $hashed && $record['expires_at'] >= $now;
        });
    }

    public static function deleteByEmail(string $email): void
    {
        $needle = strtolower(trim($email));
        Database::delete('password_resets', fn (array $record) => $record['email'] === $needle);
    }
}
