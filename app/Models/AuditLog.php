<?php

namespace App\Models;

use App\Core\Database;

final class AuditLog
{
    public static function record(string $action, ?int $userId = null, array $metadata = []): void
    {
        Database::insert('audit_logs', [
            'user_id' => $userId,
            'action' => $action,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255),
            'metadata' => $metadata,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
