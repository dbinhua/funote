<?php

namespace App\Http\Controllers\Helpers;

trait ObjectTool
{
    /**
     * 过滤对象的空属性
     * @param $object
     * @return mixed
     */
    public function filterObjectNullAttr(&$object)
    {
        foreach ($object as $attr => $val){
            if ($val === null) unset($object->{$attr});
        }
        return $object;
    }
}
