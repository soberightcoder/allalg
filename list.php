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
$head = new ListNode(1, new ListNode(1, new ListNode(1, new ListNode(1, new ListNode(1)))));
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


// $head1
$i = new ListNode(1);
$j = new ListNode(2);
$k = new ListNode(3);
$l = new ListNode(4);
$i->next = $j;
$j->next = $k;
$k->next = $l;
$head1 = $i;

// $head1 =
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


/**
 * 删除链表的节点
 * 需要找上一个结点
 * https://leetcode.cn/problems/shan-chu-lian-biao-de-jie-dian-lcof/
 */

/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 *给定单向链表的头指针和一个要删除的节点的值，定义一个函数删除该节点。返回删除后的链表的头节点。

1.此题对比原题有改动
2.题目保证链表中节点的值互不相同
3.该题只会输出返回的链表和结果做对比，所以若使用 C 或 C++ 语言，你不需要 free 或 delete 被删除的节点
 *
 * @param head ListNode类
 * @param val int整型
 * @return ListNode类
 */
function deleteNode( $head ,  $val )
{
    // write code here
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $stage = $dummy;

    while ($dummy->next != null) {
        if ($dummy->next === $val) {
            $middle = $dummy->next->next;
            $dummy->next = $middle;
            break;
        }
        $dummy = $dummy->next;
    }

    return $stage->next;
};
//var_dump(deleteNode($head1,$j));die;
//var_dump(deleteNode($head1,$i));die;


/**
 * https://leetcode.cn/problems/remove-duplicates-from-sorted-list-ii/
 * 删除链表重复的元素 11
 * // 只要是相同的都删除；
 *
 */

/**
 * @param $head
 * @return null
 * https://leetcode.cn/problems/remove-duplicates-from-sorted-list/
 * // 要求删除 只出现一次就好了；
 */
function deleteDepulication($head) {
    if ($head == null) return null;

    $set = [];//set
    $set[$head->val] = 1;
    $stage = $head;
    while ($head->next != null) {
        if (isset($set[$head->next->val])) {
            // delete need ahead node;
            //exitsts；
            $middle = $head->next->next;
            $head->next = $middle;
            // not move 指针；
        } else {
            $set[$head->next->val] = 1;
            $head = $head->next;
        }
    }
    return $stage;
}

//var_dump(deleteDepulication($head));die;


// set 来求解  用集合来求解，先计算出  出现的次数，然后删除出现次数大于等于2的元素；
//时间复杂度：
//O(N)，对链表遍历了两次；
//空间复杂度：
//O(N)，需要一个字典保存每个节点值出现的次数。

function deleteDuplicates($head) {
    if ($head == null) return null;

    $set = [];
    $set[$head->val] = 1;
    $stage = $head;
    while ($head->next != null) {
        if (isset($set[$head->next->val])) {
            //exists
            // ++1;
            $set[$head->next->val]++;

        } else {
            // not exists
            $set[$head->next->val] = 1;
        }
        $head = $head->next;
    }
    //头结点也可能要删除；所以 需要一个虚拟结点会好一些；// 头节点 head 结点的删除 可以给一个虚拟结点就可以了；
    foreach ($set as $key=>$item) {
        if ($item >=2) {
            deleteNodezen($stage,$key);
        }
    }

    return $stage;
}


// 传引用；//删除 相等元素；
function deleteNodezen(&$head,$val) {
    $dummy = new ListNode(-1);
    $dummy->next = $head;
    $stage = $dummy;

    while ($dummy->next != null) {
        if ($dummy->next->val == $val) {
            $middle = $dummy->next->next;
            $dummy->next = $middle;
        } else {
            $dummy = $dummy->next;
        }
    }

    $head = $stage->next;
}
//var_dump(deleteDuplicates($head));die;

//
//deleteNodezen($head,2);
//var_dump($head);die;

//2  思维是遇到相同的结点都跳过去也就是都删除掉；// s时间复杂度是O(n)  k空间复杂度是O(1)

/**
 * 复杂链表的复制
 * 难点： 就是找 原结点和clone结点的对应关系；
 */
//php 不能用哈希方式 先建立 key 和value的对应关系，但是php的key 是不能存储对象的，所以 这种方式肯定是行不通的；
// 所以注定不能用哈希表的方式来进行遍历
class RandomListNode{
    var $label;
    var $next = NULL;
    var $random = NULL;
    function __construct($x){
        $this->label = $x;
    }
}

$aa = new RandomListNode(1);
$bb = new RandomListNode(2);
$cc = new RandomListNode(3);
$dd = new RandomListNode(4);
$ee = new RandomListNode(5);

$aa->next = $bb;
$bb->next = $cc;
$cc->next = $dd;
$dd->next = $ee;


$aa->random = $cc;
$bb->random = $ee;
$cc->random = NULL;
$dd->random = $bb;
$ee->random = NULL;

$randomHead = $aa;
/**
 * @param $head
 * 1.此解法参考了大佬的做法, 主要思路是将原链表的结点对应的拷贝节点连在其后, 最后链表变成 原1 -> 拷1 -> 原2 -> 拷2 -> ... -> null 的形式
    2.然后我们再逐步处理对应的随机指针, 使用双指针, 一个指针指向原链表的节点, 一个指向拷贝链表的节点, 那么就有 拷->random = 原->random->next (random不为空)
    3.最后再用双指针将两条链表拆分即可, 此算法大大优化了空间复杂度, 十分优秀
 */
function MyClone($head)
{
    // write code here copy;
    // clone;

    if ($head == null) return;
    $stage = $head;//stage
    // 找到对应关系
    // 原结点->clone node ->原结点->clone node;
   while ($head != null) {
       //
       $mid = $head->next;
       $head->next = new RandomListNode($head->label);
       $head->next->next = $mid;
       $head = $mid;
   }
//   print_r($stage);die;
   // 双指针
   $old = $stage;
   $clone = $stage->next;
   $ret = $stage->next;
   while ($clone != null) {
       //find clone random node
       $clone->random = $old->random == NULL ? NULL : $old->random->next;
       //
       $old = $old->next->next;
       $clone = $clone->next->next;// 越界会不会是null？？
   }

   $old = $stage;
   $clone = $stage->next;

   while ($clone != null) {
        $old->next = $old->next->next;
        $clone->next = $clone->next->next;
        $old = $old->next;
        $clone = $clone->next;
   }
   //delete 删除原结点

   return $ret;
}

//print_r(MyClone($randomHead));die;  // k可以打印对象 格式可读性比较好看；
$ret = MyClone($randomHead);
//print_r($ret->random);//$cc
//print_r($ret->next->random);//$ee
//print_r($ret->next->next->random);//null
//print_r($ret->next->next->next->random);//$bb
//print_r($ret->next->next->next->next->next->random);//null
// 会自动补NULl 不需要去判断空指针； c语言需要去判断空指针；
//var_dump($head->next->next->next->next->next->next->next->next);die;// NULL

