<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/25
 * Time 22:17
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

/**
 *  236. 二叉树的最近公共祖先
 */
class Solution1
{
    public function lowestCommonAncestorlk($root,$p,$q) {

    }
}

/**
 * 235. 二叉搜索树的最近公共祖先 二叉搜索树(BST)的 最近公共祖先
 * 条件 :
 * 1.结点的值都是唯一的；
 * 2. p、q 为不同节点且均存在于给定的二叉树中。
 * 一定要利用 bst的特性来进行求解
 * $q $p 结点不存在的分支不需要去遍历
 */

class Solution2
{
    public $res; // 第二种求解方法用到了res;

    //  找到往后回退可以看看有没有遇到相同的结点
    public function lowestCommonAncestor($root,$p,$q) {
        // end condition
        // 分离的 就能找结点
//        if (($q <= $root->val && $p >= $root->val) || ($q >= $root->val && $p <= $root->val)) {
//            $this->res = $root->val;
//            return $this->res;
//        }
        //  q p 都在右子树 往右边去找;
        if ($p > $root->val && $q > $root->val) {
            if ($right = $this->lowestCommonAncestor($root->right,$p,$q)) {
                return $right;// 有就给返回就好了
            }
        }
        //
        // p q 都在左子树 往左子树去找；
        if ($p < $root->val && $q < $root->val) {
            if ($left = $this->lowestCommonAncestor($root->left,$p,$q)) {
                return  $left;
            }
        }
        //q  p 分别在不同左右子树;
//        $this->res = $root;// 这里回退的时候会被覆盖；所以 //这个方法 会被回退的root覆盖；
        return $root;
    }

    function lowestCommonAncestor1($root, $p, $q) {
        $rootval = $root->val;
        $qval = $q->val;
        $pval = $p->val;

        //只有满足这个条件的时候才会接收递归；
        if (($qval <= $root->val && $pval >= $root->val) || ($qval >= $root->val && $pval <= $root->val)) {
            $this->res = $root;
            return $this->res;
        }

        if ($pval < $rootval && $qval < $rootval) {
            //
            $this->lowestCommonAncestor($root->left,$p,$q);
        }

        if ($pval > $rootval && $qval > $rootval) {
            //
            $this->lowestCommonAncestor($root->right,$p,$q);

        }
        //最后一层获取数据就可以了；
        return $this->res;
    }
    protected function findNode($root,$node) {
        if ($root == null) return null;

        //  等于整个的值  怎么做回溯？
        if ($root->val == $node->val) {
            return $root;
        }else if ($root->val > $node->val) {
            $this->findNode($root->left,$node);
        } else {
            $this->findNode($root->right,$node);
        }

    }
}

$obj2 = new Solution2();
//  $c === 16  $d === 9;
var_dump($obj2->lowestCommonAncestor($root,$c->val,$f->val));die;


/**
 *
 */
