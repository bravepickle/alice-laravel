<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'parent',
    ];

    public $timestamps = false;

    /**
     * @param  Category|null  $parent
     * @return Category
     */
    public function setParent(?Category $parent): self
    {
        $this->parent_id = $parent->id ?? null;

        return $this;
    }

}
