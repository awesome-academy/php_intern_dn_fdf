<?php

namespace App\Repositories\Suggest;

interface ISuggestRepository
{
    public function approveSuggest($data, $id);

    public function refuseSuggest($id);

    public function addSuggest($data);
}
