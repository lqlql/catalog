<?php
declare(strict_types=1);

namespace Controller;

use Model\UserModel;
use Repository\UserRepository;

class AbstractController
{
    protected array $params;
    protected UserModel $user;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->user = UserRepository::getUser();
    }

    //todo create validator for AUTH and ROLE
    //todo create validator for $params
}