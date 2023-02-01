<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/28
 * Time 21:26
 */
/**
 * 主要是几个回溯算法
 * 排列 组合 子集 和 切割的算法
 * 注意去 做剪树枝 处理
 */
/**
 * Class TreeNode
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
 * inorder 中序
 */
function inorderBinary($root) {
    if ($root == null) return null;
    inorderBinary($root->left);
    echo $root->val."---";
    inorderBinary($root->right);
}


