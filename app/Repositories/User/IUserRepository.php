<?php

namespace App\Repositories\User;

interface IUserRepository
{
    public function updateAvatarCurrentUser($data);

    public function updateInfomationCurrentUser($data);

    public function updatePasswordCurrentUser($data);

    public function checkListFavoriteHasThisProduct($product_id);

    public function addProductToListFavorite($product_id);

    public function removeProductFromListFavorite($product_id);

    public function getAllFavoriteOfCurrentUser();
}
