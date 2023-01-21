<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:14
 */


/**
 * Class CQueue
 * 两个栈实现一个队列；
 * 先入先出；FIFO;
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
         if (!empty($this->stack2)) {
             // 清空
             $this->stack2 = [];
         }

        array_push($this->stack1,$value);
    }

    /**
     * @return Integer
     */
    function deleteHead() {

        $this->help();
        if (empty($this->stack2)) return -1; // -1

        return array_pop($this->stack2);
    }

    public function help() {
        // stack1 出栈；
        //插入到stakc2
        // $this->>stack1 == null 那么就是
        while ($item = array_pop($this->stack1)) {
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
