<?php
/**
 * 了解一下把；
 * 大顶堆 和小顶堆，主要用于解决 topK的问题；
 * 然后去实现一下； 
 * 就是一个向上的堆化，和向下的堆化的过程；
 * 上浮动 和下沉的过程 实现一下；
 * 注意的是，堆是用数组来存储的；虽然结构是树，但是不是用链表来存储的；
 */

class Heap
{
    public $heap = [];
    // 0代表的是待插入的pos；
    public $heapSize = 0;

    public function insert($x)
    {
        $this->heap[$this->heapSize] = $x;
        $this->heapSize++;
        $this->upHeapify($this->heapSize - 1);
    }
    /**
     *  上浮堆化
     * 时间复杂度是logn
     */
    public function upHeapify($index)
    {
        // > 0 就是大顶堆；
        while ($this->heap[$index] > $this->heap[($index - 1) / 2]) {
            $this->swap($this->heap[($index - 1) / 2], $this->heap[$index]);
            // 因为交换了位置，所以 $index 变成了 ($index - 1) / 2
            $index = ($index - 1) / 2;
        }
    }
    /**
     * 交换两个元素的值；
     * 
     */
    public function swap(&$x, &$y)
    {
        list($x, $y) = array($y, $x);
    }
    /**
     * 怎么 写的 源代码 是怎么实现的SplHeap 可以实现大顶堆和小顶堆的模板方法；
     * 大顶堆； 了解一下把；
     */
    public function compare($value1, $value2)
    {
        return $value1 - $value2;
    }

    public function peek()
    {
        return $this->heap[0];
    }

    public function extract()
    {
        $peek = $this->heap[0];
        $this->swap($this->heap[0], $this->heap[$this->heapSize - 1]);
        // 软删除；下一次输入的数据会覆盖，该内容；
        $this->heapSize--;
        //下沉堆化的过程；
        $this->heapifyDown(0);
        return $peek;
    }
    /**
     * 一直下沉的过程，直到他该到的位置；
     * 时间复杂度是logn
     */
    public function heapifyDown($index)
    {
        // 找出最最大孩子的堆化；
        $leftSon  = $index * 2 + 1;

        while ($leftSon < $this->heapSize) {
            //找到孩子的最大值；
            $large = $leftSon + 1 < $this->heapSize && $this->heap[$leftSon + 1] > $this->heap[$leftSon] ? $leftSon + 1 : $leftSon;
            // 儿子最大值和父亲比较；
            $large = $this->heap[$large] > $this->heap[$index] ? $large : $index;

            if ($large == $index) {
                break;
            }
            //交换位置；
            $this->swap($this->heap[$index], $this->heap[$large]);

            $index = $large;

            $leftSon = $index * 2 + 1;
        }
    }

    public function lookHeap()
    {
        //真实的heap
        for ($i = 0; $i < $this->heapSize; $i++) {
            echo $this->heap[$i] . "---";
        }
    }
    /**
     * 堆排序；
     *  */

    public function heapSort($nums, $n)
    {
        $res = [];
        if ($n == 0 || $n == 1) return $nums;
        $this->buildMaxHeap($nums, $n);
        // var_dump($this->heap);die;
        /**
         * nlogn 时间复杂度是nlogn
         *  */ 
        while ($this->heapSize > 0) {
           $res[] =  $this->extract();
        }
        return $res;
    }

    /**
     * 根据数组创建一个初始堆；
     * 时间复杂度是多少？O(n) 为什么 这里的时间复杂度是O(n)
     * 需要需要
     * 建堆，从非叶子节点 从下往上堆化；
     */
    public function buildMaxHeap($nums, $n)
    {
        $this->heap = $nums;
        $this->heapSize = $n;
        $start = floor($n >> 1);
        for ($i = $start; $i >= 0; $i--) {
            $this->heapifyDown($i);
        }
    }
}

//eg:
$heapObj = new Heap();
// $heapObj->insert(10);
// $heapObj->insert(11);
// $heapObj->insert(9);
// $heapObj->insert(12);
// $heapObj->insert(10);
// $heapObj->insert(2);
// $heapObj->extract();
// $heapObj->extract();
// $heapObj->lookHeap();
// echo $heapObj->peek();

var_dump($heapObj->heapSort([3,4,5,6,67,99],6));


/**
 * 数组中的第 k 大的数字 --leetcode 剑指offer 076
 * TOPk问题；
 *  */ 

 class Solution {

    /**
     * @param Integer[] $nums
     * @param Integer $k
     * @return Integer
     */
    function findKthLargest($nums, $k) {
        $heap = new SplMinHeap();
        foreach($nums as $val) {
            if ($heap->count() < $k) {
                $heap->insert($val);
            } else {
                if ($heap->top() < $val) {
                    $heap->extract();
                    $heap->insert($val);
                }
            }
        }
        //
        return $heap->top();
    }
}

/**
 * 
 * 
 * extra extends 额外的扩展 解决第一个问题：
 * 为什么 堆要用数组来保存； 内存利用率高；节约内存，
 */

/**
 * 从一个节点到父节点之间的关系；
 * 规律： i是node结点；左：i*2+1 ；右：i\*2+2 ;父结点： i-1/2(默认是向下取整);
 */


/**
 *  compare 的实现原理： compare方法接受两个参数，表示要比较的两个元素。它应该返回一个整数，表示这两个元素的大小关系。如果第一个元素小于第二个元素，则返回一个负数；如果第一个元素大于第二个元素，则返回一个正数；如果它们相等，则返回0。
 */

/**
 * 
 * 好好去了解一下 比较重要的接口；
 *  Iterator  IteratorAggregate 两种迭代器 一种是用foreach 遍历一种数组属性，一个是遍历全部的属性；
 *  coutable arrayaccess   第一种就是可以使用count();函数来进行计数，另外一种是可以通过对象加[]的形式来访问数据；
 * 
 *  */



/***
 * 
 * topK 维护一个K的堆，
 */

/**
 * 堆排序的时间复杂度为O(n log n)。在最坏、平均和最好的情况下，堆排序的时间复杂度都是O(n log n)，其中n是要排序的元素数量。堆排序是一种原地排序算法，因此不需要额外的空间来存储临时数据，但它的时间复杂度相对较高。堆排序的优点是在最坏情况下仍然能够保持O(n log n)的时间复杂度，并且不受输入数据的影响。
 * 堆排序的空间复杂度为O(1)，即为常量级空间复杂度。堆排序是一种原地排序算法，它不需要额外的空间来存储临时数据，因此空间复杂度非常低。无论输入数据的规模如何，堆排序所需的额外空间都保持不变。
 * 稳定性的；
 * 而且比较擅长做topK的操作；
 * 堆排序是不稳定的排序算法。由于在堆排序中，对堆进行调整时会涉及元素的交换操作，这可能会导致相同元素之间的相对顺序发生变化，因此堆排序是不稳定的。
 *  */ 

 /**
  * 

  */


//1、在建堆阶段，首先将待排序的元素构建成一个堆（大顶堆或小顶堆）。从最后一个非叶子节点开始，逐步向上调整，使得每个节点都满足堆的性质。在调整的过程中，可能需要交换节点的位置来满足堆的性质。这个交换操作会改变相同键值元素的相对顺序，从而导致排序的不稳定性。

//2、在排序阶段，每次从堆顶取出最大（或最小）元素，将其放到已排序部分的末尾，然后对剩余未排序的部分进行堆调整，重复这个过程直到所有元素都被放置到正确的位置上。这个过程中同样会涉及交换操作，进一步破坏了相同键值元素的相对顺序，导致排序的不稳定性。

//总结起来，堆排序是通过反复调整元素位置来完成排序的过程，其中涉及到交换操作。这些交换操作可能导致相同键值元素的相对顺序发生变化，因此堆排序是一个不稳定的排序算法。如果希望实现稳定性排序，可以选择其他稳定的排序算法，如冒泡排序、插入排序或归并排序。
