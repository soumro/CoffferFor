<?php

declare(strict_types=1);

namespace coffeforme\Model;

use coffeforme\Kernel\Database\Database;

class Payment
{
    public const TABLE_NAME = 'payments';

    public function insert(array $details): string|bool
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . '(userId, paypalEmail, currency) VALUES (:userId, :paypalEmail, :currency)';

        if (Database::query($sql, $details)) {
            return Database::lastInsertId();
        }
        return false;
    }
    public function isDetailsExists(string $userID): bool
    {
        $sql = 'SELECT paymentId FROM ' . self::TABLE_NAME . ' WHERE userId = :userId LIMIT 1';

        Database::query($sql, ['userId' => $userID]);
        return Database::rowCount() >= 1;
    }
    public function updateDetails(string $userId, string $paypalEmail, string $currency): bool
    {
        $sql = 'UPDATE ' . self::TABLE_NAME . ' SET paypalEmail = :paypalEmail, currency = :currency WHERE userId = :userId LIMIT 1';

        return Database::query($sql, [
            'userId' => $userId,
            'paypalEmail' => $paypalEmail,
            'currency' => $currency,
        ]);
    }
    public function getDetails(string $userId)
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE userId = :value  LIMIT 1';

        Database::query($sql, ['value' => $userId]);

        return Database::fetch();
    }
}