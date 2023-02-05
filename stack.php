<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:14
 */


/**
 * php 的栈 就是 push 和 stack 来实现的一个栈；
 * leetcode - 剑指 Offer 09. 用两个栈实现队列
 * Class CQueue
 * 两个栈实现一个队列；
 * 先入先出；FIFO;
 * //两个栈实现一个队列
 */

class CQueue {
    public $stack1 = [];
    public $stack2= [];

    /**
     */
    function __construct() {

    }

    /**
     * @param Integer $value
     * @return NULL
     * null = -1
     */
    function appendTail($value) {
        array_push($this->stack1,$value);
    }

    /**
     * @return Integer
     * //这里需要判断 stack2 和 stack1的情况 当不够的情况需要从 stack1里面取;****这个好好的学一下；
     */
    function deleteHead() {
        if (empty($this->stack2))  {
            // 把 stack1的元素 导入到 stack2
            $this->help();
            if (empty($this->stack2)) {
                return -1;
            }
        }
        //不为null 直接取；//直接删除
        return array_pop($this->stack2);
    }

    public function help() {
        // stack1 出栈；
        //插入到stakc2
        // $this->>stack1 == null 那么就是
        while ($item = array_pop($this->stack1)) {
            //
            array_push($this->stack2,$item);
        }
    }
}
//ceshi
$obj1 = new CQueue();
$obj1->appendTail(1);
$obj1->appendTail(2);
$obj1->appendTail(3);
$obj1->appendTail(4);
echo $obj1->deleteHead();
echo $obj1->deleteHead();
echo $obj1->deleteHead();
/**
 *  155. 最小栈
 * 我记得是维护两个栈
 */

class MinStack {
    public $stack = [];
    public $top = 0;
    // 最小栈
    public $minStack = [];
    //指向的是下一个元素
    public $minTop = 0;
    /**
     */
    function __construct() {

    }

    /**
     * @param Integer $val
     * @return NULL
     * //怎么获取栈顶元素？？？  php 怎么获取栈顶元素？ 维护一个栈顶指针吗？
     * //z注意相同的也要插入；因为只有和栈顶相等的时候也要删除
     */
    function push($val) {
        //先赋值 然后 ++
        $this->stack[$this->top++] = $val;
        // 只有维护也该值才能找到  栈顶
        if (empty($this->minStack) || $val <= $this->minStack[$this->minTop - 1]) {
            $this->minStack[$this->minTop] = $val;
            //下一个元素要插入的index
            $this->minTop++;
        }
    }

    /**
     * @return NULL
     */
    function pop() {
        //
        $res = array_pop($this->stack);
        $this->top--;
        //
        if ($res == $this->minStack[$this->minTop -1]) {
           array_pop($this->minStack) ;
           $this->minTop--;
        }
    }

    /**
     * @return Integer
     */
    function top() {
        // 栈顶；元素；； 所以必须要维护 top
        if ($this->stack == null) return null;
        return $this->stack[$this->minTop - 1];
    }

    /**
     * @return Integer
     */
    function getMin() {
        //最小值；
        if (empty($this->minStack)) return 0;
        return $this->minStack[$this->minTop - 1];
    }
}

/**
 * Your MinStack object will be instantiated and called as such:
 * $obj = MinStack();
 * $obj->push($val);
 * $obj->pop();
 * $ret_3 = $obj->top();
 * $ret_4 = $obj->getMin();
 */

/**
 * leetcode --  20. 有效的括号
 * 有效括号
 * 示例 2：
输入：s = "()[]{}"
输出：true
 */
// java 代码逻辑
//class Solution {
//    public boolean validateStackSequences(int[] pushed, int[] popped) {
//        Deque<Integer> stack = new LinkedList<>();
//        int n = pushed.length;
//        for (int i = 0, j = 0; i < n; ++i) {
//            stack.push(pushed[i]);
//            while (!stack.isEmpty() && stack.peek() == popped[j]) {
//                stack.pop();
//                j++;
//            }
//}
//return stack.isEmpty();
//}
//}
class Solution {

    /**
     * @param String $s
     * @return Boolean
     *  最后栈是空那么就代表 括号是有效的；
     * $s 就是一个字符串
     *  字符串 就是一个字符数组 所以 可以通过 index索引来进行访问；
     */
    function isValid($s) {
        $set = [')'=>'(',']'=>'[','}'=>'{'];
        $stack = [];// 栈
        $top = 0; //栈顶
        $len = strlen($s);

        for ($i = 0; $i < $len; $i++) {
            //
            if (!empty($stack) && $set[$s[$i]] == $stack[$top - 1]) {
                array_pop($stack);
                $top--;
            } else {
                array_push($stack, $s[$i]);
                $top++;
            }

            // if (empty($stack)) {
            //      array_push($stack, $s[$i]);
            //      $top++;
            // } else {
            //     if ($set[$s[$i]] == $stack[$top - 1]) {
            //         array_pop($stack);
            //         $top--;
            //     } else {
            //         array_push($stack, $s[$i]);
            //         $top++;
            //     }
            // }
        }

        return empty($stack) ? true : false;
    }
}

/**
 * 剑指 Offer 31. 栈的压入、弹出序列
 * 栈的压入 和 弹出序列；
 * php 不能记录当前栈的大小；所以需要维护一个top会方便一些 当然也可以使用count(n) -  1 来计算栈顶；
 */

class Solution31 {

    /**
     * @param Integer[] $pushed
     * @param Integer[] $popped
     * @return Boolean
     * 数字均不相等；
     */
    function validateStackSequences($pushed, $popped) {
        // 这种写法 要好好看一下呀；

        $n = count($pushed);
        $stack = [];

        for ($i = 0, $j = 0; $i < $n; $i++) {
            array_push($stack, $pushed[$i]);
            //栈顶 怎么取求； 因为数组 count 要统计数组的长度  所以这里的时间复杂度是O(1); 类似于java中的peek当前元素；
            // 注意这里不需要维护一个栈顶 指针 栈顶指针其实是 count($stack) - 1;
            while (!empty($stack) && $stack[count($stack) - 1] == $popped[$j]) {
                array_pop($stack);
                $j++;
            }
        }
        //  empty
        return empty($stack) ? true : false;
    }
}
/**
 * 1472. 设计浏览器历史记录
 * 网页的后退 和前进的实现
 * 我感觉也是两个栈来实现的；
 */

class BrowserHistory {
    public $forwardstack = [];
    public $backstack = [];

    /**
     * @param String $homepage
     */
    //初始值？？？？？ //
    function __construct($homepage) {
        array_push($this->forwardstack, $homepage);
    }

    /**
     * @param String $url
     * @return NULL
     */
    function visit($url) {
        // backforwd 要被清空？？？ 当插入新的元素的时候  back 要被清空？？？
        array_push($this->forwardstack, $url);
        // 直接给清空； 要清空；
        $this->backstack = [];
    }

    /**
     * @param Integer $steps
     * @return String
     */
    function back($steps) {
        //回退几步？？ // homepage 不能被改变不能被弹出；
        //会留下一个homepage 家页面；
        $n = count($this->forwardstack) - 1; //会剩下一个 //要剩下最后一个；；
        $steps = $steps >= $n ? $n : $steps;
        for ($i = 1; $i <= $steps; $i++) {
            array_push($this->backstack, array_pop($this->forwardstack));
        }
        // return 栈顶元素
        return $this->forwardstack[count($this->forwardstack) - 1];
    }

    /**
     * @param Integer $steps
     * @return String
     */
    function forward($steps) {
        //回退几步？？ // homepage 不能被改变不能被弹出；
        $n = count($this->backstack); //会剩下一个 // 元素的长度；
        $steps = $steps >= $n ? $n : $steps;
        for ($i = 1; $i <= $steps; $i++) {
            array_push($this->forwardstack, array_pop($this->backstack));
        }
        // return 栈顶元素  栈顶元素
        return $this->forwardstack[count($this->forwardstack) - 1];

    }
}



/**
 * Your BrowserHistory object will be instantiated and called as such:
 * $obj = BrowserHistory($homepage);
 * $obj->visit($url);
 * $ret_2 = $obj->back($steps);
 * $ret_3 = $obj->forward($steps);
 */
/**
 * leetcode - 剑指 Offer II 041. 滑动窗口的平均值
 *
 */