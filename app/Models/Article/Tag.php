<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $tag_id;

    public function createTag(TagInfo $tagInfo)
    {
        foreach ($tagInfo as $key => $item){
            $this->{$key} = $item;
        }
        $this->save();
        $this->tag_id = $this->id;
        return $this->getId();
    }

    public function getId()
    {
        return $this->tag_id;
    }

    /**
     * @param string $name
     * @param bool $fuzzy 是否模糊查询
     * @return mixed
     */
    public function getTagsByName(string $name ,bool $fuzzy = false)
    {
        if ($fuzzy){
            $tag = $this->where('name', 'like', '%'.$name.'%')->get();
        }else{
            $tag = $this->where('name', '=', $name)->first();
        }
        return $tag;
    }

    /**
     * @param string $name
     * @param bool $fuzzy 是否模糊查询
     */
    public function getTagsBySlug(string $slug ,bool $fuzzy = false)
    {
        if ($fuzzy){
            $tag = $this->where('slug', 'like', '%'.$slug.'%')->get();
        }else{
            $tag = $this->where('slug', '=', $slug)->first();
        }
        return $tag;
    }
}
