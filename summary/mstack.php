<?php

/**
 * 
 * 基础知识
 * 单调栈 就是 在栈中单调递减 或者单调递增的元素； ---- 这个栈你是可以自己维护的；
 */

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
 * 单调栈；
 * # 每日温度 --- https://leetcode.cn/problems/iIQa4I/description/
 * 
 * php 怎么获取栈元素;
 */

$temperatures = [73, 74, 75, 71, 69, 72, 76, 73];
$temp1 = [64, 40, 49, 73, 72, 35, 68, 83, 35, 73, 84, 88, 96, 43, 74, 63, 41, 95, 48, 46, 89, 72, 34, 85, 72, 59, 87, 49, 30, 32, 47, 34, 74, 58, 31, 75, 73, 88, 64, 92, 83, 64, 100, 99, 81, 41, 48, 83, 96, 92, 82, 32, 35, 68, 68, 92, 73, 92, 52, 33, 44, 38, 47, 88, 71, 50, 57, 95, 33, 65, 94, 44, 47, 79, 41, 74, 50, 67, 97, 31, 68, 50, 37, 70, 77, 55, 48, 30, 77, 100, 31, 100, 69, 60, 47, 95, 68, 47, 33, 64];


function dailyTemperatures($temperatures)
{
    $mstack = [];
    $result = [];
    $c = count($temperatures);
    for ($i = 0; $i < $c; $i++) {
        $result[$i] = 0;
    }
    for ($i = 0; $i < $c; $i++) {

        // if (empty($mstack) || $temperatures[$i] < $mstack[count($mstack) - 1]) {
        //     array_push($mstack,$i);
        // } else if (empty($mstack) ||$temperatures[$i] == $mstack[count($mstack) - 1]){
        //     array_push($mstack,$i);
        // } else{
        while (!empty($mstack) && $temperatures[$i] > $temperatures[$mstack[count($mstack) - 1]]) {
            $result[$mstack[count($mstack) - 1]] = $i - $mstack[count($mstack) - 1];
            array_pop($mstack);
        }
        //这边直接插入就好了；
        array_push($mstack, $i);
        // }
    }
    return $result;
}

// var_dump(dailyTemperatures($temperatures));
// var_dump(dailyTemperatures($temp1));

/**
 * 2487. 从链表中移除节点   https://leetcode.cn/problems/remove-nodes-from-linked-list/
 *  */
/**
 * 时间复杂度是O(n)
 * 空间复杂度O(n);
 */
/**
 * @param ListNode $head
 * @return ListNode
 */
function removeNodes($head)
{
    $mstack = [];
    while ($head) {

        while (!empty($mstack) && $head->val > $mstack[count($mstack) - 1]) {
            //删除栈顶元素；//注意怎么去删除；
            array_pop($mstack);
        }
        array_push($mstack, $head->val);
        $head = $head->next;
    }
    //把array_push 换成 随机访问array_pop array_shift 时间复杂度太高了；
    $newHead = new ListNode($mstack[0], NULL);
    $current = $newHead;
    // while($mstack) {
    //     $current->next = new ListNode(array_pop($mstack),NULL);
    //     $current = $current->next;
    // }
    for ($i = 1; $i < count($mstack); $i++) {
        $current->next = new ListNode($mstack[$i],NULL);
        $current = $current->next;
    }
    return $newHead;
}
$newlist = new ListNode(5, new ListNode(2, new ListNode(13, new ListNode(3, new ListNode(8, NULL)))));


/**
 * 学习一下 怎么去 把一个数组 转换成链表的形式；
 *  */



// function arrayToLinkedList($arr) {
//     $head = new ListNode($arr[0]);
//     $current = $head;

//     for ($i = 1; $i < count($arr); $i++) {
//         $current->next = new ListNode($arr[$i]);
//         $current = $current->next;
//     }

//     return $head;
// }

// // 示例用法
// $arr = [1, 2, 3, 4, 5];
// $linkedList = arrayToLinkedList($arr);