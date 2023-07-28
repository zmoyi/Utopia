<?php

namespace App\Services;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryService
{
    /**
     * 获取所有分类
     * @return Collection
     */
    function getCategoryAll(): Collection
    {
        return Categories::all();
    }

    /**
     * 根据ID获取单项分类
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    function getCategoryItem(int $id): Model|Collection|Builder|array|null
    {
        return Categories::query()->find($id);
    }

}
