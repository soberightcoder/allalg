<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:14
 */
/**
 *  php  就是array and hash 哈希算法；
 */
/**
 * 重复的数组
 */
// space:O(n) time:O(n)
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findRepeatNumber($nums) {
        $arr = [];
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if (isset($arr[$nums[$i]])) {
                return $nums[$i];
            } else {
                $arr[$nums[$i]] = 1;
            }
        }
    }
}
// 优化 ，要求原地排序
// 原地操作
class Solution1 {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findRepeatNumber($nums) {
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if ($i == $nums[$i]) {//equal
                continue;
            } else {// swap
                if ($nums[$nums[$i]] == $nums[$i]) {
                    return $nums[$i];
                } else {
                    $this->swap($nums[$i],$nums[$nums[$i]]);
                    //指针不能走;
                    $i--;
                }
            }
        }
    }
    //要对原数组来进行操作 要传引用；
    public function swap(&$value1,&$value2) {
        $tmp = $value1;
        $value1 = $value2;
        $value2 =  $tmp;
    }
}
$arr1 = [2,3,1,0,2,5,3];
//$obj1 = new Solution1();
//echo $obj1->findRepeatNumber($arr1);
/**
 * 重复数组的问题；
 * 数组中重复的数据
 * 给你一个长度为 n 的整数数组 nums ，其中 nums 的所有整数都在范围 [1, n] 内，且每个整数出现 一次 或 两次 。请你找出所有出现 两次 的整数，并以数组形式返回。
 * 原地排序 O(1);
 * 注意长度显示 是 1-n；会出现越界的问题；
 */
class Solution2 {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function findDuplicates($nums) {
        $len = count($nums);
        $res = [];
        $nums[$len] = 0;// 0 肯定不存在的；

        for ($i = 0; $i < $len; $i++) {
            if ($i == $nums[$i]) {
                continue;
            } else {
                if ($nums[$i] == $nums[$nums[$i]])  {
                    //会有去重的问题 会变得很麻烦 这里最好做一下优化；
                  $res[$nums[$i]] = 1;
                } else {
                    $this->swap($nums[$i],$nums[$nums[$i]]);
                    $i--;
                }
            }
        }
//        var_dump($res);die;
        return array_keys($res);
    }

    public function swap(&$value1,&$value2) {
        $tmp =$value1;
        $value1 = $value2;
        $value2 = $tmp;
    }
}



//$arr2 = [4,3,2,7,8,2,3,1];
$arr2 = [9,9,4,10,8,5,2,2,7,7];
//$obj2 = new Solution2();

//var_dump($obj2->findDuplicates($arr2));die;

class Solution3 {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function findDuplicates($nums) {
        $duplicates = [];
        $n = count($nums);
        for ($i = 0; $i < $n; $i++) {
            $num = $nums[$i];
            $index = abs($num) - 1;
            //第一次被遍历 就代表 > 0
            if ($nums[$index] > 0) {
                $nums[$index] = -$nums[$index];
            } else {// 小于0 就代表被遍历过一次了，就需要插入；所以不需要 去重；
                $duplicates[]  = $index + 1; // 因为减去了1  所以还需要再加上1
            }
        }
        return $duplicates;
    }
}
//$obj3 = new Solution3();
//var_dump($obj3->findDuplicates($arr2));die;

///
/// class Solution {
//    public List<Integer> findDuplicates(int[] nums) {
//        List<Integer> duplicates = new ArrayList<Integer>();
//        int n = nums.length;
//        for (int i = 0; i < n; i++) {
//            int num = nums[i];
//            int index = Math.abs(num) - 1;
//            if (nums[index] > 0) {
//                nums[index] = -nums[index];
//            } else {
//                duplicates.add(index + 1);
//            }
//        }
//        return duplicates;
//    }
//}
//

/**
 * 数组去重问题；
 * question1 : space : O(n) time : (n)
 */
class Question1
{
    public function unique($arr) {
        $set = []; // 额外空间
        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {
            if (isset($set[$arr[$i]])) {
                continue;
            } else {
                $set[$arr[$i]] = 1;
            }
        }
        return array_keys($set);//自动去重；
    }
}

/**
 * Class Question2
 * space O(1)原地 time O(n);
 * 数组千万不要在数组间去删除 ，一般先交换到数组末尾然后去删除；
 * 0 - q 是去重的；剩下的是重复的；但是并不包含全部的重复，仅仅是节约空间；
 */
class Question2
{
    public function unique($arr) {
        //排序 会有局限性
        sort($arr); // nlogn// 保证有序性把；
        return $this->help($arr);
    }

    public function help($arr) {
        //
        $n = count($arr);
        $q = 0;
        $p = 1;
        // 重复的部分 被覆盖掉了；
        while ($p < $n) {
            if ($arr[$q] != $arr[$p]) {
                $q++;
                $arr[$q] = $arr[$p];
            }
            $p++;
        }
        // 0 - q 才是不重复的部分；所以不重复的长度是q+1;
        //
        echo $q;
        return $arr;
    }
}
$arrq1 = [1,2,3,2,3,5,6];
//$objq1 = new Question1();
//var_dump($objq1->unique($arrq1));die;
$objq2 = new Question2();
var_dump($objq2->unique($arrq1));die;
