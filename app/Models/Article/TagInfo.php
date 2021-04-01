<?php

namespace App\Models\Article;

class TagInfo
{
    public $id;
    public $name;
    public $slug;
    public $image;
    public $intro;
    public $create_id;

    public function __construct(string $name, string $slug, int $create_id = 0)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->create_id = $create_id;
    }
}
