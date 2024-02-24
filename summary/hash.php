<?php

/**
 * 哈希表 比较适合于，判断一个元素是否在集合里面出现过；
 * 判断一个元素是否在哈希表中出现过！！！！
 * 就是空间换时间；
 */

/**
 * 有效字母的异位词；
 * eetcode --- LCR 032. 有效的字母异位词
 * // 第一种方式 时间复杂度是O(n) 空间复杂度是 O(n)
 * 统计出现的频率；
 */
function isAnagram($s, $t)
{
    if ($s == $t) return false;
    //可以搞一个出现多少次的二维数组；// 这样的话，空间复杂度是不是太高了？？ 
    $sl = strlen($s);
    $tl = strlen($t);
    //一个去统计出现的频率，另外一个减去出现的频率，如果全部是0那么久代表是是同一个字符；
    $res = [];  //最多26个字母；
    //初始化；
    for ($i = 0; $i < 26; $i++) {
        $res[chr(97 + $i)] = 0;
    }
    // 每个字符串出现的频率；
    for ($i = 0; $i < $sl; $i++) {
        $res[$s[$i]]++;
    }

    for ($i = 0; $i < $tl; $i++) {
        $res[$t[$i]]--;
    }

    //比对方式有问题，不应该去做比对 对不对；
    foreach ($res as $k => $v) {
        if ($v != 0) {
            // 
            return false;
        }
    }
    return true;

    // 顺序是否相等？ 怎么去判断？？？ 就直接判断 这两个字符 想不想等呗？？
}
// $s = "anagram";
// $t = "nagaram";
// echo isAnagram($s,$t);

/**
 * 数组的交集；交集并集 差集 这都是集合的特性； 需要用到php数组的key来做去重和运算；
 * 349. 两个数组的交集
 * 边界条件考虑一下，一个为NULL 另外一个是一个数组；
 */

function intersection($nums1, $nums2)
{
    $count = [];
    $res = [];
    // 利用数组的key 来做去重；
    for ($i = 0; $i < count($nums1); $i++) {
        $count[$nums1[$i]] = 1;
    }

    foreach ($nums2 as $num) {
        if (isset($count[$num])) {
            $res[] = $num;
        }
        //这里很精髓呀；
        //删除了之后 就能保证$res 中的唯一性了；
        //无论有没有 都会去删除；因为 $nums2你没有保证唯一性；
        unset($count[$num]);
    }
    return $res;
}


/**
 * 两数之和；twoSum
 * 
 *  */
function twoSum($nums, $target)
{
    // $nums[$i]
    //两数字之和； $target - $nums[$i]
    //传统的方法 时间复杂度太高了O(n^2) 
    // $res = [];
    // $n = count($nums);
    // for ($i = 0; $i < $n; $i++) {
    //     $mid = $target - $nums[$i];
    //     for ($j = $i + 1; $j < $n; $j++) {
    //         if ($mid == $nums[$j]) {
    //             $res[] = [$i,$j];
    //             return $res;
    //         }
    //     }
    // }
    // return $res;

    //哈希表的解决方案--- 优化查询$target - x的时间复杂度；

    // 构建哈希表；map保存的是遍历过的元素；
    // 时间复杂度是O(n) 但是空间复杂度变成了O(n)
    $map = [];
    $res = [];
    $n = count($nums);
    for ($i = 0; $i < $n; $i++) {
        if (isset($map[$target - $nums[$i]])) {
            //只有一对数值，所以可以直接出来；
            $res[] = $i;
            $res[] = $map[$target - $nums[$i]];
            return $res;
        }
        $map[$nums[$i]] = $i;
    }
}

//  var_dump(twoSum([2,7,11,15],9));

/**
 * 454. 四数相加 II
 * 哈希 map
 * 不需要去重；
 * 时间复杂度是O(n^2) //空间复杂度是O(n)
 * 如果用四层for 循环那么会是n^4的时间复杂度；
 *  */
function fourSumCount($nums1, $nums2, $nums3, $nums4)
{
    // $nums1[$i] + $nums2[$j] +$nums3[$x]+ $nums[$y] = 0;
    $map1 = [];
    $count = 0;
    $n = count($nums1);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            // 只不过会报错而已；
            //一定要 存储出现的次数；
            if (!isset($map1[$nums1[$i] + $nums2[$j]])) {
                $map1[$nums1[$i] + $nums2[$j]] = 1;
            } else {
                $map1[$nums1[$i] + $nums2[$j]]++;
            }
        }
    }
    // return $map1;
    for ($x = 0; $x < $n; $x++) {
        for ($y = 0; $y < $n; $y++) {
            if (isset($map1[0 - $nums3[$x] - $nums4[$y]])) {
                $count += $map1[0 - $nums3[$x] - $nums4[$y]];
            }
        }
    }
    return $count;
}

// var_dump(fourSumCount([1,2],[-2,-1],[],[]));

/**
 * 三数之和；
 * 三元组 是去重的，这点是最麻烦的！！！--- 直接用两数之和的方法，用map来去重，太麻烦了；
 * 所以最好不要用map 来做； 去重会很麻烦； 去重很麻烦，hash 写的算法是一个半成品；
 *  */

function threeSum($nums)
{
    // $nums[$i] + $nums[$j] + $nums[$x] == 0;并且 i != y != x;
    //hash
    // $n = count($nums);
    // $map = [];
    // $res = [];
    // //i+j
    // for ($i = 0; $i < $n; $i++) {
    //     for ($j = $i+1; $j < $n; $j++) {
    //         $c =0-$nums[$i] - $nums[$j];
    //         if (isset($map[$c]) && $i != $c && $j != $c) {
    //             $res[] = [$nums[$i],$nums[$j],$nums[$c]];
    //         }
    //         // 保存的是已经遍历过的元素；
    //         $map[$nums[$i]] = $i;
    //     }
    // }
    // return $res;

    // 双指针；时间复杂度(n^2) 空间复杂度是O(1)
    $res = [];
    sort($nums);
    if ($nums[0] > 0) return [];
    $n = count($nums);
    for ($i = 0; $i < $n; $i++) {
        //i的去重； [-1,-1,2]当i = -1的时候 前面一个元素也是一个1 ，那么就开始计算下一个元素；
        if ($i > 0 && $nums[$i] == $nums[$i - 1]) continue;
        //双指针的初始化；
        $left = $i + 1;
        //end
        $right = $n - 1;
        //遍历
        while ($right > $left) {
            if ($nums[$i] + $nums[$left] + $nums[$right]  > 0) {
                $right--;
            } elseif ($nums[$i] + $nums[$left] + $nums[$right] < 0) {
                $left++;
            } else {
                $res[]  = [$nums[$i], $nums[$left], $nums[$right]];
                //left right 的去重；  [0,0,0,0]; 0 0 0 0-1-1-1-1 1 1 1 1 去重;
                while ($right > $left && $nums[$left] == $nums[$left + 1]) $left++;
                while ($right > $left && $nums[$right] == $nums[$right - 1]) $right--;

                // 找到答案时，双指针同时收缩
                $right--;
                $left++;
            }
        }
    }
    return $res;
}
//  var_dump(threeSum([-1,0,1]));

/**
 * 四数之和；
 * 18. 四数之和
 *多注意 剪枝 和去重；
 * 这边可以做很多的剪枝的操作；
 */

function fourSum($nums, $target)
{
    $res =  [];
    sort($nums);
    $n = count($nums);
    //一重剪枝
    if ($nums[0] >= 0 && $nums[0] > $target) return [];

    for ($k = 0; $k < $n; $k++) {
        if ($k > 0 && $nums[$k] == $nums[$k - 1]) continue;
        for ($i = $k + 1; $i < $n; $i++) {
            if ($nums[$k] + $nums[$i] > $target && $nums[$k] + $nums[$i] >= 0) break;
            // 去重操作；
            // 条件就是$i > $k + 1
            if ($i > $k + 1 && $nums[$i] == $nums[$i - 1]) continue;
            //初始化；
            $left = $i + 1;
            $right = $n - 1;

            while ($right > $left) {
                if ($nums[$i] + $nums[$k] + $nums[$left] + $nums[$right] > $target) {
                    $right--;
                } elseif ($nums[$i] + $nums[$k] + $nums[$left] + $nums[$right] < $target) {
                    $left++;
                } else {
                    $res[] = [$nums[$k], $nums[$i], $nums[$left], $nums[$right]];

                    while ($right > $left && $nums[$left] == $nums[$left + 1]) $left++;
                    while ($right > $left && $nums[$right] == $nums[$right - 1]) $right--;
                    $right--;
                    $left++;
                }
            }
        }
    }
    return $res;
}


/**
 * leetcode128最长连续序列的长度是多少？
 * 索引数组；
 * //todo 为什么我的运行时间那么长；
 * 牵扯到查询某个值 在不在某个数组的操作的时候一般都会用到哈希表；
 *  */ 
class Solution128 {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    /**
     *  时间复杂度是O(n) 空间复杂度是O(n);
     */
    function longestConsecutive($nums) {
        $res = 0;
        //最长连续序列；
        $map = [];
        for ($i = 0; $i < count($nums); $i++) {
            $map[$nums[$i]] = 1;
        }
        //traverse
        for ($i = 0; $i < count($nums); $i++) {
            // m -1 没在里面那么就可以做首部；
            if (!$map[$nums[$i] - 1]) {
                $j = $nums[$i] + 1;
                $len_seq = 1;
                while ($map[$j]) {
                    $len_seq++;
                    $j++;
                }
                $res = max($len_seq, $res);
            }
        }
        return $res;
    }
}
/**
 * 
 * extra extends 额外的扩展；
 */
/**
 * php的数组就是一种哈希表；
 * 哈希表在算法中比较常用的三种结构：
 * 数组 ===> 索引数组；key值不能太大，不能只有三个key，但是有一个key 很大的时候就不能用数组；
 * set ===>  数组的key；数组的key ，集合的数据具有唯一性；我们一般用的是数组的key来做集合，是可以做去重处理的；array_keys(); 获取key就是获取集合；
 * map ===> 关联数组； 就是映射数组； 
 */

/**
 * demo
 */
// 判断某个key 是否存在一定要用isset ，因为会存在值是0的情况；
//  $arr = [1];
// var_dump($arr[3]);die; // NULL
//  if ($arr[3]) {
//     echo "null";
//  } else {
//     echo 'not null';
//  }


/**
 * NULL  第一次是NULL 
 * 是可行的；必须 empty(0) == empty(NULL)
 */
// $count = NULL;
// $count++;
// echo $count;

/**
 * array_unique()去重；
 */

//  $res = [[0,1,-1],[1,-1,0],[2,-1,-1]];
//  //重复的部分；；
//  $res = array_unique($res,SORT_STRING );
//  var_dump($res);

/**
 * 三数之和 去重问题；i + left + right == 0; i 去重逻辑；left 和 right 的去重逻辑；
 * 多注意 全0数组 [0,0,0,0,0];多注意；
 */


/**
 * 数组的遍历
 * 长度是一个整型$n , 和变化长度count($arr)的区别！！！
 * 注意这个区别！！！
 */
$arr = [1, 2, 3, 4];
//变成3了；
// for ($i = 0; $i < count($arr); $i++) {
//     echo count($arr)."---"; // 一直都是4，并不会改变，unset();

//     if ($i == 2) { 
//         unset($arr[$i]);
//     } else {
//         echo $arr[$i];  //12 并不会输出4，因为count()长度发生了改变；
//     }
// }
// var_dump($arr,count($arr));
// die;

// $n = 4;
// for ($i = 0; $i < $n; $i++) {
//     if ($i == 2) { 
//         unset($arr[$i]);
//     } else {
//         echo $arr[$i];
//     }
// }


// if else 可以有化成   if  continue 语句；都是一样的；

// for ($i = 1; $i < $n; $i++) {
//     if ($i = 1) {
//         echo "logic 1!业务逻辑1!!";
//         continue;
//     }
//     echo "logic 2!业务逻辑2!!";
// }


