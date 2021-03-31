<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Article\Article;

class PageHelper
{
    /**
     * 获取分页参数
     * @param int $currentPage
     * @param int $total
     * @param int|null $pageSize
     * @return array|array[]
     */
    public static function getPageData(int $currentPage, int $total, int $pageSize = Article::PAGE_SIZE)
    {
        $totalPage = ceil($total / $pageSize);

        //页面少于6页时不展示「首页」、「上一页」、「下一页」、「尾页」
        $pageOption = [];
        if ($totalPage < 6){
            for($i = 1; $i <= $totalPage; $i++){
                $pageOption[] = [
                    'pageText' => $i,
                    'pageIndex' => $i,
                    'active' => $currentPage == $i ? true : false,
                    'disabled' => false
                ];
            }
        }else{
            //定义「首页」、「上一页」参数
            $pageOption = [
                [
                    'pageText' => '首页',
                    'pageIndex' => 1,
                    'active' => false,
                    'disabled' => $currentPage == 1 ? true : false
                ],
                [
                    'pageText' => '<',
                    'pageIndex' => $currentPage - 1,
                    'active' => false,
                    'disabled' => $currentPage == 1 ? true : false
                ]
            ];

            //设置index保证当前选中的页面始终在中间按钮
            $index = 1;
            if ($currentPage - 2 > 0 && $currentPage + 2 <= $totalPage){
                $index = $currentPage - 2;
            }
            for($i = $index; $i <= $totalPage; $i++){
                $pageOption[] = [
                    'pageText' => $i,
                    'pageIndex' => $i,
                    'active' => $currentPage == $i ? true : false,
                    'disabled' => false
                ];
            }

            //补充「下一页」、「尾页」参数
            $pageOption[] = [
                'pageText' => '>',
                'pageIndex' => $currentPage + 1,
                'active' => false,
                'disabled' => $currentPage == $totalPage ? true : false
            ];
            $pageOption[] = [
                'pageText' => '尾页',
                'pageIndex' => $totalPage,
                'active' => false,
                'disabled' => $currentPage == $totalPage ? true : false
            ];
        }
        return $pageOption;
    }
}
