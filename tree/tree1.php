<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/24
 * Time 14:30
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
/**
 * leetcode 路径和
 * //注意空指针；
 * 到叶子结点结束；
 */
class Solution13 {

    /**
     * @param TreeNode $root
     * @param Integer $targetSum
     * @return Boolean
     */
    function hasPathSum($root, $targetSum) {
        // 从0开始还是从$root->val 开始？
        if ($root == null) return false;
        return $this->traverse($root,$targetSum,$root->val);
    }
    // 想用sum 求和把
    function traverse($root,$targetSum,$sum) {
        // 叶子结点的定义 左右结点都是null；
        if ($root->left == null && $root->right == null) {
            if ($sum == $targetSum) {
                return true;
            } else {
                return false;
            }
        }
        // 回溯；sum 要做回溯的；需要靠递归的参数来进行回溯
        // $sum += $root->val;  // 如果直接写  我们需要做回溯 我们可以直接传入参数；这个函数定义域内 sum的值发生变化;所以这里肯定是有问题的；
        // 存在就直接返回；return；
        if ($root->left) { // 注意空指针的运算；
            if ($this->traverse($root->left,$targetSum,$sum + $root->left->val)) return true;
        }
        if ($root->right) { //必须 要存在 不然会出现空指针的问题；
            if ($this->traverse($root->right,$targetSum,$sum + $root->right->val)) return true;
        }

        return false; //找不到路径 return false;
    }
}

//$root13  = new TreeNode(1);
//$root13->left = new TreeNode(2);
//$obj13 = new Solution13();
//var_dump($obj13->hasPathSum($root13,1));die;


/**
 * 剑指 Offer 34. 二叉树中和为某一值的路径
 *路径和的问题
 */
class Solution12 {

    /**
     * @param TreeNode $root
     * @param Integer $target
     * @return Integer[][]
     */
    public $res = [];

    function pathSum($root, $target) {
        if ($root == null) return [];
        $sum = $root->val;  // 如果只有一个结点 会导致叶子结点还没有插入进去  如果没有整个设置；// 极限情况的话 直接看一个结点就行了

        $path = [$root->val];
        $this->help($root,$target,$sum,$path);
        return $this->res;
    }

    // 利用内部参数的可变性来做一个回溯；回溯--回溯--回溯；
    //必须要传递参数 才能进行回溯，因为要进行回退嘛；
    protected function help($root,$target,$sum,$path) {
        //叶子结点
        if ($root->left == null && $root->right == null) {
            if ($sum == $target) {  // 0 null 问题
                $this->res[] = $path;
            }
            return;
        }


        if ($root->left) {
            array_push($path,$root->left->val);
            $this->help($root->left,$target,$sum + $root->left->val,$path);
            array_pop($path);
        }

        if ($root->right) {
            array_push($path,$root->right->val);
            $this->help($root->right,$target,$sum + $root->right->val,$path);
            array_pop($path);
        }

    }

}
//$root12  = new TreeNode(1);
//$root12->left = new TreeNode(2);
//$obj12 = new Solution12();
//var_dump($obj12->pathSum($root12,1));die;

/**
 * 二叉树所有的路径
 */

class Solution14 {

    /**
     * @param TreeNode $root
     * @return String[]
     */
    public $res = [];  //

    function binaryTreePaths($root) {
        // 为什么要提前加  可以想象一下只有一个元素的问题； 那么 会直接导致 路径里面没有任何数据；
        $str = ''.$root->val;
        $this->help($root,$str);
        return $this->res;
    }

    protected function help($root,$str) {
        //end recursion condition
        if ($root->left == null && $root->right == null) {
//            $str .= '->'.$root->val;// ??这里不需要再去加了// 好好看一下这里 不需要加；
            $this->res[] = $str;  //怎么回溯？？？// 外部变量不需要回溯；
            return;
        }
        //存在问题 当有两
        // 回溯
        if ($root->left) {
            //
            $this->help($root->left,$str."->".$root->left->val);
        }

        if ($root->right) {
            $this->help($root->right,$str."->".$root->right->val);
        }
    }
}


$root14 = new TreeNode(1);
$node2 = $root14->left = new TreeNode(2);
$node3 = $root14->right = new TreeNode(3);
$node2->right = new TreeNode(5);

$obj14 = new Solution14();
var_dump($obj14->binaryTreePaths($root14));die;
