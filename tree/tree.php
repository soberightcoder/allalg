<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:17
 */

// 嵌套循环设置为 - 1； 无限嵌套循环；
ini_set('xdebug.max_nesting_level', -1);
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
 *  是否对称吗？？
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
 * 任意一个结点的左右子树的高度相差不要超过1；
 *
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
//$obj6 = new Solution6();
//var_dump($obj6->PrintBinaryTreeToMulLine($root));die;

/**
 * 寻找第k小的元素
 * 230. 二叉搜索树中第K小的元素
 * // 会遍历右子树吗？？？？
 */

class Solution7 {

    /**
     * @param TreeNode $root
     * @param Integer $k
     * @return Integer
     */
    public $ans = 0;
    public $count = 0;

    function kthSmallest($root, $k) { // 第k个最小元素；
        $this->help($root,$k);
        return $this->ans;
    }

    function help($root,$k) {
        if ($root == null) return null;

        $this->help($root->left,$k);

        // 中序遍历 只能靠 全局变量来返回数据吗？？？？
        if ($k == (++$this->count)) {
            $this->ans = $root->val;
            return;// 在这里是直接终止；
        }

        $this->help($root->right,$k); // 遍历右子树之后的终止；
    }
}

/**
 * 538. 把二叉搜索树转换为累加树
 * 累加树
 */

class Solution8 {

    /**
     * @param TreeNode $root
     * @return TreeNode
     */
    // 遍历一遍加上就可以了； 加上字段size；
    public $sum = 0;
    // 注意对象传递句柄的概念
    function convertBST($root) {
        if ($root == null) return null;
        $this->convertBST($root->right);
        $this->sum += $root->val;
        $root->val = $this->sum;
        $this->convertBST($root->left);
        // $this->traverse($root); //引用； // 第二钟方案，直接用一个函数来返回；保存一下$root;就是一开始的root；
        // 这里一层层的传递回来还不如第二重方案；
        return $root;// 虽然回传了数据但是没有 函数去接收 ，所以相当于只返回了第一层的数据；// 所以种类还可以return；自己理解一下；
    }

    // public function traverse($root) {
    //     if ($root == null) return null;
    //     $this->convertBST($root->right);
    //     $this->sum += $root->val;
    //     $root->val = $this->sum;
    //     $this->convertBST($root->left);
    // }

}

/**
 * 二叉树的中序遍历
 * 返回的是一个数组； // 遍历的数组；
 */
class Solution9 {

    /**
     * @param TreeNode $root
     * @return Integer[]
     */
    public $res = [];

    function inorderTraversal($root) {
        $this->help($root);
        return $this->res;
    }

    public function help($root) {
        if ($root == null) return null;
        $this->inorderTraversal($root->left);
        $this->res[] = $root->val;
        $this->inorderTraversal($root->right);
    }
}
/**
 * 二叉树的重建
 * 知道前序和 中序 然后去重建二叉树
 * 剑指 Offer 07. 重建二叉树
 */
class Solution10 {

    /**
     * @param Integer[] $preorder
     * @param Integer[] $inorder
     * @return TreeNode
     */

    // 前序遍历// 结点值并不重复；
    function buildTree($preorder, $inorder) {
        if (empty($preorder)) return null;
        $rootval = $preorder[0];  // root 根结点
        $root = new TreeNode($rootval);
        //只有一个结点
        if (count($preorder) == 1) return $root;  // 这里的结点的左孩子或者有孩子 回去接住他；
        // inorder index  == roo tval 的索引
        $n = count($inorder);
        for ($index = 0; $index < $n; $index++) {
            if ($inorder[$index] == $rootval) {
                break;
            }
        }
        //切中序 分为两部分  左中序  和  右中序；
        $inleft = array_slice($inorder,0,$index);
        $inright = array_slice($inorder,$index + 1);

        // 切前序 分为 左前序  和 右前序 两部分；
        $len = count($inright);
        //array_slilce 有问题；
        // $len == 0 的时候会出问题；
        //  0的情况会有问题； 卧槽；妈的
        if ($len == 0) {
            $preright = array();
            $preleft = array_slice($preorder,1);
        } else {
            $preright = array_slice($preorder,(-$len));
            $preleft = array_slice($preorder,1,(-$len));
        }


        //递归； 递归左右结点；
        //递归； 递归左右结点；
        $root->left = $this->buildTree($preleft,$inleft);

        $root->right = $this->buildTree($preright,$inright);

        return $root;
    }
}
$preorder1 = [1,2];
$inorder1 = [2,1];

//$obj10 = new Solution10();
//var_dump($obj10->buildTree($preorder1,$inorder1));die;


/**
 * 重建二叉树
 * 通过 中序和后序来重建二叉树
 */
// 对上面的优化 对长度做一个匹配
class Solution101 {

    /**
     * @param Integer[] $preorder
     * @param Integer[] $inorder
     * @return TreeNode
     */

    // 前序遍历// 结点值并不重复；
    function buildTree($preorder, $inorder) {
        if (empty($preorder)) return null;
        $rootval = $preorder[0];  // root 根结点
        $root = new TreeNode($rootval);
        //只有一个结点
        if (count($preorder) == 1) return $root;  // 这里的结点的左孩子或者有孩子 回去接住他；
        // inorder index  == roo tval 的索引
        $n = count($inorder);
        for ($index = 0; $index < $n; $index++) {
            if ($inorder[$index] == $rootval) {
                break;
            }
        }
        //切中序 分为两部分  左中序  和  右中序；
        $inleft = array_slice($inorder,0,$index); // 用长度来左匹配；
        $inright = array_slice($inorder,$index + 1); //

        // 切前序 分为 左前序  和 右前序 两部分；
        $lenleft = count($inleft);
        $lenright = count($inright);
        //array_slilce 有问题；
        // $len == 0 的时候会出问题；
        //  0的情况会有问题； 卧槽；妈的

        $preleft = array_slice($preorder,1,$lenleft);
        $preright = array_slice($preorder,1 + $lenleft);


        //递归； 递归左右结点；
        //递归； 递归左右结点；
        $root->left = $this->buildTree($preleft,$inleft);

        $root->right = $this->buildTree($preright,$inright);

        return $root;
    }
}
$preorder101 = [1,2];
$inorder101 = [2,1];

//$obj101 = new Solution101();
//var_dump($obj101->buildTree($preorder101,$inorder101));die;
/**
 * 654-leetcode --- 最大二叉树
 *
 */
class Solution11
{

    /**
     * @param Integer[] $nums
     * @return TreeNode
     */

    function constructMaximumBinaryTree($nums) {
        // 结束条件
        return  $this->help($nums,0,count($nums) - 1);

//        if (empty($nums)) return null;
//        //找最大值  分区； // 分为左边和右边分区
//        $partition = $this->partition($nums);
//
//        $head = new TreeNode($nums[$partition[0]]);
//
//        $head->left = $this->constructMaximumBinaryTree($partition[1]);
//        $head->right = $this->constructMaximumBinaryTree($partition[2]);
//
//        return $head;

    }

    //找到最大值； 最大值的key 找到最大值的key；这是分区的最关键部分；
    public function partition($nums) {
        $key = -1; // 这里不能设置为null
        $maxval = PHP_INT_MIN; // z这里不能设置为null 这个也是以前错误的原因

        foreach ($nums as $k=>$v) {
            if ($maxval < $v) {  // 大于
                $key = $k;
                $maxval = $v;
            }
        }

        $left = array_slice($nums,0,$key);//这里就使用 函数了 所以不太对；有问题；要全部用自己的代码去实现；
        // 省略 就是到字符串的末尾
        $right = array_slice($nums,$key + 1);

        return [$key,$left,$right];
    }

    public function help($nums,$left,$right) {
        if ($right < $left) return null;
       $key =  $this->getMax($nums,$left,$right);//应该是这个分段的最大值；

       $head = new TreeNode($nums[$key]);
       $head->left = $this->help($nums,$left,$key - 1);
       $head->right = $this->help($nums,$key + 1,$right);
       // 左右子树的结点
       return $head;
    }

    public function getMax($nums,$left,$right) {
        $key = -1;
        $maxval = PHP_INT_MIN;

        for ($i = $left; $i <= $right;$i++) {
            if ($maxval < $nums[$i]) {
                $key = $i;
                $maxval = $nums[$i];
            }
        }
//        foreach ($nums as $k=>$v) {
//            if ($maxval < $v) {  // 大于
//                $key = $k;
//                $maxval = $v;
//            }
//        }
        return $key;
    }
}

//$arr11 = [3,2,1,6,0,5];
//$obj11 = new Solution11();
//var_dump($obj11->constructMaximumBinaryTree($arr11));die;


