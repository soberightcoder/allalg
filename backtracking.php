<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/10
 * Time 23:54
 */
/**
 * 回溯
 *
 * 应用场景；
 * 组合排列；
 * 子集； subset
 * 分割；
 * 棋盘；
 */

/**
 * Class ListNode
 * 2.list Node
 */

class ListNode
{
    public $val = 0;
    public $next = null;


    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}
//head 直接 指向的就是 头结点；
//变量名 其实就是一个地址；在php中 变量名 通过 active_symbol 转换成地址，进一步得到对象；
//  这里了解一下；
$head = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5)))));
$middle = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5, new ListNode(6))))));

/**
 * 链表倒叙遍历
 */

function reverseTraversal($head) {
    if ($head == null) return null;
    reverseTraversal($head->next);
    print($head->val);
}
//reverseTraversal($head);
/**
 *leetcode 77 组合问题；
 * 1234  大小是2的组合；
 */

/**
 * force question
 * 组合大小是2的组合；
 */
$combine = [1,2,3,4];
function combination2($combine) {
   $len = count($combine);
   for ($i = 0; $i < $len; $i++) {
       for ($j = $i+1; $j < $len; $j++) {
           echo $combine[$i].'--'.$combine[$j];
       }
   }
}
combination2($combine);

/**
 * leetcode 77
 * $n = array
 * $k 几位组合
 */

function backtrackingCombinations($n,$k) {

}

