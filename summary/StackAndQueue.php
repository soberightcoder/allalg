<?php

/**
 * 栈很有擅长做，相邻字符的消除；
 * 栈 其实是有逆序属性的，入栈，出栈，然后变成逆序；
 * 队列 入队列 + 出队列，还是顺序；
 * php 栈和队列都是一个数组；
 * array_shift();array_unshift(); 头部删除和插入；
 * array_push(); array_pop(); 尾部的插入和弹出；
 * 你可以使用 list 或者 deque（双端队列）来模拟一个栈，只要是标准的栈操作即可。
 * 其实php数组 就有类似的功能；
 *  */
/**
 * 用栈来实现队列； 
 * leetcode -- 232 
 * 两个栈来实现队列 ===> 
 * //整体思路 就是先从stack2开始拿，stack2没了，再去拿stack1的；基本就这个思路；
 *  */

class MyQueue
{
    /**
     */
    public $stackIn = [];
    public $stackOut = [];

    function __construct()
    {
    }

    /**
     * @param Integer $x
     * @return NULL
     */
    function push($x)
    {
        // 插入之前是不是要清空 stack2? 
        // if(!empty($this->stack2)) { 
        //     $this->stack2 = [];    
        // }
        array_push($this->stackIn, $x);
    }

    /**
     * @return Integer
     */
    function pop()
    {
        if (!empty($this->stackOut)) {
            return array_pop($this->stackOut);
        }
        // empty stack2 自己去遍历
        $n = count($this->stackIn);
        if ($n >= 0) {
            for ($i = 0; $i < $n; $i++) {
                array_push($this->stackOut, array_pop($this->stackIn));
            }
            return array_pop($this->stackOut);
        }
        // 队列是empty 
        return NULL;
    }

    /**
     * @return Integer
     */
    function peek()
    {
        if (!empty($this->stackOut)) {
            return $this->stackOut[count($this->stackOut) - 1];
        }
        if (!empty($this->stackIn)) {
            $n = count($this->stackIn);
            for ($i = 0; $i < $n; $i++) {
                array_push($this->stackOut, array_pop($this->stackIn));
            }
            return $this->stackOut[count($this->stackOut) - 1];
        }
        return NULL;
    }

    /**
     * @return Boolean
     */
    function empty()
    {
        return empty($this->stackIn) && empty($this->stackIn) ? true : false;
    }
}

/**
 * Your MyQueue object will be instantiated and called as such:
 * $obj = MyQueue();
 * $obj->push($x);
 * $ret_2 = $obj->pop();
 * $ret_3 = $obj->peek();
 * $ret_4 = $obj->empty();
 */
/**
 * 用队列形成栈；
 * 用一个队列实现一个栈；
 */

class MyStack
{
    // 一个队列实现一个栈；
    public $queue = [];
    /**
     */
    function __construct()
    {
    }

    /**
     * @param Integer $x
     * @return NULL
     */
    function push($x)
    {
        array_push($this->queue, $x);
    }


    /**
     * @return Integer
     */
    function pop()
    {
        if ($this->empty()) return NULL;
        $n = count($this->queue);
        for ($i = 0; $i <= $n - 2; $i++) {
            array_push($this->queue, array_shift($this->queue));
        }
        return array_shift($this->queue);
    }

    /**
     * @return Integer
     */
    function top()
    {
        if ($this->empty()) return NULL;
        return $this->queue[count($this->queue) - 1];
    }

    /**
     * @return Boolean
     */
    function empty()
    {
        return empty($this->queue) ? true : false;
    }
}

/**
 * 有小括号
 * 20. 有效的括号
 */
function isValid($s)
{
    $map = ['{' => '}', '(' => ')', '[' => ']'];
    $stack = [];
    for ($i = 0; $i < strlen($s); $i++) {
        if (!empty($stack)) {
            // 相等的话出栈
            if ($map[$stack[count($stack) - 1]] == $s[$i]) {
                array_pop($stack);
            } else {
                array_push($stack, $s[$i]);
            }
        } else {
            array_push($stack, $s[$i]);
        }
    }
    return empty($stack) ? true : false;
}

/**
 * 删除字符串中所有的相邻重复项；
 * 删除 相邻的重复元素，可以和栈顶对比；
 * leetcode --- 1047；
 *  */
function removeDuplicates($s)
{
    //stack 来存储遍历过的元素；
    $stack = [];
    $n = strlen($s);
    for ($i = 0; $i < $n; $i++) {
        // 明白了，不满足第一个就满足第二个；
        if (empty($stack) || $stack[count($stack) - 1] != $s[$i]) {
            array_push($stack, $s[$i]);
        } else {
            // 这是要满足什么条件？？ 
            array_pop($stack);
        }
    }
    //可以使用 php 函数implode();把数组转换成字符串的形式；
    $res = '';
    if (!empty($stack)) {
        $n = count($stack);
        for ($i = 0; $i < $n; $i++) {
            $res .= $stack[$i];
        }
    }
    return $res;
}

/**
 * 逆波兰表达式求值；
 * 表达式计算的  也是用栈来实现的；
 * leetcode--- 150；
 *  */
function evalRPN($tokens)
{
    $stack = [];
    $n = count($tokens);
    $map = ['+', '-', '*', '/'];
    for ($i = 0; $i < $n; $i++) {
        if (!in_array($tokens[$i], $map)) {
            //是数值直接入栈就行；
            array_push($stack, $tokens[$i]);
        } else {
            // 是符号位。就弹出计算值；然后再次插入；
            //符号位；
            $y = array_pop($stack);
            $x = array_pop($stack);
            // 左右中的规则；所以 被减数应该在第二位；所以先弹出来的是在右边；
            switch ($tokens[$i]) {
                case '+':
                    $z = $x + $y;
                    break;
                case '-':
                    $z = $x - $y;
                    break;
                case '*':
                    $z = $x * $y;
                    break;
                case '/':
                    $z = $x / $y;
                    break;
            }
            array_push($stack, $z);
        }
    }
    // 返回数值；
    return $stack[0];
}
// var_dump(evalRPN(["2","1","+","3","*"]));die;

/**
 * //todo -- 比较难的那种；
 * 求滑动窗口的最大值；
 * 239. 滑动窗口最大值
 * 难点是在于 怎么求解滑动窗口内的最大值；
 * 单调队列；
 *  */
//单调队列的实现 --- 用双向队列来实现的；单调队列，维护队列里面单调递增单调递减；
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





// 单调对列构建 --- 用SplQueue来实现的；--- 效率会更高一些；leetcode 只有用这个才能通过 用上面的效率很低；
class MyQueue2{
private $queue;

public function __construct(){
$this->queue = new SplQueue(); //底层是双向链表实现。
}

public function pop($v){
// 判断当前对列是否为空
// 比较当前要弹出的数值是否等于队列出口元素的数值，如果相等则弹出。
// bottom 从链表前端查看元素, dequeue 从双向链表的开头移动一个节点
if(!$this->queue->isEmpty() && $v == $this->queue->bottom()){
    $this->queue->dequeue(); //弹出队列
}
}

public function push($v){
// 判断当前对列是否为空
// 如果push的数值大于入口元素的数值，那么就将队列后端的数值弹出，直到push的数值小于等于队列入口元素的数值为止。
// 这样就保持了队列里的数值是单调从大到小的了。
while (!$this->queue->isEmpty() && $v > $this->queue->top()) {
    $this->queue->pop(); // pop从链表末尾弹出一个元素，
}
$this->queue->enqueue($v);
}

// 查询当前队列里的最大值 直接返回队首
public function max(){
// bottom 从链表前端查看元素, top从链表末尾查看元素
return $this->queue->bottom(); 
}

// 辅助理解: 打印队列元素
public function println(){
// "迭代器移动到链表头部": 可理解为从头遍历链表元素做准备。
// 【PHP中没有指针概念，所以就没说指针。从数据结构上理解，就是把指针指向链表头部】
$this->queue->rewind();

echo "Println: ";
while($this->queue->valid()){
    echo $this->queue->current()," -> ";
    $this->queue->next();
}
echo "\n";
} 
}

function maxSlidingWindow($nums, $k)
{
    $res = [];
    //维护的是最大值；
    $queue = new MyQueue1;
    //怎么去滑动窗口的呀？？？
    $n = count($nums);
    //1 <= k <= nums.length
    for ($i = 0; $i < $k; $i++) {
        $queue->push($nums[$i]);
    }

    $res[] = $queue->getMax();

    for ($i = $k; $i < $n; $i++) {
        //滑动窗口 向前移动了一位，所以要移动第一个元素pop();没有无所谓，就代表已经移除了而已；
        $queue->pop($nums[$i - $k]);
        $queue->push($nums[$i]);
        $res[] = $queue->getMax();
    }
    $res;
}

/**
 * 347. 前 K 个高频元素
 * 要求 nlogn的时间复杂度；
 * 难点： 怎么求数组内出现的频率，可以使用map 来进行统计，时间复杂度是O(n)
 * 难点2： 还有怎么对出现的频率来进行排序；
 * topK的问题；来维护K个元素的排序；可以使用大顶堆和小顶堆；
 * //因为要维护所有元素的排序，所以时间复杂度是nlogn
 */
function topKFrequent($nums, $k)
{
    $n = count($nums);
    $map = [];
    // 统计频率；
    for ($i = 0; $i < $n; $i++) {
        if (!isset($map[$nums[$i]])) {
            $map[$nums[$i]] = 1;
        } else {
            $map[$nums[$i]]++;
        }
    }
    // 保留k的排序；nlogn  按照快排来计算；
    arsort($map); //  这里的a 就是关联数组的意思？？
    // var_dump($map);die;
    $res = array_slice($map,0,$k,true); //true 保留key
    // var_dump($res);die;
    return array_keys($res);
}
// var_dump(topKFrequent([4,1,-1,2,-1,2,3],2));
/**
 * 用heap 堆来实现，topK的问题；
 */
class MyMinHeap extends SplHeap
{
    // 比较元素，以便在筛选时将它们正确地放在堆中，
    // 如果value1大于value2则为正整数，如果相等则为0，否则为负整数
    function compare($value1, $value2) { 
        return $value2[1] - $value1[1];
    } 
}
/**
 * 时间复杂度是nlogk的时间复杂度； 
 *  */
function topKFrequentByHeap($nums, $k)
{
    $n = count($nums);
    $map = [];
    // 统计频率；
    for ($i = 0; $i < $n; $i++) {
        if (!isset($map[$nums[$i]])) {
            $map[$nums[$i]] = 1;
        } else {
            $map[$nums[$i]]++;
        }
    }
    $heap = new MyMinHeap();
    foreach ($map as $key => $val) {
        // key为索引  , $val代表出现的频率；以频率来做排序；
        $heap->insert([$key,$val]);
        //超过k就pop();
        if ($heap->count() > $k) {
            $heap->extract();
        }
    }
    //因为heap实现了迭代类的接口 所以可以直接用foreach 来进行遍历
    $res = [];
    foreach ($heap as $nums) {
        $res[] = $nums[0];
    }
    return $res;
}

// var_dump(topKFrequentByHeap([4,1,-1,2,-1,2,3],2));

/***
 * extra extends 额外的操作；
 *  比如把一个数组逆序，你所想到的方法有那些； 递归 双指针 + stack 栈；也可以使用for ($i = $n-1;$i >=0;$i--) 来做倒叙；
 * 递归本质也是一个栈；也是一个调用栈呀；
 * */

$arr = [1, 2, 3, 4, 5];
$tmp = [];
function reverseArr($arr, $i, $n)
{
    if ($i == $n - 1) return $arr[$n - 1];
    // 这样写，是要接收，下一级递归返回的数据；就是递归返回的数据是有关系的；
    $GLOBALS['tmp'] = reverseArr($arr, $i + 1, $n);
}
// $n  = count($arr);
// reverseArr($arr,0,$n);


//用前序遍历
//递归会占用更多的空间；
function reverseArray($arr, $start, $end)
{
    if ($start >= $end) {
        return;
    }
    // 交换数组的两个元素
    $temp = $arr[$start];
    $arr[$start] = $arr[$end];
    $arr[$end] = $temp;
    // 递归处理剩余的子数组
    reverseArray($arr, $start + 1, $end - 1);
}

/**
 * 这就是逆序操作；
 *  */
function traverseArr1($arr, $i)
{
    if ($i == count($arr)) return;
    //前序操作；
    traverseArr1($arr, $i + 1);
    //所以这肯定是倒叙的；
    echo $arr[$i];
    //注意 当代码执行完成后 会自动return；
}
// traverseArr1($arr,0);


//php 栈顶元素的计算可以用end来计算；但是注意 使用完一定要重置  直接用count()；来计算把；简单一点；


/**
 *  优先队列 底层就是大顶堆  或者小顶堆来实现的；  优先队列，也可以得到一个队列的最大值；
 *  */

/**
 *单调队列 --- 维护队列里面的元素，单调递减 和 单调递增；
 * 自己维护的单调栈；--- 这个根据实际情况来维护，比如上面的滑动窗口的最大值，只需要维护可能成为最大值的元素就可以了；
 *  */


/**
 *  php 自带的双端队列 Splqueue;对象；  SplQueue 类的主要功能是通过将迭代模式设置为 SplDoublyLinkedList::IT_MODE_FIFO 来提供使用双向链表实现的队列。
 * 堆就是为了实现优先队列而设计的一种数据结构，它分为大顶堆和小顶堆，PHP核心库提供了大顶堆SplMaxHeap和小顶堆SplMinHeap两种类可供直接使用，他们都是由SplHeap抽象类实现的
 * Heap 底层实现就是一个二叉树；大顶堆 就是父节点就是最大值；小顶堆就是根节点就是最小的；
 * SplStack 类的主要功能是通过将迭代模式设置为 SplDoublyLinkedList::IT_MODE_LIFO 来提供使用双向链表实现的栈。
 *  */ 

 /**
  * foreach 就是可以遍历 关联数组  然后另外一个就是对象；
  */