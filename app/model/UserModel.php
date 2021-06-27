<?php

namespace Model;


class UserModel
{
    /**
     * @var int|null
     */
    private int $id;

    public function __construct(array $args)
    {
        foreach ($args as $idx => $item) {
            switch ($idx) {
                case 'id':
                    $this->setId((int)$item);
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}