<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:17
 */

class TreeNode
{
    public $val;
    // 这两个节点 分别用来保存 节点对象;
    public $left;
    public $right;
    public function __construct($val) {
        $this->val = $val;
    }
}
//             13
//        10         16
//    9      11   14
$a = new TreeNode(13);
$b = new TreeNode(10);
$c = new TreeNode(16);
$d = new TreeNode(9);
$e = new TreeNode(11);
$f = new TreeNode(14);
// root == $a;
$a->left =  $b;
$b->left = $d;
$b->right = $e;
$a->right = $c;
$c->left = $f;
$root = $a;
/**
 * 树的深度
 */

function treeDepth($root) {
    if($root == null) return;
    return max(treeDepth($root->left),treeDepth($root->right)) + 1;
}
//echo treeDepth($root);

//遍历 直接往左走就行了；

/**

 * 之字形层级遍历
 */

/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 *
 * @param pRoot TreeNode类
 * @return int整型二维数组
 * // 函数
 * array_push
 * array_pop
 * array_shift // 头部删除
 * array_unshift // 头部插入
 * key(); 显示当前
 */

function PrintBinaryTree( $pRoot )
{
    $ret = [];
    // write code here // 1 2 3 4  奇数从左边插入  偶数从 右边插入；
    $queue = [];
    $flag = 0; // 0右到左，1 左到右；

    array_push($queue,$pRoot);// push

    while (!empty($queue)) {
        $len = count($queue);
        $tmparr = [];
        //循环多少次； 只需要修改打印方向就行了；
        for ($i = 0; $i < $len; $i++) {
            // pop
//            if ($flag) {
                $tmp = array_shift($queue);
//            } else {
//                $tmp = array_pop($queue);//
//            }
            if ($flag) {
                array_unshift($tmparr,$tmp->val);
            } else {
                $tmparr[] = $tmp->val;
//                array_push($ret[$key][],$tmp->val);
            }
            //push
//            if ($flag) { //1 z左到右
                // 注意不要插入null 要做判断；// 这里必须要判断不然插入的都是null 会报错；
                if (isset($tmp->left)) array_push($queue,$tmp->left);
                if (isset($tmp->right)) array_push($queue,$tmp->right);
//            } else { //0 右到左
//                if (isset($tmp->right)) array_push($queue,$tmp->right);
//                if (isset($tmp->right)) array_push($queue,$tmp->left);
//            }
        }
        $flag = $flag ^ 1;
        $ret[] = $tmparr;
    }

    return $ret;

}
//var_dump(PrintBinaryTree($root));die;
/**
 * leverl order
 * 层级遍历
 */
function levelOrder($root) {
    $queue = [];
    array_push($queue,$root);
    $ret = [];

    while (!empty($queue)) {
        $len = count($queue);
        for ($i = 0; $i < $len; $i++) {
            $tmp = array_shift($queue);
            $ret[] = $tmp->val;// 其实这里是一个对象；
            if (isset($tmp->left)) array_push($queue,$tmp->left);
            if (isset($tmp->right)) array_push($queue,$tmp->right);
        }
    }
    return $ret;
}
//var_dump(levelOrder($root));die;
/**
 * 中序遍历的倒叙；
 * https://leetcode.cn/problems/er-cha-sou-suo-shu-de-di-kda-jie-dian-lcof/
 * 找到第k大的结点值；
 */
class Soluation
{
    public $count = 0;
    public $ans = null;  // 注意这里右一个归的过程，所以必须需要外部变量来接收数据；

    public function kthLargest($root,$k) {
        $this->com($root,$k);
        return $this->ans;
    }

    function com($root,$k) {  // 每一个结点都会经历过三次 记住这个核心把；一个结点要经过三次；和只有前序和后序的不一样，只需要经过一两次就可以了；
        if ($root == null) return null;

        $this->com($root->right,$k);

//        if ((++$this->count) == $k) {
//            $this->ans = $root->val;
//            return;
//        }

        if ($k == (++$this->count)) {
            $this->ans = $root->val;
            return;  //因为这个com 没有return 所以不会右值的返回;
        }

        $this->com($root->left,$k);
    }
}
class Soluationbak
{
    public $count = 0;
    public $ans = null;  // 注意这里右一个归的过程，所以必须需要外部变量来接收数据；

    public function kthLargest($root,$k) {
        $this->com($root,$k);
        return $this->ans;
    }

    function com($root,$k) {  // 每一个结点都会经历过三次 记住这个核心把；一个结点要经过三次；和只有前序和后序的不一样，只需要经过一两次就可以了；
        if ($root == null) return null;

        $this->com($root->right,$k);

//        if ((++$this->count) == $k) {
//            $this->ans = $root->val;
//            return;
//        }

        if ($k == (++$this->count)) {  //可以接收的到吗？？？？
            $this->ans = $root->val;
            return;  //因为这个com 没有return 所以不会右值的返回;
        }
        //可以接收到吗？// 如果没有返回是接收不到的把？？？
        $this->com($root->left,$k);

    }
}
$obj123 = new Soluation();
$k = 2;

//var_dump($obj123->kthLargest($root,$k));die;

/**
 * 第k小的问题
 * 给定一棵结点数为n 二叉搜索树，请找出其中的第 k 小的TreeNode结点值。
1.返回第k小的节点值即可
2.不能查找的情况，如二叉树为空，则返回-1，或者k大于n等等，也返回-1
3.保证n个节点的值不一样
 */

function KthNode( $proot ,  $k )
{
    // write code here


}

/**
 * //双指针吗？  不同的遍历方向来判断；
 * 对称二叉树 是否对称吗？？
 */

class Solution1
{

    /**
     * @param TreeNode $root
     * @return Boolean
     *
     */
    function isSymmetric($root) {
        return $this->check($root,$root);
    }
    //
    function check($p,$q) {
        ///全部是全部是null 那么就是相等的意思；// 判断到结束了；全部是null;
        if (!$p && !$q) return true;
        // 有一个是空 另外一个不是空 那么返回false;
        if (!$p || !$q) return false;

        return ($p->val == $q->val && $this->check($p->left,$q->right) && $this->check($p->right, $q->left));
    }
}


/**
 * 判断是否是平衡二叉树；
 * 就是左右子树的高度相差不要超过1；
 */

class Solution2 {

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isBalanced($root) {
        if ($root == null) return true;

        return abs($this->heigh($root->left) - $this->heigh($root->right)) <= 1 && $this->isBalanced($root->left) && $this->isBalanced($root->right);
    }

    function heigh($root) {
        if ($root == null) return;  // php 中 NULL == 0；
        return max($this->heigh($root->left), $this->heigh($root->right)) + 1;
    }
}
/**
 *  每个结点所在的层数  输出结点 和结点所在的层数
 * root 默认是1 层
 * //             13
//        10         16
//    9      11   14
 */

class Solution3
{
    public function nodeLevel($root,$level) {
        if ($root == null) return;
//        print_r($root->val."---">$level);
        printf("节点 %d 在第 %d 层 \n",$root->val,$level);
        $this->nodeLevel($root->left,$level + 1);
        $this->nodeLevel($root->right,$level + 1);
    }
}
//$obj3 = new Solution3();
//$obj3->nodeLevel($root,1);

/**
 * Class Solution4
 * 如何打印出每个节点的左右子树各有多少节点？
 * return 树的总节点数  返回的是树的总节点数
 *
 */
class Solution4 
{
    public function numsNode($root) {
        if ($root == null) return 0;
        $leftnum = $this->numsNode($root->left);
        $rightnum = $this->numsNode($root->right);
        printf("节点 %d 的左子树节点数目 %d 右子树节点数目 %d \n",$root->val,$leftnum,$rightnum);
        return $leftnum + $rightnum  + 1; //左子树  + 右子树
    }
}

//$obj4 = new SOlution4();
//echo $obj4->numsNode($root);
/**
 * https://leetcode.cn/problems/er-cha-shu-de-jing-xiang-lcof/
 * 镜像
 */
class Solution5 {

    /**
     * @param TreeNode $root
     * @return TreeNode
     */
    function mirrorTree($root) {  // 判断是否对称
        if ($root == null) return null;
        $tmp = $root->left;
        $root->left = $root->right;
        $root->right = $tmp;

        $this->mirrorTree($root->left);
        $this->mirrorTree($root->right);
        return $root;
    }

}

/**
 * JZ78 把二叉树打印成多行
 * 层级遍历 而且是多行；】
 * 输入：
{1,2,3,#,#,4,5}
复制
返回值：
[[1],[2,3],[4,5]]
 */
class Solution6
{
    function PrintBinaryTreeToMulLine( $root )
    {
        // write code here
        $queue =  [];
        array_push($queue,$root);
        $res = [];

        while (!empty($queue)) {
            $n = count($queue);
            for ($i = 0; $i < $n; $i++) {
                $tmp = array_shift($queue);
                $ret[] = $tmp;

                if (isset($tmp->left)) array_push($queue,$tmp->left);
                if (isset($tmp->right)) array_push($queue,$tmp->right);
            }
            $res[] =  $ret;
        }
        return $res;
    }
}
$obj6 = new Solution6();
var_dump($obj6->PrintBinaryTreeToMulLine($root));die;

