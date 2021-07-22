<?php

namespace App\Repositories\User;

interface IUserRepository
{
    public function updateAvatarCurrentUser($data);

    public function updateInfomationCurrentUser($data);

    public function updatePasswordCurrentUser($data);
}
