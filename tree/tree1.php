<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/24
 * Time 14:30
 */


/**
 * leetcode 路径和
 */
class Solution13 {

    /**
     * @param TreeNode $root
     * @param Integer $targetSum
     * @return Boolean
     */
    function hasPathSum($root, $targetSum) {

    }
}

$obj13 = new Solution13();

/**
 * 剑指 Offer 34. 二叉树中和为某一值的路径
 *路径和的问题；
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
        $sum = 0;
        $path = [];
        $this->help($root,$target,$sum,$path);
        return $this->res;
    }
    // 利用内部参数的可变性来做一个回溯；回溯--回溯--回溯；
    //必须要传递参数 才能进行回溯，因为要进行回退嘛；
    protected function help($root,$target,$sum,$path) {
        if ($root == null) {
            // 如果左右结点都是null 那么就会存在输入两次的问题；
            if ($target == $sum) {
                if (!empty($path)) {
                    $this->res[] = $path;
                }
            }
            return;// 返回上一级函数
        }
        // 返回上一级函数就会改变
        $sum += $root->val;
        $path[] = $root->val;

        //结点；
        if (!isset($root->left) && !isset($root->right)) {
            //去运行一个就行了 两个都是null；
            $this->help($root->left,$target,$sum,$path);
        }  else {
            $this->help($root->left,$target,$sum,$path);
            $this->help($root->right,$target,$sum,$path);
        }
    }
}
$root12  = new TreeNode(1);
$root->left = new TreeNode(2);
$obj12 = new Solution12();
var_dump($obj12->pathSum($root12,1));die;