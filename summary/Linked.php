<?php


/**
 * 链表；Linked list  链表；
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
 * 移除链表的元素；
 *  */

/**
 * leetcode --- 203 移除链表元素
 * 链表的移除需要知道上一个节点；
 * 为了后面返回$head 指针所以 要定义一个临时指针去遍历
 * 最主要的原因，是链表的删除和增添，当删除头节点和删除其他节点的方式是不一样的，需要分类去讨论，这边加一个虚拟节点直接进行操作；
 *  */

function removeElements($head, $val)
{
    // 我记得可以加一个哨兵的方式来进行计算；

    $guard = new ListNode(0, $head); // 给$head 添加一个哨兵；
    $cur = $guard;
    // NULL head == NULL
    // 只有一个元素

    // 大于等于1个元素怎么办；因为有虚拟节点所以所有的节点都判断了；
    while ($cur) {
        //删除 要知道上一个节点；
        if (isset($cur->next) && $cur->next->val == $val) {
            //删除一个链表的元素；
            //删除了之后就不需要移动cur指针了；
            $cur->next = $cur->next->next;
        } else {
            $cur = $cur->next;
        }
    }
    // 删除哨兵；
    return  $guard->next;
}


/**
 * 链表的翻转 使用的是 双指针；
 * 链表的翻转； --- 经典题型；
 */

function reverseList($head)
{
    $cur = $head;
    $pre = NULL;
    while ($cur) {
        $store = $cur->next;
        $cur->next = $pre;
        $pre = $cur;
        $cur = $store;
    }
    return $pre;
}
// var_dump(reverseList($head)); // 链表的翻转；

/**
 * 设计链表
 * leetcode -- 707的题目；
 * 707. 设计链表
 */

class MyLinkedList
{
    //链表的头节点；
    public $head;
    //链表的长度
    public $size;
    //记录链表的尾节点；----这里怎么去记录尾节点？？？？这里还挺麻烦的！！！
    public $tail;

    /**
     * 做数据的初始化；
     */
    function __construct()
    {
        //创建虚拟节点；
        //但是size = 0；
        $this->head = new ListNode(0);
        $this->size = 0;
    }


    /**
     * @param Integer $index
     * @return Integer
     * 获得第n个节点的值；$index 从 0开始；
     */
    function get($index)
    {
        if ($index < 0 || $index + 1 > $this->size) return -1;
        // $cur 就是代表index = 0的节点；
        $cur = $this->head->next;
        $i = 0;
        while ($index) {
            $cur = $cur->next;
            $index--;
        }
        return $cur->val;
    }

    /**
     * @param Integer $val
     * @return NULL
     * 链表的头部插入；
     * 默认使用虚拟节点；
     */
    function addAtHead($val)
    {
        //头部插入 使用的是虚拟节点；
        // 关于 增加一个节点的 执行顺序问题；
        $cur = $this->head;
        $newNode = new ListNode($val);
        $newNode->next = $cur->next;
        $cur->next = $newNode;

        $this->size++;
        //更新 尾节；
        // if ($cur->next->next == NULL) {
        //     $this->tail = $cur->next;
        // }
    }


    /**
     * @param Integer $val
     * @return NULL
     * 链表的尾部插入；
     */
    function addAtTail($val)
    {
        //不然这里能先进性查询找到最后一个节点 然后再进行插入；
        // 先用遍历试试呗；
        $cur = $this->head;
        $newNode = new ListNode($val);
        while ($cur->next != NULL) {
            $cur = $cur->next;
        }
        //最后一个节点；
        $cur->next = $newNode;
        $this->size++;
        //这边肯定不需要呀，傻逼吗？？？ 这边是句柄呀；
        // $this->head = $cur;

        // 尾部节点的更新；
        // $this->tail = $newNode;
    }

    /**
     * @param Integer $index
     * @param Integer $val
     * @return NULL
     * 在第n个节点前插入节点；
     * 第0节点前插入数据呢？
     * 
     * 将一个值为 val 的节点插入到链表中下标为 index 的节点之前。如果 index 等于链表的长度，那么该节点会被追加到链表的末尾。如果 index 比长度更大，该节点将 不会插入 到链表中。
     * 关于边界条件 多去举例子；去测试；
     */
    function addAtIndex($index, $val)
    {
        //extra 大于 直接不再插入；
        if ($this->size < $index) return;

        $cur = $this->head;
        //要找到 n - 1 节点  才能进行插入；
        while ($index) {
            $cur = $cur->next;
            $index--;
        }
        //$cur就是上一个节点，添加节点；
        $newNode = new ListNode($val);
        $newNode->next = $cur->next;
        $cur->next = $newNode;
        $this->size++;
       
    }

    /**
     * @param Integer $index
     * @return NULL
     * 删除某个节点；
     */
    function deleteAtIndex($index)
    {
        //删除失败；not find
        if($index <0 || $index + 1 > $this->size) return -1;

        //需要知道上一个节点
        $cur = $this->head;
        while($index) {
            $cur = $cur->next;
            $index--;
        }
        $cur->next = $cur->next->next;
        $this->size--;
    }
}

// $myLinkedList = new MyLinkedList();
// echo $myLinkedList->addAtHead(1);
// $myLinkedList->addAtTail(3);
// $myLinkedList->addAtIndex(1, 2);    // 链表变为 1->2->3
// echo $myLinkedList->get(1);             // 返回 2
// $myLinkedList->deleteAtIndex(1);    // 现在，链表变为 1->3
// // var_dump($myLinkedList->head);die;
// echo $myLinkedList->get(1);              // 返回 3

/**
 * 两两交换链表中的节点；
 * 也是需要虚拟机节点，不然第一个点和中间的节点是不一样的；
 * leetcode --- 24;
 */

 function swapPairs($head) {
    //链表的特殊情况也要考虑；链表是NULL 或者链表只有一个节点，都需要去考虑；
    //特殊情况；
    if ($head == NULL || $head->next == NULL) return $head;
    // 初始化； --- 虚拟节点；
    $dummyNode = new ListNode();
    $dummyNode->next = $head;

    $newHead = $head->next; // 第二个节点；

    $r = $head->next; 
    $l = $head;

    while ($r) {
        //虚拟节点也要去移动两个； 先保存一下；不然就乱套了；
        $midl = $l->next->next;
        $midr = $r->next->next;
        //交换规则
        $l->next = $r->next;
        $r->next = $l;
        $dummyNode->next = $r;
        //还要知道上一个节点； 最好使用虚拟节点；

        $r = $midr;
        $l = $midl;
        // 这个也要移动两次；妈的；
        $dummyNode = $dummyNode->next->next;
    }
    //双指针 每次去移动两个指针；
    return $newHead; 
}
/**
 * more 
 * 注意结束条件；偶数，或者奇数的结束条件；
 * 偶数 就是 $cur->next == NULL 
 * 奇数 就是 $cur->next->next == NULL;
 */
function swapPairs1($head) {
    if ($head == NULL && $head->next == NULL) return $head;
    $dummy = new ListNode();
    $dummy->next = $head;
    $cur = $dummy;
    //结束条件； 注意一下；
    // $cur->next-> == NULL  || $cur->next == NULL也是代表条件结束；分别代表奇数和偶数；
    // 不能翻着写，反着写会发生空指针异常；
    //结束条件的判断 这点会很重要；
    while ($cur->next && $cur->next->next ) {
        $tmp = $cur->next;
        $tmp1 = $cur->next->next->next;

        //swap
        $cur->next = $cur->next->next;
        $cur->next->next = $tmp;
        $tmp->next = $tmp1;
        //cur 增长；
        $cur = $cur->next->next;
    }
    return $dummy->next;
}
var_dump(swapPairs(new ListNode(1,new ListNode(2))));die;

/**
 * 删除链表倒数第N个节点；
 * 也是需要知道上一个节点；
 * 使用虚拟节点 就是为了不要对节点数来做一个特殊判断，到底是该head 只有一个节点或者是有多个节点，操作是不一样的；
 * 可以使用快慢指针；
 * leetcode ---  CR 021. 删除链表的倒数第 N 个结点
 * 1 <= $n <= $sz
 * 思想：
 * fast 先走N+1  ，然后快慢指针一起走，快指针走到低，慢指针所停下的位置就是倒数N+1；
 * 
 * 快慢指针保持一个距离，当快指针到了链表结尾，满指针正好是n+1位置；需要注意的是，删除要直到上一个节点；
 *  */

 function removeNthFromEnd($head, $n) {
    $dummyHead = new ListNode(-1,$head);
    //一定创建临时变量去操作链表；
    $cur = $dummyHead;
    $fast = $cur;
    $slow = $cur;
    //$fast 先走n+1 个节点；
    // 走n + 1次；第一次就是第一个节点，走n+1次就是第n+1个节点；
    // dummyHead 算是第0个节点；
    $n = $n + 1;
    while($n) {
        $fast = $fast->next;
        $n--;
    }
    //fast 走到最后；
    while($fast) {
        $fast = $fast->next;
        $slow = $slow->next;
    }
    // $slow就是倒数 N+1 个节点；
    $slow->next = $slow->next->next;
    return $dummyHead->next;
 }

/**
 * 环形链表；
 * 快慢指针来判断是否有环；
 * */
/**
 * 判断是否有环  leetcode -- 141
 * 快慢指针相遇 才会有环;
 * 快指针每次移动2个节点，慢指针每次移动1个节点，那么相当于快指针每次移动一个节点去追慢指针，所以肯定不会跳过慢指针，最终会相遇；如果快指针每次移动3个节点，那么有可能跳过；
 */
function hasCycle($head) {
    $fast = $head;
    $slow = $head;

    while ($fast && $fast->next != NULL)  {
        //$fast !== NULL 但是下一个节点有可能是NULL；
        //注意 NULL->next 是不存在的呀；
        $fast = $fast->next->next;  // 注意出现空指针异常；
        $slow = $slow->next;
        // 有可能存在fast slow  全部都是NULL的情况；所以这里判断必须 fast 不能为NULL；
        // $fast === $slow;
        //快指针不能为NULL；
        //先去移动 再去做判断；需要判断是否为NULL；
        if ($fast === $slow) {
            return true;
        }
    }

    return false;
}
// var_dump(hasCycle($head));die;
/**
 * 判断一个链表是否有环，并且判断环的入口；
 * leetcode --- 142
 * head 到入口点distant1 等于 快慢指针的相遇点 到入口点的距离distant2 可以是相等的,只不过distant2说不定多转几圈而已；
 */
function detectCycle($head) {
    $fast = $head;
    $slow = $head;
    while($fast && $fast->next != NULL) {
        // 出现了 这个$fast->next->next 就必须 保证$fast->next != null;
        $fast = $fast->next->next;
        $slow = $slow->next;
        if ($slow === $fast) {
            // 相遇了
            $index1 = $fast;
            $index2 = $head;
            //不相等那么一直往下走；
            while ($index1 !== $index2) {
                $index2 = $index2->next; 
                $index1 = $index1->next;
            }
            //相等了，那么就返回；
            return $index1;
            /**
             *案例是 [1,2] pos = 0; 那么就可能是这种情况；
             *  */ 
            // while ($index1) { 
            //     //有可能一开始就像等；
            //     if ($index1 === $index2) {
            //         return $index1;
            //     }
            //     $index2 = $index2->next; 
            //     $index1 = $index1->next;
            // }
        }
    }
    return NULL;
}

/**
 * extra-extends 扩展知识 
 * dummyNode
 *  虚拟节点数目；--- 经常用于  节点的删除和增添，因为节点数不同会执行不同的代码，加上虚拟节点就一套代码就可以实现；
 */

/**
 * 遍历的问题；
 * 链表 就是 第三个节点；
 * 12345
 * 加上虚拟节点  $n = 1就是第一个节点；2就是第二个节点；3 就是第三个节点；
 * 包含 虚拟节点;
 * 稍微注意一下细节就行了；
 *  */ 
// $n = 3;
// $dummyHead = new ListNode(-1,$head);
// $cur = $dummyHead;
// while ($n) {
//     $cur = $cur->next;
//     $n--;
// }

// var_dump($cur);//3

/**
 * 不包含虚拟节点；
 * 0 才是第一个节点，1 是第二个节点ListNode(2) , 2 是第三个节点ListNode(3)
 */

$n = 3;
$cur = $head;// 0的就是$cur节点了；1 就会是下一个节点；
while ($n) {
    $n--;
    $cur = $cur->next;
}
var_dump($cur);//4

/**
 * 对于一些边界条件，或者一些特殊情况，只能带入参数去不断尝试；
 * 比如 ： 链表只有一个节点，或者链表为NULL的情况；这两种特殊条件都需要去考虑；
 */


 /**
  *  注意判断 是否为NULL；
  *  尤其是链表next 之后下一个是否为NULL的判断；
  *  用isset() 来判断是否为NULL；
  * 每一次 next 都需要去做 是否为NULL的判断；注意！！！！
  * 
  * * */

  /**
   * 
   * $fast != NULL  但是当你做 $fast->next->next 的判断的时候  也要保证$fast->next != NULL 才行；
   * 注意空指针异常的问题， 需要判断 $fast->next != NULL 才可以；
   */


/**
 * 无论是节点的删除，或者节点的插入，都需要直到上一个节点；才能删除或者插入；
 */

/**
 * 注意空指针 异常；
 * 在访问节点之前，始终检查节点是否为空。在对链表节点进行操作之前，应该先判断节点是否为空，以避免空指针异常的发生。
 *  */ 