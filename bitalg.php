<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:44
 */
/**
 * 位运算
 * 几个特殊的位运算 规则：
 * 1.
 */

/**
 *  二进制的补码；
 *  0111 ===> 7
 *  0000 ===> 0
 *  1111 ===> -1
 *  1000 ===> -8;
 */
/**
 * 把一个数值(整型) 抓换成二进制
 * php 一般都是有符号的64位；
 */

function transbit($nums) {
    for ($i = 63; $i >= 0; $i--) {
        echo ($nums >> $i) & 1 ? 1 : 0;
    }
}

//查看一个二进制有多少位1
function transbitpro($nums) {
    $count = 0;
    //不能去掉最后一位符号0；
    //整数 会变成0负数可能会变成PHP_INT_MIN
    while ($nums) {
        //负数； -1  == 64位置；
        if ($nums == PHP_INT_MIN) {
            $count++;
            break;
        }
        $nums = ($nums) & ($nums - 1);
        $count++;
    }
    return $count;
}

//transbit(-1111);
//echo transbitpro(15);//4 // 4
//echo transbitpro(-1);//php 有bug ，永远不会是0；一直是1；死循环！！
//double & int?//溢出了吗？直接就卡了？？
//var_dump((PHP_INT_MIN - 1) & PHP_INT_MIN)
/**
 * 判断一个数得正负 求这个数的绝对值；取反+1就是求一个数的绝对值；
 * -1  补码 就是-1
 * 位运算
 * */

function is_neg($i) {
    $n = $i >> 63;
    return $n == 0 ? $i : (~$i + 1);
}

//echo is_neg(-1);


/**
 * 变换符号
 */
function transSymbol($nums) {
    return ~$nums + 1;
}

/**
 * 求奇偶
 * 1位奇数 0为偶数
 */

function is_if($nums) {
    return ($nums & 1) ? 1 : 0;
}

/**
 * add 两个数值相加 用位运算
 * 异或操作 任何一个数异或0都是本身
 * 任何一个数异或1则为0;
 * $a  $b --->
 */

function addByBit($a,$b) {

    while($b != 0) {
        //进位； 进位等于0，则结束；
        $c = ($a & $b) << 1;
        //本位;
        $a = $a ^ $b;
        $b = $c;
    }
    return $a;
}
echo addByBit(1,-2);


/**
 *
 */



 //
echo floor(microtime(true) * 1000) | 0 ;  //毫秒级别的时间戳；

//这边是什么意思？？？？？ /
//
echo $maxTimeDiff = -1 ^ (-1 << 41);
echo "\n";
echo (-1 << 41);

// function transbit($nums) {
//     for ($i = 63; $i >= 0; $i--) {
//         echo ($nums >> $i) & 1 ? 1 : 0;
//     }
// }
echo "\n";
transbit(-1 ^ (-1 << 41));
echo "\n";
// echo bindec("0000000000000000000000011111111111111111111111111111111111111111");//二进制  转换成10机制把；decimal


/**
 * 查看一个数的取值范围；
 * eg: 假如一个数有12位的二进制数；那么这个二进制数的取值范围就是
 * (0,-1 ^ (-1 << 12))
 * 如果是8位二进制数的取值范围就是 0 - 2^8 -1; 是这么的一个取值范围；
 *  */
echo -1 ^(-1 << 12); // 0- 4095 // 其实这就是一个最大值；最大值；求出范围的最大值；
