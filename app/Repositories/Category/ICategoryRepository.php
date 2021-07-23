<?php

namespace App\Repositories\Category;

interface ICategoryRepository
{
    public function getAllParentCategory();

    public function getAllChildCategory();
}
