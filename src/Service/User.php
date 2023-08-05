<?php

declare(strict_types=1);

namespace coffeforme\Service;

use coffeforme\Model\User as UserModel;


class User
{
    private const PASSWORD_COST_FACTOR = 12;
    private const PASSWORD_ALOGORITHM = PASSWORD_BCRYPT;
    private UserModel $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function create(array $userDetails): string|bool
    {
        return $this->userModel->insert($userDetails);
    }

    public function doesAccountEmailExists(string $email): bool
    {
        return $this->userModel->doesAccounEmailExist($email);
    }
    public function updateEmail(string $userId, string $email): bool
    {
        return $this->userModel->updateEmail($userId, $email);
    }
    public function updateName(string $userId, string $name): bool
    {
        return $this->userModel->updateName($userId, $name);
    }
    public function updatePassword(string $userId, string $hashedPassword): bool
    {
        return $this->userModel->updatePassword($userId, $hashedPassword);
    }
    public function hashPassword(string $password): string
    {
        return password_hash($password, self::PASSWORD_ALOGORITHM, ['cost' => self::PASSWORD_COST_FACTOR]);
    }

    public function verifyPassword(string $clearedPassword, string $hashedPassword)
    {
        return password_verify($clearedPassword, $hashedPassword);
    }

    public function getDetailsFromEmail(string $email)
    {
        return $this->userModel->getUserDetails($email);
    }
    public function getDetailsFromId(string $userId)
    {
        return $this->userModel->getUserDetails($userId);
    }
    public function getHashedPassword(string $userId): string
    {
        $userDetails = $this->userModel->getUserDetails($userId);
        return $userDetails->PASSWORD ?? '';
    }
}