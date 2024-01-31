<?php
/**
 * String  字符串操作；
 * 字符串和数组操作基本差不多！！ 最多是语言上的一些不同；字符串的底层本质都是字符数组；
 */

/**
 *翻转字符串； 
 * 原地操作；
 * 344. 反转字符串
 * 注意输入的参数是字符数组，把他当成数组来看；
 *  */

function reverseString(&$s)
{
    // 必须是字符串；
    $len = count($s);
    $l = 0;
    $r = $len - 1;
    while ($r > $l) {
        //swap
        $mid = $s[$l];
        $s[$l] = $s[$r];
        $s[$r] = $mid;
        $r--;
        $l++;
    }
}

function reverse(&$s) {
        // 必须是字符串；
        $len = strlen($s);
        $l = 0;
        $r = $len - 1;

        while ($r > $l) {
            //swap
            $mid = $s[$l];
            $s[$l] = $s[$r];
            $s[$r] = $mid;
            $r--;
            $l++;
        }
}
/**
 *541.反转字符串II 
 * 注意这个固定思维，字符串一定要一个一个字符的移动，可以2K个字符的移动；
 *  */

function reverseStr($s, $k)
{
    $size = strlen($s);
    // 假如 $k = 2;
    // 0 1 2 3 4 5  6 7  ； 所以   $i的第一次反转是0 - 3 的反转； 而$i + 2$k的取值范围却是 0  4 
    for ($i = 0; $i < $size; $i += 2 * $k) {
        //前k个字符来做反转；
        // 因为下面做了 -1 操作 所以$i + $k 是可以等于$size 的；
        //if 里面的判断 和reverse 的输入条件
        // 剩下的超过$k那么就反转前$k的字符；
        if ($i + $k <= $size) {
            // 0 - $k
            reverse1($s,$i,$i + $k - 1);
            continue;
        }
        //剩下的元素数目 小于 $k
        reverse1($s,$i,$size - 1);

    }
}
/**
 *字符串的反转函数；
 * 左闭右开 （） 是什么东西？？？ 这里需要查看一下；
 * 下面我实现的是左闭区间 右闭区间；
 */
function reverse1(&$s, $i, $j)
{
    //左闭右开区间；
    // $left = $i; 
    // $right = $j - 1;

    //左闭右闭区间；
    $left = $i;
    $right = $j;

    while ($right > $left)  {
        $mid = $s[$left];
        $s[$left] = $s[$right];
        $s[$right] = $mid;
        $left++;
        $right--;
    }   
}
/**
 * 左闭右开；
 */
function reverse2(&$s,$i,$j) {
    $left = $i;
    $right = $j - 1;

    while($right > $left)  {
        $mid = $s[$left];
        $s[$left] = $s[$right];
        $s[$right] = $mid;
        $right--;
        $left++;
    }
}

class Solution {

    /**
     * @param String $s
     * @param Integer $k
     * @return String
     */
    // 每计数至 2k 个字符，就反转这 2k 字符中的前 k 个字符。  最多10000个字符；
    function reverseStr($s, $k) {
        $n = strlen($s);

        for ($i = 0; $i < $n; $i += 2*$k) {


            // 下面的两种计算方法都是可以的； 
            if ($i + $k < $n) {
                $this->reverse2($s,$i,$i+$k);
                continue;
            }
            // 因为$n肯定是不可能达到的，所以肯定要减去1；
            // if ($i + $k <= $n) {
            //     $this->reverse1($s,$i,$i+$k -1);
            //     continue;
            // }
            $this->reverse1($s,$i,$n - 1);
        }
        return $s;
    }


//这是左闭 右闭区间的反转；
//这里的开闭特性都是通过参数来进行传输的；
    function reverse1(&$s,$i,$j) {
        $l = $i;
        $r = $j;
        while ($r > $l) {
            $mid = $s[$l];
            $s[$l] = $s[$r];
            $s[$r] = $mid;
            $l++;
            $r--;
        }
    }
    //左闭 右开；
    function reverse2(&$s,$i,$j) {
        $l = $i;
        $r = $j - 1;

        while ($r > $l) {
            $mid = $s[$l];
            $s[$l] = $s[$r];
            $s[$r] = $mid;
            $l++;
            $r--;
        }
    }
}


/**
 * 反转字符串里面的单词； 
 * 151. 反转字符串中的单词
 * --- 双指针；
 *  */
 $str = '  ab  c  ';
function reverseWords($s) {
    //多余的空格删除； 要求空间复杂度是O(1) // 起始可以遍历一遍然后删除；用额外的O(n)的空间；
    //双指针法 --- 空间复杂度O(1)
    removeExtraSpaces($s);
    $n = strlen($s);
    //先对整体字符串的反转 -- 就是对字符串种空格的反转；
    reverse1($s,0,$n - 1);// reverse1是左闭右闭区间的；
    //然后再对单词做一个反转；-- 对单词的反转；
    //也是类似于双指针；
    $start = 0;
    //注意这个取值范围；
    for ($i = 0; $i <= $n; $i++) {
        // 空格或者串尾表示一个单词的结束；
        if ($i == $n || $s[$i] == ' ') {
            reverse1($s,$start,$i -1);
            //因为会有一个空格；
            $start = $i + 1;
        }
    }
    // return $s;
    // var_dump($s); 
}
reverseWords($str);die;

function removeExtraSpaces(&$s){
    $slow = 0;   
    for ($i = 0; $i < strlen($s); $i++) {
        if ($s[$i] != ' ') {  //去除所有的空格；
        
            if ($slow != 0){  // 给单词之间添加空格！！！！保存的是空格；  怎么添加的？slow != 0说明不是第一个单词，需要在单词前添加空格。
                $s[$slow] = ' '; 
                $slow++;
            } 

            while ($i < strlen($s) && $s[$i] != ' ') {  //补上该单词，遇到空格说明单词结束。这里是保存的单词；
                $s[$slow] = $s[$i];
                $slow++;
                $i++;
            }
        }
    }
    // 移动覆盖处理，丢弃多余的脏数据。
    $s = substr($s,0,$slow);
    return ;
}

// removeExtraSpaces($str);
// var_dump($str);


/**
 * KMP 算法 在某个字符串中 查找某个字符串；
 * 如果 需要用暴力求解的时候需要
 * 去看KMP 章节；
 */



/**
 *  extra extends 额外的扩展；
 * 一般函数的参数范围是左闭右开；
 * 考虑边界条件的时候可以带入参数尝试一下；
 */


 /**
  *数组的范围讨论；
  * 好好看一下上面的串反转II 关于区间的选择问题；
  *  起始下面就是范围边界的原型；
  * 数组操作的两种传参方式；
  * -- 左闭右开；
  * -- 左闭右闭；
   */
echo "\n";
$arr = [1,2,3,4,5];
$n = count($arr);
//那么我们遍历的范围就是左闭右开；

for ($i = 0; $i < $n; $i++) {
    echo $arr[$i];
}
echo "\n";
//左闭右闭；
for ($i = 0; $i <= $n - 1; $i++) {
    echo $arr[$i];
}
/**
 * 测试php一段代码运行了多少ms
 * 1s = 1000ms = 1000000us
 * microtime(true) // 单位是s的换算单位；
 * 要转换成ms  必须乘以 1000；·
 * // 计算执行时间并转换为毫秒
 * $execution_time_ms = ($end_time - $start_time) * 1000;
 *  */

// $starTime = microtime(true);
// // var_dump($starTime);
// for ($i = 0; $i < 10; $i ++) {
//     sleep(1);
// }
// $endTime = microtime(true);

// $execTime = ($endTime - $starTime);
// var_dump($execTime);

/**
 *遍历的方法 去除字符串里面的额外空格； 
 * 时间复杂度O(n) 空间复杂度 O(n)
 *  */

$str = '  ab  c  ';
function trimByTraverse($str) {
    //额外的内存空间；
    $str1 = '';
    $n = strlen($str);
    $i = 0;
    //开头 空格的删除；
    while ($str[$i] == ' ') {
        $i++;
    }
    // 删除末尾的；
    $j = $n - 1;
    while ($str[$j] == ' ') {
        $j--;
    }
    //删除中间多余的空格；
    for (; $i <= $j; $i++) {
        // 后向判断；去重；
        if ( $i > 0 && $str[$i] == $str[$i - 1] && $str[$i] == ' ') {
            continue;
        }
        $str1 .= $str[$i];
    }
    return $str1;

}

// echo trimByTraverse($str);

/**
 * php没有resize 但是可以使用
 * $arr[4] = 0;
 * $arr[5] = 0; 来做覆盖；
 * 或者使用 array_slice();来做数据截取；resize 成一个新的数组；
 */
$arr = [1,2,3,4];
$tmp = array_slice($arr,0,3);
//用这个方法来进行resize；
// var_dump($tmp);

/**
 * 在PHP中，使用unset函数删除数组中的一个元素的时间复杂度是O(1)。这意味着无论数组的大小如何，删除单个元素所需的时间是恒定的。这是因为unset函数只是将指定索引位置的元素标记为未定义，并不会移动其他元素或重新索引数组。因此，它的时间复杂度是常数级别的，不受数组大小的影响。
 * 没有数组的迁移 ，所以时间复杂度才会到O(1)
 *  */ 
// unset($arr[1]);// 仅仅是把1索引的值，修改成了未定义，所以实现复杂度为1；
// var_dump($arr);

//但是你要删除某个值的时候肯定牵扯到数组的迁移；
//用array_slice 来去除多余的空间大小；
function removeElement($nums, $val) {
    $n = count($nums);
    $slow = 0;
    for ($fast = 0; $fast < $n; $fast++) {
        if ($nums[$fast] != $val) {
            $nums[$slow] = $nums[$fast];
            $slow++;
        }
    }
    //$slow代表的是待插入元素 ，也就是和数组的长度相等的；
    return array_slice($nums,0,$slow);
    // return $slow;
}
var_dump(removeElement($arr,2));