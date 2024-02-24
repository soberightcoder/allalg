<?php

/**
 *数组中双指针用的 真的是挺多的；满足某些条件的数组； 
 * 滑动窗口主要用于 子数组或者子字符串的问题；
 *  */
/**
 * 有序数组的二分法；
 * 有序数组的二分查找法，注意边界问题；左闭右闭；
 * leetcode -- 704  ---找到之后就返回下表；
 * array_search();找到之后返回key;
 * 时间复杂度是logn ,空间复杂度是O(1)
 */
function binarySearch($nums, $target)
{
    //左闭右闭；
    $left = 0;
    $n = count($nums);
    $right = $n - 1;
    while ($left <= $right) {
        //中间值 怎么去计算，分区点，怎么去计算；
        //防止 溢出的问题，可以使用(left + right) /2 
        $mid =  $left + (($right - $left) >> 1); //防止溢出的问题；
        if ($nums[$mid] > $target) {
            $right = $mid - 1;
        } elseif ($nums[$mid] < $target) {
            $left = $mid + 1;
        } else {
            return $mid;
        }
    }
    //not find
    return -1;
}
// $arr = [-1,0,3,5,9,12];
// $target = 9;
// echo binarySearch($arr, $target);
/**
 * 
 *很经典的一个数组的问题；好好看一下；
 *删除数组的元素  并且返回数组的大小；
 *删除一个元素的时候，需要往前移动做一个覆盖；时间复杂度是O(n);
 *双指针；--- O(n)   -- 空间复杂度是O(1);
 * 27. 移除元素
 * 快慢指针；
 * $slow 表示的是更新位置在哪里；
 * $fast 获取符号要求的字母；
 */

$arr = [1, 2, 3, 4, 5, 6];
function erease($nums, $val)
{
    $slow = 0;
    $n = count($nums);
    for ($fast = 0; $fast < $n; $fast++) {
        //不等于才会移动$slow并且保存；
        if ($nums[$fast] != $val) {
            $nums[$slow] = $nums[$fast];
            $slow++;
        }
        // 等于只需要移动$fast就可以了；并不会保存$slow;
    }
    //注意数据还是[1,3,4,5,6,6];但是返回的数据长度是5；
    // var_dump($nums);
    return $slow;
}
// echo erease($arr, 2);
// var_dump($arr);

/**
 * 在PHP中，使用unset函数删除数组中的一个元素的时间复杂度是O(1)。这意味着无论数组的大小如何，删除单个元素所需的时间是恒定的。这是因为unset函数只是将指定索引位置的元素标记为未定义，并不会移动其他元素或重新索引数组。因此，它的时间复杂度是常数级别的，不受数组大小的影响。
 * 没有数组的迁移 ，所以时间复杂度才会到O(1)
 *  */
// unset($arr[1]);// 仅仅是把1索引的值，修改成了未定义，所以实现复杂度为1；
// var_dump($arr);  就没有索引 1了；

//但是你要删除某个值的时候肯定牵扯到数组的迁移；

function removeElement($nums, $val)
{
    $n = count($nums);
    $slow = 0;
    for ($fast = 0; $fast < $n; $fast++) {
        if ($nums[$fast] != $val) {
            $nums[$slow] = $nums[$fast];
            $slow++;
        }
    }
    //$slow代表的是待插入元素 ，也就是和数组的长度相等的；
    return array_slice($nums, 0, $slow - 1);
    // return $slow;
}
// var_dump(removeElement($arr,2));

/**
 * 有序数组的平方；
 * leetcode --- 
 * 977. 有序数组的平方
 * 双指针操作的细节；
 *  */

/**
 * @param Integer[] $nums
 * @return Integer[]
 */

/**
 *优化一下时间复杂度太高的问题；
 * 有点类似于 有序数组的合并；
 */
function sortedSquares($nums)
{
    $res = [];
    $n = count($nums);
    $k = $n - 1;
    //$i 和 $j 就是双指针； 因为是左闭有闭呗；
    for ($i = 0, $j = $n - 1; $i <= $j;) {
        //最大值 最有可能是最小值 或者 是最大值；
        if (pow($nums[$i], 2) > pow($nums[$j], 2)) {
            $res[$k] = pow($nums[$i], 2);
            $k--;
            $i++;
        } else {
            $res[$k] = pow($nums[$j], 2);
            $k--;
            $j--;
        }
    }
    //返回的结果php 会看成关联数组；所以排序顺序是有问题的；只能通过array_unshift()；来实现，但是array_unshift();
    //leetcode 有问题，这种解决方案是对的；
    return $res;
}
// $arr = [-4,-1,0,3,10];
// $mid = sortedSquares($arr);
// var_dump($mid);

/**
 *209. 长度最小的子数组 
 *  滑动动窗口和 双指针的区别？
 * 注意这里需要做持续移动，所以用 while() 而不是用if
 *  */

function minSubArrayLen($nums, $target)
{
    //双指针； -- 滑动窗口也是双指针的一种？？？？
    $j = $i = 0;
    $n = count($nums);
    $res = PHP_INT_MAX; // max最大值；
    $sum = 0;
    for (; $j < $n; $j++) {
        $sum += $nums[$j];
        while ($sum >= $target) {
            // 计算长度都是这么计算 两个（indexR - $indexL） + 1 来计算长度；
            $minSubL = ($j - $i + 1);
            $res = min($res, $minSubL);
            // 向后移动一位；
            $sum -= $nums[$i];
            $i++;
        }
    }
    return $res == PHP_INT_MAX ? 0 : $res;
}
// $arr = [1,2,3,4,5];

// echo minSubArrayLen($arr, 15);

/**
 * 螺旋矩阵 -- leetcode -- 54
 *  */

/**
 * @param Integer[][] $matrix
 * @return Integer[]
 */
function spiralOrder($matrix)
{
    $m = count($matrix); //行
    $n = count($matrix[0]); //列
    //用左闭右开的规则来进行运算；
    // 起始位置；
    $startX = 0;
    $startY = 0;
    // 偏移量；
    $offset = 1;
    $res = [];
    $mid = ceil($n / 2);
    // end condition 每次循环会掉下来两次；
    while ($n >> 1) {
        for ($i = $startX; $i < $m - $offset; $i++) {
            $res[] = $matrix[$i][$startY];
        }
        //注意上面的$i 已经是最后一个元素了；
        for ($j = $startY; $j < $n - $offset; $j++) {
            $res[] = $matrix[$i][$j];
        }
        //反序 -- 
        for (; $i > 0; $i--) {
            $res[] = $matrix[$i][$j];
        }
        for (; $j > 0; $j--) {
            $res[] = $matrix[$i][$j];
        }

        // 运行完一圈
        $startX++;
        $startY++;
        $offset++;
    }
    // if ($n & 1) {
    //     $res[$mid][$mid] = pow($mid, 2);
    // }
    return $res;
}
/**
 * leetcode --- 59
 * 
 */

function generateMatrix($n)
{
    //用左闭右开的规则来进行运算；
    $res = array_fill(0, $n, array_fill(0, $n, 0));
    // 起始位置；
    $startX = 0;
    $startY = 0;
    // 偏移量；
    $offset = 1;
    $res = [];
    $count = 1;
    $mid = floor($n / 2);
    $loop = $n >> 1;
    // end condition 每次循环会掉下来两次；
    while ($loop > 0) {
        //注意上面的$i 已经是最后一个元素了；
        for ($j = $startY; $j <  $n - $offset; $j++) {
            $res[$startX][$j]  = $count;
            $count++;
        }

        for ($i = $startX; $i < $n - $offset; $i++) {
            $res[$i][$j] = $count;
            $count++;
        }

        //反序 --这个顺序有问题；需要查看一下顺序；
        for (; $j > $startY; $j--) {
            $res[$i][$j] = $count;
            $count++;
        }

        for (; $i > $startX; $i--) {
            $res[$i][$j] = $count;
            $count++;
        }


        // 运行完一圈
        $startX++;
        $startY++;
        $offset += 2;
        $loop--;
    }
    // 奇数；
    if ($n ^ 1) {
        $res[$mid][$mid] = $count;
    }
    return $res;
}
// var_dump(generateMatrix(3));

/**
 *  leetcode  442 --- 数组中重复的数据；
 * 其实关键点实在 如何提高查找元素的效率！！！  直接上哈希表，但是使用了哈希表但是效率肯定就变低了；
 *  */
class Solution
{

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    // 暴力求解 -- 时间复杂度O(n^2)  因为数据的数量是10^5所以时间复杂度太高了！！！
    public $res = [];
    function findDuplicates1($nums)
    {
        $n = count($nums);
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                if ($nums[$i] == $nums[$j]) {
                    $this->res[] = $nums[$i];
                }
            }
        }
        return $this->res;
    }

    // 以内内圈的for循环查询速度太慢了，我们进行优化；
    // 可以 用二分查找；
    //  就是想告诉你们，查找数组的时候可以使用排序+ 二分法来提高查询效率；
    // 下面的代码没有实现//todo 以后去实现把；
    // 时间复杂度是nlogn 空间复杂度是原地的；因为nlogn 快排 就是原地排序；
    function findDuplicates2($nums)
    {
        sort($nums); //nlogn
        $n = count($nums);
        for ($i = 0; $i < $n; $i++) {
            $res = $this->binarySearch(array_slice($nums, $i + 1), $nums[$i]);
            if ($res > 0) $this->res[] = $nums[$i];
        }
        return $this->res;
    }

    //二分查找左闭右闭；
    function binarySearch($nums, $val)
    {
        $left = 0;
        $right = count($nums) - 1;
        while ($right >= $left) {
            $mid = $left + (($right - $left) > 1);
            if ($nums[$mid] > $val) {
                $right = $mid - 1;
            } elseif ($nums[$mid] < $val) {
                $left = $mid + 1;
            } else {
                return $mid;
            }
        }
        //没找到
        return -1;
    }
    //排序 + 数组的双指针方法；； --- 时间复杂度也是  nlogn
    //时间复杂度是nlogn 效率也很低；
    function findDuplicates3($nums)
    {
        sort($nums);
        $n = count($nums);
        for ($i = 0; $i < $n; $i++) {
            // 最多有两个重复；
            if ($i < $n - 1 && $nums[$i] == $nums[$i + 1]) {
                $this->res[] = $nums[$i];
            }
            // // 2
            // if ($i > 0 && $num[$i] == $$nums[$i - 1]) {
            //     $this->res[] = $nums[$i];
            // }
        }
        return $this->res;
    }
    //哈希表； --- 索引数组；
    //时间复杂度是O(n) 但是空间复杂度是O(1);
    function findDuplicates4($nums)
    {
        $map = [];
        $n = count($nums);
        // 注意一开始不能直接把所有的
        // for ($i = 0; $i < $n; $i++) {
        //     $map[$nums[$i]] =  1;
        // }

        for ($i = 0; $i < $n; $i++) {
            if (isset($map[$nums[$i]])) {

                $this->res[] = $nums[$i];
            }
            $map[$nums[$i]] = 1;
        }
        return $this->res;
    }

    // 因为保存的数据只有 1-n 所以数据比较巧妙；/
    function findDuplicates5($nums) {
        // 
        foreach($nums as $num) {
            $index = abs($num) - 1;//这个数据已经遍历过了；
            if ($nums[$index] > 0) {
                $nums[$index] = -$nums[$index];
            } else {
                $this->res[] = abs($num);
            }
        }
        return $this->res;
    }

}

/**
 * 接雨水
 */


/*
 *extra extends 额外的扩展代码；测试代码； 
 * 
 *  */
// php 数(组怎么去获取行列；

$arrc[] = [1, 2, 3];
$arrc[] = [4, 5, 6];
$arrc[] = [7, 8, 9];
// echo count($arrc);//这就是行；
// // 获取行数
// echo "\n";
// 获取列数
// echo count($arrc[0]);

//  在PHP中，使用除法运算符（/）时，所以用除法运算法则，一定要取整，会得到浮点数结果。因此，5/2将得到2.5。而使用位移运算符（>>）时，会执行右移操作，将二进制表示的数字向右移动指定的位数。因此，5的二进制表示是101，将101向右移动1位得到10，对应的十进制数是2。
echo 5 / 2;
echo "\n";
echo 5 >> 1;
echo "\n";
echo ceil(5 / 2);
/**
 * 判断奇数和偶数
 */
$n = 6;
if ($n & 1) {
    echo "奇数";
} else {
    echo "偶数";
}


/**
 * php数组 先要 充实起来数据；
 * 就是malloc 提前给数组申请内存把；
 */
//   $res = array_fill(0, $n, array_fill(0, $n, 0));
//   var_dump($res);


/**
 * 数组去重部分； ---- 相邻元素的去重！！！
 * $arr[$i] == $arr[$i -1]
 * $arr[$i + 1] == $arr[$]
 * 上面两种去重方式的区别？ 
 *  好像不是用于去重， 我们要做的是 不能有重复的三元组，但三元组内的元素是可以重复的！
 * 所以我们这里要用 {-1,-1,2}  -1 被用过一次了，所以跳过；
 * //todo 这个还需要多去理解一下；
 * */

$arr = [1, 1, 2, 3, 4, 4, 4, 4, 5];
$res = [];
for ($i = 0; $i < count($arr); $i++) {
    //一般使用去做去重；
    if ($i > 0 && $arr[$i] == $arr[$i - 1]) continue;
    // if ($arr[$i] == $arr[$i+1]) continue;// 注意整个有可能会溢出；
    $res[] = $arr[$i];
}
var_dump($res);
