<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:14
 */

/**
 * leetcode - 剑指 Offer II 041. 滑动窗口的平均值
 *  先进先出 FIFO 来求 滑动窗口的最小值；
 */

class MovingAverage {
    public $size = 0;
    public $queue = [];
    public $sum = 0;
    /**
     * Initialize your data structure here.
     * @param Integer $size
     */
    function __construct($size) {
        $this->size = $size;
    }

    /**
     * @param Integer $val
     * @return Float
     * 这个只能一个个添加把；
     */
    function next($val) {
        $n = count($this->queue); // 长度
        if ($n  == $this->size) {
            $tmp = array_shift($this->queue);
            $this->sum -= $tmp;
        }
        array_push($this->queue, $val);
        $this->sum += $val;
        //下面要加括号 因为 算术运算的优先级 会比条件高；
        return $this->sum/(count($this->queue) < $this->size ? count($this->queue) : $this->size);
    }
}

/**
 * Your MovingAverage object will be instantiated and called as such:
 * $obj = MovingAverage($size);
 * $ret_1 = $obj->next($val);
 */


/**
 * 剑指 Offer 59 - I. 滑动窗口的最大值
 * leetcode ---- 滑动窗口的最大值；
 * 难点 就是求 最大值； 可以使用暴力求解的方式；但是
 * 单调队列
 * 单调队列，即单调递减或单调递增的队列。使用频率不高，但在有些程序中会有非同寻常的作用。
 * //双端队列 //array_shift array_unshift  array_push array_pop();  数组头部的插入和删除  或者尾部 push pop 插入 和弹出；
 *
 */

/**
 * Class Solution
 * 存在的问题 数组的队列 shift 时间复杂度太高了，所以这边要做优化的；
 */

class Solution {
    protected $queue = [];
    protected $res = [];
    /**
     * @param Integer[] $nums
     * @param Integer $k
     * @return Integer[]
     */
    function maxSlidingWindow($nums, $k) {
        //1 pop();
        //2 push();k
        //3 getMaxVal();
        $n = count($nums);

        $res = [];//获取结果
        // 先插入  $k 个元素 //从0开始
        for ($i = 0; $i < $k; $i++) {
            $this->push($nums[$i]);
        }
        // 保存一下最大值
        $res[] = $this->getMaxVal();
        // 然后下面的继续执行；
        for ($i = $k; $i < $n; $i++) {
            $this->pop($nums[$i - $k]);
            $this->push($nums[$i]);
            $res[] = $this->getMaxVal();
        }

        // ????
        return  $res;
    }
    //push 和pop 分别是移动窗口k的两部分内容；前面部分push 和后半部分 pop；
    //弹出那些数值；
    function pop($val) {
        // 当不相等的时候  push 会做操作 会剔除；
        if (!empty($this->queue) && $this->queue[0] == $val) {
            // 这个队列，底层是数组 ？ 所以层前面删除时间复杂度太高了嘛？ 所以超过时间了？？ 应该是这样的；
            array_shift($this->queue);
        }
    }

    // push 数值；
    function push($val) {
        //弹出 小于 $val的全部弹出；
        // == $val 等于的时候 直接插入；  当是null的时候直接插入就行了；
        while (!empty($this->queue) && $val > $this->queue[count($this->queue) - 1]){
            //全部弹出；
            array_pop($this->queue);
        }
        //空的时候也可以；
        array_push($this->queue, $val);
    }

    // 获取最大值；/**
    // * 单调队列
    // * Monotone queue
    // */
    //class Mqueue
    //{
    //    private  $queue;
    //    public function __construct() {
    //        $this->queue = new SplQueue();
    //    }
    //
    //    public function pop($val) {
    //        /// bottom 从链表前端查看元素, top从链表末尾查看元素
    //        if (!$this->queue->isEmpty() && $this->queue->bottom() == $val) {
    //                $this->queue->dequeue(); // 弹出队列// 前面删除
    //        }
    //    }
    //
    //    public function push($val) {
    //        //等于的话要保留；
    //        while (!$this->queue->isEmpty() && $val > $this->queue->top()) {
    //            $this->queue->pop();
    //        }
    //        $this->queue->enqueue($val);
    //    }
    //
    //    public function getMaxVal() {
    //        return $this->queue->bottom();
    //    }
    //}
    function getMaxVal() {
        return $this->queue[0];
    }
}




/**
 *  leetcode -- 225 用两个队列实现栈；
 * // 先进后出；
 * //队列FIFO 先进先出；
 *
* // 如果只需要一个队列 如何去判断？
 * // 一个队列  也可以  一个数取出来 然后加载最后面；  这个也是比较简单的；这个思路很重要呀；
 */

class MyStack {
    //插入队列
    protected $queue1 = [];
    // 辅助队列
    protected $queue2 = [];
    /**
     */
    function __construct() {

    }

    /**
     * @param Integer $x
     * @return NULL
     */
    function push($x) {

        // queue1 作为插入的队列； queue2 作为辅助队列

        array_push($this->queue1, $x);
    }

    /**
     * @return Integer
     */
    function pop() {
        // 从  queue1 弹出 但是需要辅助队列 queue2
        $n = count($this->queue1);
        if ($n > 1) {
            // 循环多少次；//
            while (count($this->queue1) > 1) {
                array_push($this->queue2, array_shift($this->queue1));
            }
        }
        $res = array_shift($this->queue1);
        // 恢复recorve //恢复 //
        $this->queue1 = $this->queue2;
        $this->queue2 = []; // 清空；
        return $res;
    }

    /**
     * @return Integer
     */
    function top() {
        return $this->queue1[count($this->queue1) - 1];
    }

    /**
     * @return Boolean
     */
    function empty() {
        // 全都是empty 才是 empty
        return empty($this->queue1) ? true : false;
    }
}

/**
 * Your MyStack object will be instantiated and called as such:
 * $obj = MyStack();
 * $obj->push($x);
 * $ret_2 = $obj->pop();
 * $ret_3 = $obj->top();
 * $ret_4 = $obj->empty();
 */

/**
 * Class MyStack1
 * 一个队列 实现的的栈；
 */
class MyStack1 {
    //插入队列
    protected $queue1 = [];
    // 辅助队列
    // protected $queue2 = [];
    /**
     */
    function __construct() {

    }

    /**
     * @param Integer $x
     * @return NULL
     */
    function push($x) {

        // queue1 作为插入的队列； queue2 作为辅助队列

        array_push($this->queue1, $x);
    }

    /**
     * @return Integer
     */
    function pop() {
        // 从  queue1 弹出 但是需要辅助队列 queue2
        // $n = count($this->queue1);
        // if ($n > 1) {
        //     // 循环多少次；//
        //     while (count($this->queue1) > 1) {
        //         array_push($this->queue2, array_shift($this->queue1));
        //     }
        // }
        // $res = array_shift($this->queue1);
        // // 恢复recorve //恢复 //
        // $this->queue1 = $this->queue2;
        // $this->queue2 = []; // 清空；
        // return $res;


        // 只需要一个队列的算法；
        $n = count($this->queue1);
        // == 1 直接弹出就行了；
        if ($n > 1) {
            // 1 ---- $n - 1  还剩下一个元素  $n  //这个$n是个数
            for ($i = 1; $i <= $n - 1; $i++) {
                array_push($this->queue1,array_shift($this->queue1));
            }
        }
        return array_shift($this->queue1);
    }

    /**
     * @return Integer
     */
    function top() {
        return $this->queue1[count($this->queue1) - 1];
    }

    /**
     * @return Boolean
     */
    function empty() {
        // 全都是empty 才是 empty
        return empty($this->queue1) ? true : false;
    }
}

/**
 * Your MyStack object will be instantiated and called as such:
 * $obj = MyStack();
 * $obj->push($x);
 * $ret_2 = $obj->pop();
 * $ret_3 = $obj->top();
 * $ret_4 = $obj->empty();
 */

/**
 * leetcode -- 347 前k个高频元素；
 *  优先队列 大顶堆 和小顶堆的应用；
 * 约定：假设这里数组的长度为n
 *题目分析：本题希望我们返回数组排序之后的倒数第k 个位置。
 */
class Solution347 {

    /**
     * @param Integer[] $nums
     * @param Integer $k
     * @return Integer[]
     */
    function topKFrequent($nums, $k) {
        $map = [];
        foreach ($nums as $num) {
            $map[$num]++;
        }

        $minheap = new MyMinHeap();
        // 遍历map;
        foreach ($map as $index => $item) {
            if ($minheap->count() < $k) {
                // 上浮的过程；
                $minheap->insert([$index, $item]);
                //比较要插入的值是否比 最小值大，大 就要删除一个然后插入；
            } else if ($minheap->top()[1] < $item){
                //满了 插入一个删除一个；
                $minheap->extract();
                $minheap->insert([$index, $item]);
            }
        }
        $ret = [];
        while (!$minheap->isEmpty()) {
            $ret[] = $minheap->extract()[0];
        }
        return $ret;
    }
}
//重写了排序规则;
// 自定义了排序规则；
class MyMinHeap  extends SplMinHeap
{
    //必须要返回 int 吗？//切换版本！ 
    //这里做了限制？？？
    protected function compare ($value1, $value2) {
        return $value2[1] - $value1[1];
    }
}


//$arr347 = [1,1,1,2,2,3];
//$obj347 = new Solution347();
//$res = $obj347->topKFrequent($arr347, 2);
//var_dump($res);die;
$a = new stdClass();