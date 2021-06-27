<?php
declare(strict_types=1);

namespace Repository;

use Model\UserModel;

class UserRepository extends AbstractRepository
{

    /**
     * @return UserModel
     */
    public static function getUser(): UserModel
    {
        //temporary user
        //todo redo it properly
        //todo add static cache for user
        return new UserModel(['id' => 1]);
    }
}