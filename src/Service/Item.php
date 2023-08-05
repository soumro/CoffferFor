<?php

declare(strict_types=1);

namespace coffeforme\Service;

use coffeforme\Model\Item as ItemModel;

class Item
{
    private ItemModel $itemModel;
    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }
    public function create(string $userId, array $itemDetails): string|bool
    {
        return $this->itemModel->insert($userId, $itemDetails);
    }

    public function update(string $userId, array $itemDetails): bool
    {
        return $this->itemModel->update($userId, $itemDetails);
    }
    public function getfromIdName(string $idName)
    {
        return $this->itemModel->get($idName);
    }
    public function getfromUserId(string $userId)
    {
        return $this->itemModel->get($userId);
    }
    public function doesItemNameExists(string $idName): bool
    {
        return $this->itemModel->get($idName);
    }

    public function hasUserAnItem(string $userId): bool
    {
        return $this->itemModel->hasUserAnItem($userId);
    }

    public function getUserItemUrl(string $itemIdName): string
    {
        return site_url('/p/' . $itemIdName);
    }
}