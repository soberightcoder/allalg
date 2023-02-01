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
 *
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
}
$arr704 = [-1,0,3,5,9,12];
$obj704 = new Solution704();
echo $obj704->search($arr704,9);//4