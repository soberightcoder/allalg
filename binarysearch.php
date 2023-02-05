<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:16
 */
/**
 * 二分查找法
 * 注意边界问题
 */
//$l = 2;
//$r = 4;
//$mid1 = $l + ($r - $l) >> 1; // (2 + 2) / 2 = 2// 算术运算符的优先级高于位运算；
//echo $mid1;
//echo "\n";
//$mid = $l + (($r - $l)>>1); // 注意要这么写；
//echo $mid;die;
/**
 * leetcode ---  704. 二分查找
 * 时间复杂度为O(logN)
 */
class Solution704 {

    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
//1 递归 方法；
//    function search($nums, $target) {
//        $l = 0;
//        $r = count($nums) - 1;
//        return $this->help($nums,$target,$l,$r);
//    }
//
//    function help($nums,$target,$l,$r) {
//        //end c
//        if ($l > $r) return -1; // 结束条件
//
//        $mid = $l + (($r - $l)>>2);
//
//        if ($nums[$mid] > $target) {  // 大于 往左走；
//            if (($res = $this->help($nums,$target,$l,$mid - 1)) >= 0) {
//                return $res;
//            }
//        } else if ($nums[$mid] < $target){
//            if (($res = $this->help($nums,$target,$mid + 1, $r)) >= 0) {
//                return $res;
//            }
//        } else if ($nums[$mid] == $target){
//            return $mid; // >= 0;
//        }
//        return -1;
//    }
    //迭代
    function search($nums, $target) {
        $l = 0;
        $r = count($nums) - 1;
        //左闭和右闭
        while ($l <= $r) {
            $mid = $l + (($r - $l) >> 1);
            if ($nums[$mid] == $target) {
                return $mid;
            } else if ($nums[$mid] > $target) {
                $r = $mid - 1;
            } elseif ($nums[$mid] < $target) {
                $l = $mid + 1;
            }
        }
        return -1;
    }
    // >= target  最左边的位置
    function searchge($nums,$target) {
        //左闭右闭
        $n = count($nums);
        $r = $n - 1;
        $l = -1 ;
        //满足条件执行
        while ($r >= $l) {
            $mid = $l + (($r - $l) >> 1);
            // 说不定会没有等于的
            if ($nums[$mid] >= $target) {
                //往左边去查询
                $r = $mid - 1;
                //记录位置 万一找不到
                $index = $mid;
            } else if ($nums[$mid] < $target) {
                $l = $mid + 1;
            }
        }
        return $index;
    }
    // <= $target
    public function searchle($nums, $target) {
        $r = count($nums) - 1;
        $l = 0;
        $index = -1;
        while ($r >= $l) {
            $mid = $l + (($r - $l) >> 1);
            if ($nums[$mid] <= $target) {
                $l = $mid + 1;
                $index = $mid;
            } else if ($nums[$mid] > $target) {
                $r = $mid - 1;
            }
        }
        return $index;
    }
    //局部最小值
    public function localMinival($nums) {
        $n = count($nums);
        // -1不存在
        // 注意这里的边界条件
        if ($n == 0) return -1;
        if ($nums[0] < $nums[1]) return 0;
        if ($nums[$n - 1] < $nums[$n - 2]) return $n - 1;

        // 必定存在 但是不知道在哪里？？
        $r = $n - 2;
        $l = 1;
        // 肯定会存在；
        //满足条件 尼玛的别一直错！！！
        while ($r >= $l) {
            $mid = $l + (($r - $l) >> 1);
            // d大于
            if ($nums[$mid] > $nums[$mid + 1]) {
//                $r = $mid - 1; //
                $l = $mid + 1;
            } else if ($nums[$mid] > $nums[$mid - 1]) {
                // $mid - 1;//看一下怎么实现的；
                $l = $mid - 1;
            } else {
                return $mid;
            }
        }
    }
}
$arrceshi = [];
$arr704 = [-1,0,3,5,9,12];
//最左边界的问题>= target
$arr704r = [1,2,3,3,3,3,4,5,5];
//局部最小值的测试案例
$arr7043 = [1,0,-1,1,0,1];

$obj704 = new Solution704();
//echo $obj704->search($arr704,9);//4
//echo $obj704->searchge($arr704r,3);//
//echo $obj704->searchle($arr704r, 3);//
// 设置一个初始值 不然要返回null
//var_dump($obj704->searchle($arrceshi, 3));die; // 0 null
var_dump($obj704->localMinival($arr7043));die;
