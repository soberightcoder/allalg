<?php

/**
 * kmp算法 就是经常解决，给你一个字符串，判断某个子串是否在这个字符串中出现过；
 * kmp 字符串匹配问题；
 * 文本串  --- aabaabaaf  --- n
 * 匹配串 --- aabaaf --- m  
 * 暴力匹配算法 -- m * n 
 * KMP 不匹配之后并不会直接返回到开头 而是根据  最长相等前后缀$next  从那个位置开始匹配 需要根据 $next 去匹配；
 * KMP 时间复杂度是O(n)
 * 最长相等前后缀 --- $next  最长相等前后缀；
 * $next 数组 --- 也是前缀表； $next 数组 要告诉我们要跳到哪里！！！
 */

/**
 * code --- 实现$next 前缀表； 
 * aabaaf
 * 前缀表  010120 $next 表
 * $next数组  是遇到冲突的位置，我们要向前回退，这是$next 数组的核心所在；
 * 
 * 
 * 前缀是包含首字母 但是不包含 尾字母的所有子串；
 * a
 * aa
 * aab
 * aaba
 * aabaa
 * 
 * 
 * 后缀 子串； 包含后缀 ，但是不包含首字母的子串；
 * f
 * af
 * aaf
 * baaf
 * abaaf
 * 
 * 最长相等前后缀长度；
 * 子串， 前缀   后缀
 * a                 0
 * aa     a     a    1
 * aab               0
 * aaba   a     a    1
 * aabaa   aa   aa   2
 * aabaaf            0
 * //最长相等前后缀；
 * $next = [0,1,0,1,2,0];
 * */
//$str 匹配的文本字符串；
function  getNext($str)
{
    // i 后缀末尾位置；  j 前缀末尾位置；
    // （0 j）前缀  （1，i） 后缀；
    //初始化 $next 数组；
    $n = strlen($str);
    $j = 0;
    $next = []; 
    // 并不是要做全部的初始化；
    for ($i = 0; $i < $n; $i++) {
        $next[] = 0;
    }
    //
    for ($i = 1; $i < $n; $i++) {

        //前后缀不相同 为啥不相等的时候要回退！！！  注意这个位置一定要在 前后缀相同的前面；
        while ($j > 0 && $str[$i] != $str[$j]) {
            // 当不相等的时候查看前一位；
            $j = $next[$j - 1];
        }
        // 前后缀相同
        if ($str[$i] == $str[$j]) {
            $j++;
            // 相等的时候 $next[$i] = ++$j;
            $next[$i] =  $j;
        }
        //next 数组；
    }

    return $next;
}
// var_dump(getNext('aabaaf'));

function kmp($mainStr,$subStr)
{
    $next = getNext($subStr);
    // $i代表的是$mainStr的指针；
    //$j 代表的是$substr的指针；
    $i = 0; 
    $j = 0;

    for ($i = 0; $i < strlen($mainStr);) {
        if ($mainStr[$i] == $subStr[$j]) {
            //相等 但是不是最后一个元素；
            $i++;
            $j++;
        } elseif($j > 0){
            //不相等；只变$j $i 并不会变化；
            $j = $next[$j - 1];
        } else {
            // $j = 0 的时候不匹配问题；
            //$j = 0; $mainStr[$j] != $subStr[$i]
            $i++;
        }
        //因为上面做了  + 1 操作； 所以要等于长度；
        // 
        if ($j == strlen($subStr)) {
            //开始的位置；
            return $i - $j;
        }
    }

    return -1;
}
// echo kmp('aabaabaaf','aaboaaf');
echo kmp("ababcaababcaabc","ababcaabc");

/**
 * leetcode  --- kmp经典算法
 *  */ 

/**
 * 
 *leetcode ---  
 *  */
