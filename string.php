<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:24
 */
/**
 * string 字符串
 * 滑动窗口
 */


/**
 * leetcode - 3. 无重复字符的最长子串
 * time O(n)  // 遍历一遍
 * space O(n) //set 来判断是重复；
 */

class Solution {

    /**
     * @param String $s
     * @return Integer
     */

    function lengthOfLongestSubstring($s) {

        $len = strlen($s);
//        if ($len == 0) return 0;
        $left = $right = 0;
        $max = 0;
        $set = [];// O(n)

        while ($right <= $len - 1) {
            //提前结束
            if ($max + $left >= $len) {
                break;
            }
            // repeat
            if (isset($set[$s[$right]])) { //这里有问题；
                //从左边 移除；
                //移除数组
                unset($set[$s[$left]]);
                $left++;//会一直有问题
            } else {
                // 只有增加的收才会发现 有没有最大值；
                $max = max($right - $left + 1,$max);
                $set[$s[$right]] = 1;
                $right++;
            }
        }
        return $max;
    }

}
//$str = "abcabcbb";
//$obj = new Solution();
//echo $obj->lengthOfLongestSubstring($str);
/**
 * leetcode - 209  长度最小的子数组
 * https://leetcode.cn/problems/minimum-size-subarray-sum/
 */
class Solution1 {

    /**
     * @param Integer $target
     * @param Integer[] $nums
     * @return Integer
     */
    function minSubArrayLen($target, $nums) {
        $set = [];
        $left = $right = 0;
        $sum = 0;
        $n = count($nums);
        $min = 0;

        while ($right < $n) {
            //
            $set[$nums[$right]] = 1;
            $sum += $nums[$right];
            $right++;//

            while ($sum >= $target) {
                //
                $min = min($min,$right - $left);
                unset($set[$nums[$left]]);
                $sum -= $nums[$left];
                $left++;
            }
        }
        return $min;
    }
}

$arr1 = [2,3,1,2,4,3];
$obj1 = new Solution1();

echo $obj1->minSubArrayLen(7,$arr1);