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


//$root14 = new TreeNode(1);
//$node2 = $root14->left = new TreeNode(2);
//$node3 = $root14->right = new TreeNode(3);
//$node2->right = new TreeNode(5);

//$obj14 = new Solution14();
//var_dump($obj14->binaryTreePaths($root14));die;


/**
 * 二叉树的序列化和反序列化
 * 剑指 Offer II 048. 序列化与反序列化二叉树
 * 最后一定要解决 鲁棒性;就是一些特殊情况；一定要考虑到；
 */

/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($value) { $this->val = $value; }
 * }
 */


class Codec {

    const SEP = ",";
    const NULL = "#";

    function __construct() {

    }

    /**
     * @param TreeNode $root
     * @return String
     *  仅仅有一个遍历是不能复原的；
     * 但是 包含中序和后序 遍历会变得很长  带宽会变长，所以要重新组织新的序列化；
     * 重建二叉树 要求不能有重复的数字；
     * // 假如我先用  前序遍历的方法；
     * // 注意 因为是二叉树的序列化，所以 我们这里一定要 保留 #
     */

    public $arr = [];

    function serialize1($root) {
        $this->enseriable1($root);
        //  数组转换成字符串； // 用，来隔开；
        return implode($this->arr,self::SEP);
    }

    protected function enseriable1($root) {
        if ($root == null) {
            array_push($this->arr,"#");
            return;
        }

       array_push($this->arr,$root->val);
       $this->enseriable1($root->left);
       $this->enseriable1($root->right);
    }

    // 第二种解决方案
    function serialize($root) {
        $arr = [];
        //传引用 其实可以使用全局变量；$arr;
        $this->enseriable($root,$arr);
        //
        return implode($arr,',');//  数组 转换成字符串
    }
    // 这里传递的是引用才会 当一个全局变量来使用；相当于  当然你也可以使用全局变量
    protected function enseriable($root,&$arr) {
        if ($root == null) {
            array_push($arr,self::NULL);  // # == null  不然 null没法转换成字符串；
            return;
        }
        array_push($arr,$root->val);
        $this->enseriable($root->left,$arr);
        $this->enseriable($root->right,$arr);
    }

    /**
     * @param String $data
     * @return TreeNode
     */
    function deserialize($data) {
        $data = explode(",",$data);
//        var_dump($data);die;
        //root
        return $this->deseriable($data);
    }

    protected function deseriable(&$data) {// 这里必须要用引用；
        if (empty($data)) return null;  // noedes 结束
        // 前序遍历的反序列化
        $rootval = array_shift($data);

        if ($rootval == self::NULL) {
            // 树的结点 结束了
            return null;
        }

        $root = new TreeNode($rootval);

        //为null 也要去做遍历
        $root->left = $this->deseriable($data);
        $root->right = $this->deseriable($data);

        return $root;
    }
}


//  $ser = new Codec();
//  $deser = new Codec();
//$data = $ser->serialize($root);// 引用
//$data1 = $ser->serialize1($root); //全局变量
//var_dump($data);
//  var_dump($data1);die;
//  die;
//  $ans = $deser->deserialize($data);
//  inorderBinary($root);
// inorderBinary($ans);
//  var_dump($ans);die;
//print_r($ans);

class Codec1
{

    const SEP = ",";
    const NULL = "#";

    public $res = [];

    function __construct() {

    }

    /**
     * @param TreeNode $root
     * @return String
     * 前序 转换成字符串json  序列化
     */

    function serialize($root) {
        // if ($root == null) return []; // 整体为null；
        $this->help1($root);

        return implode(self::SEP, $this->res);
    }

    function help1($root) {
        if ($root == null) {
            array_push($this->res, self::NULL);
            return;
        }

        array_push($this->res, $root->val);

        $this->help1($root->left);
        $this->help1($root->right);
    }

    /**
     * @param String $data
     * @return TreeNode
     * 前序的反序列化
     */
    function deserialize($data) {
        $data = explode(self::SEP, $data);//arr
//        var_dump($data);die;
        return $this->help($data);
    }

    function help(&$data) {

        //endx
        if (empty($data)) return null;
        //
        $rootval = array_shift($data);
        if ($rootval == self::NULL) {
            return null;
        }

        $root = new TreeNode($rootval);

        $root->left = $this->help($data);
        $root->right =
            $this->help($data);

        return $root;
    }
}
$cesgu  =  new  Codec1();
$str =  $cesgu->serialize($root);
var_dump($cesgu->deserialize($str));die;
