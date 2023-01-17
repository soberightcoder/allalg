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

        if ((++$this->count) == $k) {
            $this->ans = $root->val;
            return;
        }

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

