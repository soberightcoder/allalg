<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 0:13
 */
$i = 1;
var_dump($_SERVER['argv']);
var_dump(getenv("name"));
for ($i = 1; $i < 100; $i++) {
    $i = $i + 1;
    echo $i;
}
echo "ceshi";
die;

 //Intelephense 是一个高性能、跨平台的 PHP 语言服务器，遵循语言服务器协议 （LSP）。 language server protocol
// 当前目录的自动加载

//function load($className) {
//   require_once "./".$className;
//}
//
//spl_autoload_register('load');
/**
 *  phpstorm ideavim 不能实现一个完全的scrolloff！！！
 * 但是我们这里只能使用 scrolloff + virtual space + ctrl+M来实现这个功能！ 就是比较麻烦！！！
 */
echo "success";

$a=array(5,15,25);
echo array_sum($a);


/**
 * 数组的相邻的比较
 * 注意事项！
 */

function compare($arr) 
{
    $n = count($arr);
    for ($i = 0; $i < $n - 1;$i++) {
        if ($arr[$i + 1] > $arr[$i]) { //后面的比前面的大

        }
    }
    // 0=< $i  < $n
    //   1 < $i+1 < $n + 1 就溢出了，的时候，那么$i 的取值范围要发生变化；
    for ($i = 1; $i < $n; $i++) {
        if ($arr[$i - 1] < $arr[$i]){ //后面的比前面的大

        }
    }

}

compare([1,2,3,4]);

/**
 * php数组支持二维数组的push吗？
 *  array_push();
 *  array_pop(); //尾部
 * arry_unshift();头部插入；
 *  array_shift(); 头部删除；
 */

 function ddarrtest() 
 {
    //可以弹出来；
    $arr = [[1,2],[2,3],[3,4]];
    $res = array_pop($arr);
    var_dump($res);
 }
 ddarrtest();

//
/**
 * 一个数组中，只把大于0的数相加 
 * max的用法 很精髓；
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

/**
 * 动态的去增加增量；
 *  leetcode -- 55;
 * 贪心算法；
 */


function canJump($nums) {
    $n = count($nums);
    $cover = 0;
    //这个是增量的条件；变化的条件；
    for ($i = 0; $i <= $cover; $i++) {
        $cover = max($i + $nums[$i],$cover);
        if ($cover >= $n - 1) return true;
    }
    return false;
}

//allag
echo "ceshi";