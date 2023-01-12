<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:14
 */
ini_set('display_error','on');
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);
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
// 循环list
$a = new ListNode(1);
$b = new ListNode(2);
$c = new ListNode(3);
$d = new ListNode(4);
$e = new ListNode(5);
$a->next = $b;
$b->next = $c;
$c->next = $d;
$d->next = $e;
$e->next = $c;
$circleHead =  $a;

// 特例
$onlyoneNodeHead = new ListNode(1);
// last最后一个节点循环自己；
$f = new ListNode(1);
$g = new ListNode(2);
$h = new ListNode(3);
$f->next = $g;
$g->next = $h;
$h->next = $h;
$lastelecircleHead = $f;
/**
 * 牛客-- 剑指offer；
 * JZ6 从尾到头打印链表；
 */

$res = [];
function printListFromTailToHead( $head )
{
    // write code here
    if ($head == null) return;
    printListFromTailToHead($head->next); // 虽然会有返回但是我不去接收；
    // 归之后 的数据遍历
    $GLOBALS['res'][] = $head->val;
    // 第一层 的输出数据，虽然递归并不会接收这个数据；
    return $GLOBALS['res'];
}
//var_dump(printListFromTailToHead($head));die;


/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 *
 * @param head ListNode类
 * @return ListNode类
 * 要 多注意 那些鲁棒性，一些特殊情况也要去考虑；
 */
$reversehead = null;
function ReverseList( $head )
{
    // write code here
    if ($head == null) return;
    $stage = $head->next;// 存储一下；next element;
    $head->next = $GLOBALS['reversehead'];
    $GLOBALS['reversehead'] = $head;
    ReverseList($stage);
    return $GLOBALS['reversehead'];
}

//ReverseList($head);
//print_r($reversehead);
//print_r($head);
//die;

/**
 * 合并两个有序list 列表
 */

/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 *
 * @param pHead1 ListNode类
 * @param pHead2 ListNode类
 * @return ListNode类
 * 双指针去做一个合并；
 * need： time：O(n) space O(1);
 */
function Merge( $pHead1 ,  $pHead2 )
{
    $mergehead = new ListNode(-1);// 虚拟节点// 搞一个虚拟节点；
    $stage = $mergehead;//存储一下；
    // write code here
    while ($pHead1 !=null && $pHead2 != null) {
        //
        if ($pHead1->val >= $pHead2->val) {
            $mergehead->next = $pHead2;
            $pHead2 = $pHead2->next;
        } else {
            $mergehead->next = $pHead1;
            $pHead1 = $pHead1->next;
        }
        //  ++
        $mergehead = $mergehead->next;
    }
    //
    if ($pHead2 == null) {
        $mergehead->next = $pHead1;
    }

    if ($pHead1 == null) {
        $mergehead->next = $pHead2;
    }

    //  删除虚拟节点；
    return $stage->next;
}

$test1head = new ListNode(1, new ListNode(3, new ListNode(5, new ListNode(7, new ListNode(9)))));
$test2head = new ListNode(2, new ListNode(4, new ListNode(6, new ListNode(8, new ListNode(10)))));


//var_dump(Merge($test1head,$test2head));die;



/**
 * 判断两个 list 有没有相交
 */
//1  sapce:O(n)  时间O(n)
// php array key 没有深度遍历去重，所以不能保存数组和对象； 不能保存复式数据结构；
function FindFirstCommonNode1($pHead1, $pHead2)
{
    // write code here
    //php set //插入失败那么就会返回是相交点
    $set = [];//集合
    //  php 可以保存对象吗？ key？？？
    // 不能保存 value 只能保存 对象要保证next 一定也要相等；
    while ($pHead1 != null) {
        $set[$pHead1] = 1;
        $pHead1 = $pHead1->next;
    }
    while ($pHead2 != null) {
        if ($set[$pHead2])  {
            $pHead2 = $pHead1->next;
        }
        return $pHead2;
    }
}
//
//FindFirstCommonNode();

// 2 space:O(1) time:O(n)
function FindFirstCommonNode($pHead1, $pHead2) {
    //stage
    $p1 = $pHead1;
    $p2 = $pHead2;

    while ($p1 !== $p2) {
        if ($p1 == null) {
            $p1 = $pHead2;
        } else {
            $p1 = $p1->next;
        }

        if ($p2 == null) {
            $p2 = $pHead1;
        } else {
            $p2 = $p2->next;
        }
    }
    return $p1; //$p2 ; //没有交点也是null
}

/**
 *  判断一个 list 有没有环
 *  快慢指针；
 * 特例： 只有一个元素 怎么去判断是否带环；
 */

function isCircleList($head) {
    $fast = $head;
    $slow = $head;
    $fast = $fast->next->next;
    while ($fast != null && $fast->next != null)  {
        $fast = $fast->next->next;
        $slow = $slow->next;
        // 只有一个元素 $slow = null $fast = null
        if ($fast === $slow) {
            return true;
        }
    }
    return false;
}
//var_dump(isCircleList($circleHead));die;
//var_dump(isCircleList($onlyoneNodeHead));die;//

/**
 *  判断一个循环列表的入环节点；
 * first repeat node
 */
//1. space:O(n) time:O(n) php 数组的key 不能保存 复式数据类型，所以这里存的是值，必须要不相等才行；
function EntryNodeOfLoopset($pHead)
{
    $set = [];
    while ($pHead != null) {
        if ($set[$pHead->val] == 1) {
            // success
            return $pHead;
        } else {
            $set[$pHead->val] = 1;
            $pHead  = $pHead->next;
        }
    }
    // write code here
}

//var_dump(EntryNodeOfLoopset($circleHead));die;
/**
 * @param $pHead
 * 注意特例，当 x 不存在的时候
 *
 * ---x---entry-------y(meet)--------
 *          | ____________Z_________|
 *  slow = x + n(y+z) + y;
 *  fast = x + m(y+z) + y;
 * 2slow = fast;
 * (x+y) = (m-2n)(y+z)
 * x = (m-2n)(y+z) -y;
 *
 */

function EntryNodeOfLoop($pHead)
{
    $fast = $pHead;
    $slow = $pHead;
    // write code here
    while ($fast != null && $fast->next != null) {
        $fast = $fast->next->next;
        $slow = $slow->next;
        if ($fast === $slow) {
            break;
        }
    }
    //判断是否有环？
    if ($fast == null || $fast->next == null) return;
   //reset
    $fast = $pHead;
    while ($fast !== $slow) {
        $fast = $fast->next;
        $slow = $slow->next;
    }
    return $slow;
}

//var_dump(EntryNodeOfLoop($circleHead));die;
//var_dump(EntryNodeOfLoop($lastelecircleHead));die;


/**
 * list 最后k个节点
 *  栈 也是可以的； 最后k个；  space : O(n)   time : O(n);
 *  双指针   p1 先走k位置； p2再开始走； p1 到结束，p2的位置就是k的结点位置；
 */

/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 *
 *
 * @param pHead ListNode类
 * @param k int整型
 * @return ListNode类
 */
function FindKthToTail( $pHead ,  $k )
{
    $dummy = new ListNode(-1);
    $dummy->next = $pHead;

    // write code here
    $p1 = $dummy;
    $p2 = $dummy;

    for ($i = 1; $i <= $k; $i++) {
        $p1 = $p1->next;
        //  这里不应该判断虚拟结点；
        if ($p1 == null) {
            return null;
        }
    }

    while ($p1 != null) {
        $p1 = $p1->next;
        $p2 = $p2->next;
    }
    return $p2;
}
// 12345

//var_dump(FindKthToTail($head,5));die;


//

/**
 * list的中间点
 *  快慢指针
 * 奇数是不是会有两个呀
 *
 * 偶数 会不会有两个？？？？？
 */
function middleList($head) {

}

/**
 * 删除链表的第N个结点
 */