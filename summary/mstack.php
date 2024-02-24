<?php

/**
 * 
 * 基础知识
 * 单调栈 就是 在栈中元素保持，单调递减 或者单调递增的栈； ---- 这个栈你是可以自己维护的；
 * ###--------------------------------------------------
 * 单调栈主要解决：
 * 如何找右边第一个比我小的元素；
 * 如何找右边第一个比我大的元素；
 * 如何找右边最后一个比我小的元素？
 * 如何找右边最后一个比我大的元素；
 * 当然放在左边也是适合的；
 */

use MVC\Alg\Sort;

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
 * php 怎么获取栈元素;
 */

$temperatures = [73, 74, 75, 71, 69, 72, 76, 73];
$temp1 = [64, 40, 49, 73, 72, 35, 68, 83, 35, 73, 84, 88, 96, 43, 74, 63, 41, 95, 48, 46, 89, 72, 34, 85, 72, 59, 87, 49, 30, 32, 47, 34, 74, 58, 31, 75, 73, 88, 64, 92, 83, 64, 100, 99, 81, 41, 48, 83, 96, 92, 82, 32, 35, 68, 68, 92, 73, 92, 52, 33, 44, 38, 47, 88, 71, 50, 57, 95, 33, 65, 94, 44, 47, 79, 41, 74, 50, 67, 97, 31, 68, 50, 37, 70, 77, 55, 48, 30, 77, 100, 31, 100, 69, 60, 47, 95, 68, 47, 33, 64];


function dailyTemperatures($temperatures)
{
    $mstack = [];
    $result = [];
    $c = count($temperatures);
    // php做这个题 一定要初始化呀；
    // for ($i = 0; $i < $c; $i++) {
    //     $result[$i] = 0;
    // }
    $result = array_fill(0, $c, 0);
    for ($i = 0; $i < $c; $i++) {
        $x = $temperatures[$i];
        while (!empty($mstack) && $x > $temperatures[$mstack[count($mstack) - 1]]) {
            $mid = array_pop($mstack);
            $result[$mid] = $i - $mid;//还有多少天，温度就会提升！！！
        }
        //这边直接插入就好了；
        array_push($mstack, $i);
        // }
    }

    //全部弹出 栈；栈空间里面还有数据，就是那些没有升高温度的；
    // while (!empty($stack)) {
    //     $i = array_pop($stack);
    //     $result[$i] = 0;
    // }
    return $result;
}

// var_dump(dailyTemperatures($temperatures));

/**
 * 2487. 从链表中移除节点   https://leetcode.cn/problems/remove-nodes-from-linked-list/
 * 移除每个右侧有一个更大值得节点；
 * 就是单调递减呗；只要是递增就删除；
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
    //1 <= Node.val <= 105 所以这个dummy节点不能被移出来；只有有数大于PHP_INT_MAX 才会被移出来，所以会一直在单调栈内；
    $dummy = new ListNode(PHP_INT_MAX, $head);//值都大于1；//虚拟节点；
    $mstack = [];
    $cur = $dummy;
    while ($cur) {
        $x = $cur->val;
        while (!empty($mstack) && $x > $mstack[count($mstack) - 1]->val) {
            //删除栈顶元素；//注意怎么去删除；
            array_pop($mstack);
            $mstack[count($mstack) - 1]->next = $cur;

        }
        //存储节点吧；
        array_push($mstack, $cur);
        $cur = $cur->next;
    }
    return $dummy->next;
}

$newlist = new ListNode(5, new ListNode(2, new ListNode(13, new ListNode(3, new ListNode(8, NULL)))));





/**
 * 接雨水；
 * //维护一个单调栈，关键点：出栈的时候怎么去统计；
 * 查找右边第一个大于该元素的元素；
 * 必须先 递减然后增加才能接到雨水！！！
 * 单调栈 是横向 求解雨水面积；
 * O(n)的时间复杂度，但是空间复杂度是O(n);需要更多的额外空间；
 *  */ 
class Solution42 {

    /**
     * @param Integer[] $height
     * @return Integer
     */
    function trap($height) {
        //维护一个单调栈；维护一个单调减 然后增才会出现水槽； 所以维护一个单调减栈；
        $stack = [];
        $n = count($height);
        $sum = 0;
        for ($i = 0; $i < $n; $i++) {
            $x = $height[$i];
            //大于栈顶则出栈；
            while (!empty($stack) && $x > $height[$stack[count($stack) - 1]]) {
                $preHigh = array_pop($stack);
                if (!empty($stack)) {
                    //求面积；
                    $h = min($x,$height[$stack[count($stack) - 1]]) - $height[$preHigh];
                    $w = ($i - $stack[count($stack) - 1]) - 1;//找个数据做测试就可以了；
                    $sum += $h * $w;
                }
                
            }
            //相等 或者小于的时候入栈；
            array_push($stack, $i);//保存的还是索引；
        }
        return $sum;

    }
}
// $height = [0,1,0,2,1,0,1,3,2,1,2,1];
// $obj42 = new Solution42();

// echo $obj42->trap($height);

/**
 *  下一个更大的元素；
 *  leetcode --- 496. 下一个更大元素 I
 *  */
class Solution496 {

    /**
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Integer[]
     */
    function nextGreaterElement($nums1, $nums2) {
        $stack = [];
        $ans = [];
        $n = count($nums2);
        // init  
        for ($i = 0; $i < count($nums1); $i++) {
            $ans[$i] = -1;
        }

        for ($i = 0; $i < $n; $i++) {
            $x = $nums2[$i];
            while(!empty($stack) && $x > $nums2[$stack[count($stack) - 1]])  {
                // 
                $mid = array_pop($stack);
                $key = array_search($nums2[$mid], $nums1);
                if ($key !== false) {
                    $ans[$key] = $x;
                }
                
            }
            array_push($stack, $i);
        }
        return $ans;
    }
}
// $obj496 = new Solution496();
// $obj496->nextGreaterElement([4,1,2],[1,3,4,2]);

/**
 *leetcode --- 84 最大柱形面积； 
 * 有可能会存在 212的情况 这个也是3；很变态呀；卧槽；
 * 思路一开始就错了；
 * 具体的思路： 就是某一个i柱子，向左找比他矮的，向右找比他矮的；来确定他的宽； 高度就是本柱子的高$heights[$i]； 
 * 
 * 单调栈的思路： 求左边第一个比他小的，右边第一个比他小的元素；
 * 一句话总结就是，左右边界就是找左右两边第一个比自己小的元素。
 * 基于各个高度的最大矩形是在出栈的时候计算的，因此必须要让所有高度都出栈。这里是利用单调栈的性质让其全部出栈，即在原始数组后添一个0.
 * 
 * 肯定是使用递增的方式--- 递增然后$i小于栈顶元素；开始弹出；处理
 * 
 * 哨兵 + 单调栈来实现；
 * 千万不要用mid来计算宽度，因为$mid 很不可靠；一定要用栈顶元素来计算，具体实例，自己去研究一下212；
 *  */ 
class Solution84 {

    /**
     * @param Integer[] $heights
     * @return Integer
     */
    //时间复杂度是O(n) // 空间复杂度也是O(n)
    function largestRectangleArea($heights) {
        //哨兵；
        // 尤其多主题212问题，这个柱形最大面积是3；
        array_push($heights, 0);// 解决递增的问题；234 一直递增的问题；
        array_unshift($heights, 0);//解决 432 
        //单调递增栈；
        $stack = [];
        $max = 0;
        $n = count($heights);
        for ($i = 0; $i < $n; $i++) {
            $x = $heights[$i];
            while (!empty($stack) && $x < $heights[$stack[count($stack) - 1]]) {
                $mid = array_pop($stack);
                //这里为啥不用$i - $mid;??? 这个$mid  没法改变212的问题；一定要用$stack[count($stack) - 1]
                // $i 代表的是右边边界，$stack[count($stack) - 1] 代表的是左边边界；
                $w = $i - $stack[count($stack) - 1] - 1; 
                $h = $heights[$mid];
                $max = max($max, $h * $w);
            }
            //等于 或者为空，或者大于都要入栈；
            array_push($stack, $i);//保存的是索引；
        }


        return $max;

    }
}
$obj84 = new Solution84();
echo $obj84->largestRectangleArea([2,4]);

/**
 * 右边第一个比我小的元素？？？
 * 单调栈；---- 只会对数据的尾部进行插入和弹出；所以这里是一个单调栈；
 *  */

$arrTest = [1,2,3,9,5,0,6];  


function com1($nums){
    $stack = [];
    $n = count($nums);
    //php 必须一开始就要做初始化；
    $ans = array_fill(0, count($nums), - 1);
    for ($i = 0; $i < $n; $i++) {
        $x = $nums[$i];
        while (!empty($stack)  && $x < $nums[$stack[count($stack) - 1]]) {
            $mid = array_pop($stack);
            //保存的是右边比本元素小的元素；
            $ans[$mid] = $nums[$i];
        }
        array_push($stack, $i);//索引；
    }
    //没有右边最小值的索引；
    // while (!empty($stack)) {
    //     $i = array_pop($stack);
    //     $ans[$i] = -1;
    // }
    return $ans;
}

// var_dump(com1($arrTest));

/**
 * 
 * 单调队列的实现；
 * 这就是维护一个单调栈
 * 进出都是数组同一个端； 可以看成进出都是从右边；
 */
class MStack 
{
    private $stack = [];
    // 第一个调用栈 你可以看到三个元素；
    // 1. $X 你要待插入或者判断的元素；
    // 2. array_pop($this->stack); //调用栈栈顶元素；
    // 3. 弹出栈顶元素之后de栈顶元素； 
    public function push($x) {
        while (!empty($this->stack) && $x < $this->stack[count($this->stack) - 1]) {
            $mid = array_pop($this->stack);
            //三元素 $x  array_pop($this->stack) $this->stack[count($this->stack) - 1] 是这三个元素；
        }
        //注意这里插入的数据；有可能是索引，也有可能是数据；
        array_push($this->stack, $x);
    }
}


/**
 * 单调队列的实 具体的实现；
 * 进出不是数组的一个端；   左边出，右边进；
 *  */ 

 //单调队列的实现 --- 用双向队列来实现的；单调队列，维护队列里面单调递增单调递减；
 //单调队列的实现方式； 维护一个单调队列，经常用来求，滑动窗口的最大值；这不一样的； 这个单调队列是不一样的；
 // 因为滑动窗口 要滑动呀，有数据的push 也会有数据的shift所以是一个队列；
class MyQueue1
{
    //$queue[0] ===   代表的是队列的最大值；
    // public $queue;//可以使用双向链表队列 ，也可以使用数组；
    // function __construct() {
    //     $this->queue = new \SplQueue;
    // }

    public $queue = [];

    function push($x)
    {
        //push 的时候 做了 很多pop操作；
        // 有可能会删除很多个；
        //等于的时候也会添加；
        while (!empty($this->queue) && $x > $this->queue[count($this->queue) - 1]) {
            array_pop($this->queue);
        }
        array_push($this->queue, $x);
    }

    function pop($x)
    {
        //只有是最大值的时候才会删除；
        if (!empty($this->queue) && $x == $this->queue[0]) {
            array_shift($this->queue);
        }
    }

    function getMax()
    {
        // 维护这一个最大值；
        return $this->queue[0];
    }
}



/**
 * extra
 *  */

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


/**
 * array_fill 用数据来对数组来做填充；
 * 可以用来做数据的初始化；
 * array_fill 第一个参数是 index 数组的第一个索引 第二个参数是要插入的元素数 第三个参数是value值；填充数组需要的值；
 */

$arrFill = [];
$res1 = array_fill(0, 4,'a'); // init 用来做初始化；
// var_dump($res1);die;


//  php中 0 == false 注意 ,会做弱类型转换；
$arrText1 = [];
$arrTest1[false] = 1;  // 0呀 false 变成了0；给0重新赋值了；
// var_dump($arrTest1);die;