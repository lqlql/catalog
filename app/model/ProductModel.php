<?php
declare(strict_types=1);

namespace Model;

class ProductModel
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var int
     */
    private int $price;

    /**
     * @var int
     */
    private int $isDeleted;

    /**
     * @var int
     */
    private int $createdDt;

    /**
     * @var int
     */
    private int $updatedDt;

    public function __construct(array $args)
    {
        foreach ($args as $idx => $item) {
            switch ($idx) {
                case 'productId':
                    $this->setId((int)$item);
                    break;
                case 'title':
                    $this->setTitle((string)$item);
                    break;
                case 'price':
                    $this->setPrice((int)$item);
                    break;
                case 'isDeleted':
                    $this->setIsDeleted((int)$item);
                    break;
                case 'createdDt':
                    $this->setCreatedDt((int)$item);
                    break;
                case 'updatedDt':
                    $this->setUpdatedDt((int)$item);
                    break;
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): ProductModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): ProductModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice(int $price): ProductModel
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsDeleted(): int
    {
        return $this->isDeleted;
    }

    /**
     * @param int $isDeleted
     * @return $this
     */
    public function setIsDeleted(int $isDeleted): ProductModel
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedDt(): int
    {
        return $this->createdDt;
    }

    /**
     * @param int $createdDt
     * @return $this
     */
    public function setCreatedDt(int $createdDt): ProductModel
    {
        $this->createdDt = $createdDt;
        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedDt(): int
    {
        return $this->updatedDt;
    }

    /**
     * @param int $updatedDt
     * @return $this
     */
    public function setUpdatedDt(int $updatedDt): ProductModel
    {
        $this->updatedDt = $updatedDt;
        return $this;
    }
}