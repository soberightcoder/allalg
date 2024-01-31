<?php

/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/2/17
 * Time 17:23
 */
/**
 * 贪心算法；
 * 解题思路真的很奇妙；不是一般人 可以想的出来的，还是要多看把；没有别的办法！
 * 两个极端，简单的是真的简单，难得是真的难！
 *  ** 本质** 利用局部最优解，来求解，全局最优解！
 * 需要去判断，局部最优可不可以推出全局最优！ 只能自己试一下！
 * 没有套路！！随便刷几道就行啦！
 * 证明的方法，数学归纳和反证法！！但是没必要
 */

/**
 *leetcode - 455. 分发饼干
 *
 */
class Solution1
{
    /**
     * @param Integer[] $g
     * @param Integer[] $s
     * @return Integer
     */
    //饼干尽量去喂饱胃口最大的小孩；
    function findContentChildren($g, $s)
    {
        sort($s);
        sort($g);
        $slen = count($s);
        $glen = count($g);
        $count = 0;
        $j = $glen - 1;
        //排序；必须要排序，需要用大饼干，先去满足胃口最大得小孩！
        for ($i = $slen - 1; $i >= 0; $i--) {
            //$g是孩子； $s是饼干
            while ($j >= 0) {
                if ($g[$j] <= $s[$i]) {
                    $j--;
                    $count++;
                    break;
                }
                $j--;
            }
        }
        return $count;
    }
}


$g = [1, 2, 3];
$s = [1, 1];
$obj1 = new Solution1();
//var_dump($obj1->findContentChildren($g,$s));


/**
 * 分糖果 --- BM 95
 * 牛客网
 */


/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 * pick candy
 * @param arr int整型一维数组 the array
 * @return int整型
 *
 * //搞一下；
 */
function candy($arr)
{
    // write code here
    $n = count($arr);
    if ($n <= 1)
        return $n;
    //从左到右边
    //初始化
    $tmp = [];
    for ($i = 0; $i < $n; $i++)
        $tmp[$i] = 1;
    //左边；
    for ($i = 0; $i < $n - 1; $i++) {
        if ($arr[$i + 1] > $arr[$i])
            $tmp[$i + 1] = $tmp[$i] + 1;
    }

    //从右边到左边；
    for ($i = $n - 2; $i >= 0; $i--) {
        if ($arr[$i] > $arr[$i + 1] && $tmp[$i] <= $tmp[$i + 1]) {
            $tmp[$i] = $tmp[$i + 1]  + 1;
        }
    }
    //sum
    $ret = array_sum($tmp);
    return $ret;
}
//res
//echo candy([1, 1, 2]);
//echo candy([1, 4, 2, 7, 9]);
//echo candy([10, 4, 10, 10, 4]);
// 1, 1, 2,1,1
// 2,1 ,2, 2,1
// 8,7,6,5,4// 1.1.1.1. 左边遍历


/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 * 计算成功举办活动需要多少名主持人
 * @param n int整型 有n个活动
 * @param startEnd int整型二维数组 startEnd[i][0]用于表示第i个活动的开始时间，startEnd[i][1]表示第i个活动的结束时间
 * @return int整型
 */
function minmumNumberOfHost($n,  $startEnd)
{
    // write code here
    //usort 只对开始时间来做排序就可以了；
    usort($startEnd, function ($a, $b) {
        //        if ($a[0] == $b[0])
        //            return $b[1] - $a[1]; //逆序；
        return $a[0] - $b[0]; //顺序
    });
    //经历多少次；
    //画一下图看一下；会简单一些；
    //双指针；
    $res = 1;
    $j = 0;
    for ($i = 1; $i < $n; $i++) {
        //start 和上一个的结束来做比较；
        if ($startEnd[$i][0] >= $startEnd[$j][1]) {
            $j++;
        } else {
            $res++;
        }
    }
    return $res;
}
$tmparr = [[547, 612], [417, 551], [132, 132], [168, 446], [95, 747], [187, 908], [115, 712], [15, 329], [612, 900], [3, 509], [181, 200], [562, 787], [136, 268], [36, 784], [533, 573], [165, 946], [343, 442], [127, 725], [557, 991], [604, 613], [633, 721], [287, 847], [414, 480], [428, 698], [437, 616], [475, 932], [652, 886], [19, 992], [132, 543], [390, 869], [754, 903], [284, 925], [511, 951], [272, 739]];
// echo minmumNumberOfHost(34,$tmparr);//32牛客网有问题；

//区间；
//usort($intervals,function ($a,$b) {
//    if ($a[0] == $b[0]) {
//        return $b[1] - $a[1];  //尾部逆序排序
//    }
//    return $a[0] - $b[0]; // 首部顺序排序
//});
//var_dump($intervals);die;


/**
 * 剑指 Offer II 074. 合并区间
 * 区间重叠 --- 然后做一个合并操作！
 */


class Solution3
{

    /**
     * @param Integer[][] $intervals
     * @return Integer[][]
     */
    //start 顺序排序  和 end 逆序排序；
    function merge($intervals)
    {
        //边界
        $n = count($intervals);
        if ($n <= 1)  return $intervals;
        //排序
        usort($intervals, function ($a, $b) {
            if ($a[0] == $b[0])
                return $b[1] - $a[1]; //逆序 相等的时候 前面的会覆盖掉后面的区间；
            return $a[0] - $b[0];
        });
        //区间的合并；
        $left = $intervals[0][0];
        $right = $intervals[0][1];
        $tmp = [[$left, $right]];

        for ($i = 1; $i < $n; $i++) {
            $invt = $intervals[$i];
            //cover
            // if ($left <= $invt[0] && $right >= $invt[1])
            // {
            //     //not do sth
            //     //tmp 不需要添加任何的数据；
            // }
            // 变成一个有效的区间！
            if ($right >= $invt[0] && $right <= $invt[1]) {
                //相交；
                $right = $invt[1];
                //覆盖到原先的结果
                array_pop($tmp);
                array_push($tmp, [$left, $right]);
            }
            if ($right < $invt[0]) {
                $right = $invt[1];
                $left = $invt[0];
                array_push($tmp, [$left, $right]);
            }
        }
        return $tmp;
    }
}

// $obj = new Solution3();
// $arr = $obj->merge([[1, 3], [2, 6], [8, 10], [15, 18]]);
// var_dump($arr);

/**
 * leetcode - 376. 摆动序列；
 * 一正一负，可以使用相乘，但是 = 0的话，就不能保证了，因为，可能两者都为0；
 * 注意要考虑相等的情况！
 * 
 * sentry 哨兵，可以减少代码量！
 * 
 *需要注意
 *  ----
 * /    \   
 *  */

function wiggleMaxLength($nums)
{
    $n = count($nums);
    if ($n <= 1) return $n;
    $res = 1;
    //哨兵//在前面补$nums[-1] = $nums[0]
    $curdiff = 0;
    $prediff = 0;
    for ($i = 0; $i < $n - 1; $i++) {

        $curdiff = $nums[$i + 1] - $nums[$i];
        if ($curdiff > 0 && $prediff <= 0 || $curdiff < 0 && $prediff >= 0) {
            //摆动序列的最长序列长度；
            $res++;
            $prediff = $curdiff;
        }
    }
    return $res;
}

/**
 * 53. 最大子数组和
 *最大连续子数组和；
 * 连续和是负数的时候抛弃和，重新开始，并不是值是负数；
 * 负数只会拖累我们；
 * */
//贪心算法
//只需要记录最大值就行了；
//时间复杂度n;
//并不是连续负数就跳过；
 function maxSubarr($nums)  {
    $res = PHP_INT_MIN;
    $n = count($nums);
    $count = 0;
    for ($i = 0; $i < $n;$i++) {
        $count += $nums[$i];
        // 如果全部是负数，那么单个值就是最大值；
        if ($count > $res) $res = $count;
        //和为负数那么将重新计数；
        if ($count < 0) $count = 0;
    }
    return $res;
 }

 /**
  * 121. 买卖股票的最佳时机--- 应该使用动态规划，这才是一个正常的揭解法；
   */ 
//暴力求解；n^2暴力求解 但是会超出最大时间限制！
function maxProfit($prices) {
    $n = count($prices);
    $maxprofit = 0;
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i+1; $j < $n; $j++) {
            $profit = $prices[$j] - $prices[$i];
            if ($profit > $maxprofit) $maxprofit = $profit;
        }
    }
    return $maxprofit;
}

function maxProfitbygreedy($prices) {

}
 /**
  * 122. 买卖股票的最佳时机 II
  *贪心算法的直觉：由于不限制交易次数，只要今天股价比昨天高，就交易。
  */
  class Solution {

    /**
     * @param Integer[] $prices
     * @return Integer
     */
    function maxProfit($prices) {
        $res = 0;
        $n = count($prices);
        for ($i = 1; $i < $n; $i ++) {
            // 只把一系列数中大于0的相加 小于0的不加；
            $res += max(($prices[$i] - $prices[$i-1]),0);
        }
        return $res;
    }
}
/**
 * 跳跃游戏 --- 经典算法； -- 覆盖范围；
 * 55. 跳跃游戏
 * 怎么去跳并不重要，重要的是覆盖范围；
 * 每次都要去覆盖最大，才会是最少的跳跃次数！
 */
// 动态的去更新增量；
 function canJump($nums) {
    $n = count($nums);
    if ($n == 1) return true;
    $cover = 0;
    for ($i = 0; $i <= $cover;$i++) {
        //覆盖范围； $i + $nums[$i]
        $cover = max(($i + $nums[$i]),$cover);
        if ($cover >= $n - 1) return true;
    }
    return false;
 }
/**
 * 45. 跳跃游戏 II
 * 至少跳几步，可以到终点
 * 每一步都尽可能的往远处跳； ？？？
 * 最少的步数去增加覆盖范围；
 * 
 * 23114；
 * 很难！！ 思路比较难想到！
 */

function jump($nums) {
    $n = count($nums);
    //已经在终点了，所以return 0；不需要跳；
    // if ($n == 1) return 0;
    $next = 0;
    //跳跃次数；
    $res = 0;
    //当前覆盖范围；
    $cur = 0;
    //在覆盖范围内移动；
    for ($i = 0; $i < $n; $i++) 
    {
        $next = max($i + $nums[$i] ,$next);
        //需要扩展；
        // 到了最远的位置，然后
        if ($cur == $i) {
            //并不是数组的终点
            if($cur != $n -1) {
                //下一步的覆盖范围；
                $res++;
                $cur = $next;
                // $cur 肯定不会超过 $n - 1
                if ($cur >= $n - 1) break;
            } else {
                break;
            }
        }
    }
    return $res;
}

/**
 * jump
 */

 function jump_leetcode($nums) {
    $n = count($nums);
    // if ($n == 1) return 0;
    $cur = 0;
    $next = 0;
    $res = 0;
    for ($i = 0; $i < $n; $i++) {
        //这个才是贪心算法的核心，需要每次都是最大值；
        $next = max(($i + $nums[$i]), $next);
        if ($cur == $i) {
            if ($cur != $n -1) {
                $res++;
                $cur = $next;
                if ($cur >= $n -1) break;
            } else {
                break;
            }
        }
    }
    return $res;
}