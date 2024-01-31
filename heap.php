<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:19
 */
/**
 * 堆 topK的问题
 */
ini_set("display_errors","On");
ini_set("error_reporting","E_ALL");
/**
 * 下面是遇到的问题；？？？
 */
//echo floor((0-1)/2);die;
//$arr = [1,2,3,4];
//$index = 0;
//
//$index2  = ($index - 1) >> 1;// 所以这里有问题？ //php数组会自动取整，所以 -1 找不到 ，但是-0.5会转换成0；所以可以找得到；
//$index1 = ($index - 1)/2;
//echo $arr[$index - 1 >> 1];  // -1 >> 1还是-1;
//echo "\n";
//echo $arr[($index - 1)/2];
//echo "\n";
//echo $index2;
//echo "\n";
//echo $index1;
//die;
/**
 * 堆的分类 ： 大顶堆和小顶堆；
 * php 标准库;
 */
//大顶堆
//$obj = new SplMaxHeap();// 看一下这个// php标准库的heap 堆；
//大顶堆和小顶堆的实现方式

/**
 * 堆
 */

class Heap
{
    public  $heap= [];
    public  $heapsize = 0; //index要插入的元素 index索引；

    public function insert($val) {
        $this->heap[$this->heapsize] = $val;
        $this->heapsize++;
        $this->upheapify($this->heapsize - 1);
    }

    /**
     * 上浮过程
     * floor 来解决 越界的问题；
     */
    public function upheapify($index) {

        while ($this->heap[$index] > $this->heap[floor(($index - 1 )/2)]) {
            $this->swap($this->heap[$index], $this->heap[($index - 1)/2]);

            // 这边因该可以把  // 算术运算优先级高于 位运算；
            $index = floor(($index - 1)/2);
        }
    }
    // swap
    protected function swap(&$val, &$val1) {
        $mid = $val;
        $val = $val1;
        $val1 = $mid;
    }

    public function lookHeap() {
//        foreach ($this->heap as $item) {
//            echo $item.'---';
//        }
        //因为软删除 所以 这边要通过控制heapsize来控制 堆的大小；
        for ($i = 0; $i < $this->heapsize; $i++) {
            echo $this->heap[$i]."---";
        }
    }
    // return max element
    public function peek() {
        return $this->heap[0];
    }
    //下沉 删除最大值元素
    // 删除最大值 并且返回最大值
    // extract  提取 萃取；拿出来
    public function extract() {
        $max = $this->heap[0];
        //delete swap 最好不好去删除 最好swap 交换时间复杂度比较低 如果直接删除 时间复杂度是O(n);
        //swap时间复杂度是O(1);
        $this->swap($this->heap[0], $this->heap[$this->heapsize - 1]);
        //软删除
        $this->heapsize--;
        // 向下的堆化；
        $this->downHeapify(0);
        return $max;
    }
    // 说白了就是寻找最大node；
    //
    public function downHeapify($index) {
        $left = $index * 2 + 1;
        while ($left  < $this->heapsize) {
            //左右node的结点的最大值； // 注意相等的时候 先放左边的保持稳定性；
            // 也要注意溢出的问题；
            $largest =  $left + 1 < $this->heapsize && $this->heap[$left + 1]  > $this->heap[$left] ? $left + 1 : $left;
            //头结点和largest的最大值；
            $largest = $this->heap[$largest] > $this->heap[$index] ? $largest : $index;
            // 就是找到了位置不需要下沉了！
            if ($largest == $index) {
                break;
            }
            //头结点和largest做交换
            $this->swap($this->heap[$index], $this->heap[$largest]);
            //增量//子节点包含最大值；所以 左边变成了left = $largest * 2 + 1;
            $left = $largest * 2 + 1;
        }
    }
    /**
     * build_heap创建堆
     * 根据不同的downheapify来创建大顶堆 和小顶堆；
     * // 完全二叉树的非叶子节点数是 floor($len >> 1) 向下取整；
     */
    public function buildHeap($arr) {
        $this->heap = $arr;
        $len = count($arr);
        $this->heapsize = $len;
        // 非叶子结点要做向下堆化
        $start = floor($len >> 1);
        //$i 就是头结点，非叶子结点，要去交换，叶子结点也需要比较但是不需要交换；
        for ($i = $start; $i >= 0; $i--) {
            //向下downheapify
            $this->downHeapify($i);
        }
    }
    //时间复杂度是nlogn
    //原地操作
    //创建堆  然后堆排序；
    //不稳定的；堆排序是不稳定的；
    public function heapSort($arr) {
        // 创建堆
        $this->buildHeap($arr);
        $len = count($arr);
        if ($len == 0 || $len == 1) return;
        while ($this->heapsize > 0) {
            //这里就是extract $this->extract();//
            // $this->extract(); 等价下面的一系列操作；
            $this->swap($this->heap[0], $this->heap[$this->heapsize - 1]);
            $this->heapsize--;
            $this->downHeapify(0);

        }
    }
}

//$heaparr = [1,2,34,55,5,8,10];
//$obj->heapSort($heaparr);
//$obj = new Heap();
//$obj->insert(5);
//$obj->insert(6);
//$obj->insert(8);
//$obj->insert(4);
//echo "\n";
//echo $obj->peek();
//$obj->extract();
//echo "\n";
//$obj->lookHeap();
//$obj->buildHeap($heaparr);
//$obj->heapSort($heaparr);
//var_dump($obj->heap);die;
//  也是这里已经位0 了 所以 我们需要直接拿到相当于已经被软删除了；// 所以看不到；
//$obj->lookHeap();
