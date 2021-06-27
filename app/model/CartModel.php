<?php
declare(strict_types=1);

namespace Model;

class CartModel
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var array
     * $key => productId, $val => [count]
     */
    private array $products = [];

    public function __construct(array $args)
    {
        foreach ($args as $idx => $item) {
            switch ($idx) {
                case 'userId':
                    $this->setUserId((int)$item);
                    break;
            }
        }
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId): CartModel
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param int $product
     * @return $this
     */
    public function addProduct(int $productId, int $count): CartModel
    {
        $this->products[$productId] = [
            'count' => $count,
        ];
        return $this;
    }

    public function removeProduct(int $productId): CartModel
    {
        if ($this->products[$productId] ?? null) {
            unset($this->products[$productId]);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}