<?php

/**
 * 
 * 基础知识
 * 
 */

use function Index\reverseArray;

/**
 * Class ListNode
 * 2.list Node
 */
class ListNode
{
    public $val = 0;
    public $next = null;


    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
//head 直接 指向的就是 头结点；
//变量名 其实就是一个地址；在php中 变量名 通过 active_symbol 转换成地址，进一步得到对象；
//  这里了解一下；
$head = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5)))));



/**
 * 可以把一个大问题，分解成多个小问题，小问题的解决方案和大问的解决方案是一样的；
 * 这个时候就需要用递归；
 */
$arr = [1,2,3,4];
//递归的思想来求和；
//递归；
function sum($arr,$index) {
    if ($index < 1) return;
    //这便是长度；
    return sum($arr,$index - 1) + $arr[$index - 1];
}
echo sum($arr,count($arr));


/**
 * 计算树的高度 或者层级；
 */
class Solution {

    /**
     * @param TreeNode $root
     * @return Integer
     */
    function calculateDepth($root) {
        if ($root == null) return 0;
        return max($this->calculateDepth($root->left),$this->calculateDepth($root->right)) + 1;
    }
}


/**
 * 链表的翻转
 * 递归的方式来实现链表的翻转；
 *  */
function reverseLinked($cur,$pre) {
    //递归的方式；
    if ($cur == null)  return $pre;
    //operation
    $store = $cur->next;
    $cur->next = $pre;

    return reverseLInked($store,$cur);
}
// var_dump(reverseLinked($head,NULL));
/**
 * 双指针 进行链表的翻转；
 * */ 
function reverseLinked2point($head) {
    //init;
    $pre = NULL;
    $cur = $head;
    while ($cur) {
        $store = $cur->next;
        $cur->next = $pre;
        // 重新做赋值；
        $pre = $cur;
        $cur = $store;
    }
    return $pre;
}
// var_dump(reverseLinked2point($head));

/**
 * 斐波那契额数列；
 * f(n) = f(n-1) + f(n-2);
 *指数级别的时间复杂度 O(2^n)
 */

function fib($n) {
    if ($n <= 2) return $n;
    return fib($n - 1) + fib($n - 2);
}
$mid = fib(5);
// var_dump($mid);

/**
 * 尾巴递归；
 * n!;  寻找 n 和n -1 之间的关系；
 * 
 *  */
function jiecheng($n) {
    if ($n == 0) return 1;
    // 这样写，是要接收，下一级递归返回的数据；就是递归返回的数据是有关系的；
    //这也是一个后向递归，并且n 和 n-1是有关系的；
    return $n * jiecheng($n - 1);
}

/**
 *递归用用来遍历数组； 
 *  */
$arr = [1,2,3,4,5];
function traverseArr($arr,$i) {
    if ($i == count($arr)) return;
    //前序操作；
    echo $arr[$i];
    traverseArr($arr,$i+1);
}
// traverseArr($arr,0);
// die;
/**
 * 这就是逆序操作；
 *  */ 
function traverseArr1($arr,$i) {
    if ($i == count($arr)) return;
    //前序操作；
    traverseArr1($arr,$i+1);
    //所以这肯定是倒叙的；
    echo $arr[$i];
    //注意 当代码执行完成后 会自动return；
}
// traverseArr1($arr,0);
