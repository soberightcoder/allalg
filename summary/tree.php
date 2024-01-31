<?php

/**
 * 每次写算法 都需要注意边界条件；起码为NULL的时候要自己测试一下；
 * */
/**
 * 这里的tree 主要是二叉树；
 * $tree 树的根结点；
 * 一个结点 会被经过三次，什么时候输出那么可以分为前序遍历中序遍历和后序遍历
 */
class TreeNode
{
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($value)
    {
        $this->val = $value;
    }
}

//             13
//        10         16
//    9      11   14

$root = new TreeNode(13);
$b = new TreeNode(10);
$c = new TreeNode(16);
$d = new TreeNode(9);
$e = new TreeNode(11);
$f = new TreeNode(14);
// root == $a;
$root->left = $b;
$b->left = $d;
$b->right = $e;
$root->right = $c;
$c->left = $f;

/**
 * 二叉树的理论基础；
 */

/**
 * 二叉树的种类： 二叉树 
 * 二叉搜索树（bst 右子树的值大于父节点，左子树小于父节点；）  
 * 完全二叉树(堆 优先队列) 满二叉树(2^k-1)  k是层级；满二叉树 首先是一个完全二叉树 + 就是一直往遍历和一直往右遍历的深度是相等的，就是满二叉树；
 * 平衡二叉搜索树（解决树变形问题,左子树和右子树的高度绝对值不G能超过1）map 和set （插入数据和查询数据都是logn）里面的数据肯定是有序的，因为是平衡搜索二叉树；
 * 红黑树；（左子树和右子树高度相差不超过一倍）
 * 深度：从根结点开始，往下。 都是 从0开始的；
 *  高度：到叶子结束，“往上”。
 * 根节点的深度 是0； 叶子节点的高度是0；
 *  层级 就是父节点就是 1  一直往下 每次加1；
 *  */


/**
 *存储方式 --- 数组 + 链表；
 * 完全二叉树  一般会用数组来做存储 ，例如堆； 优先队列 SplPriorityQueue
 *  数组   父节点 i  左子节点 2*i   右子节点 2*i + 1 ; 已经知道i ，父节点就是 (i/2 - 1)
 *  */


/**
 * 遍历方式 --- 深度 和  广度
 * 深度 --- 前中后，都是深度优先遍历；非递归实现前中后 --- 用栈来模拟；
 * 广度 --- 层级遍历； --- 用队列来实现；
 *  */


/**
 * 二叉树的递归遍历 ---leetcode  --- 144 145 94 
 *  */

function traverseByRecursion($root)
{
    //返回什么值 都是可以的，因为没有人去接收；
    if ($root == NULL) return;
    //前序遍历
    traverseByRecursion($root->left);
    //中序遍历 
    //有序性
    echo $root->val . "->";
    traverseByRecursion($root->right);
    //后序遍历
}
// traverseByRecursion($root);

/**
 * 非递归 二叉树的遍历
 * 输出 就是出栈操作；
 *  */
class Solution
{
    public $nums = [];
    // 中左右；
    function traverseByNoRecursion($root)
    {
        // 前序非递归的形式；
        // 维护一个栈；
        $stack = [];
        array_push($stack, $root);
        while (!empty($stack)) {
            $node = array_pop($stack);
            $this->nums[] = $node->val;
            //先右边 再左边；
            if (isset($node->right)) {
                array_push($stack, $node->right);
            }
            if (isset($node->left)) {
                array_push($stack, $node->left);
            }
        }
        return $this->nums;
    }
    // 后序遍历 可以通过 前序遍历变换过来；
    //前序 ==  中 左右==> 中右左 ==> 左右中；  只需要反转一下就可以了；
    public function houxu($root)
    {
        // 前序非递归的形式；
        // 维护一个栈；
        $stack = [];
        array_push($stack, $root);
        while (!empty($stack)) {
            $node = array_pop($stack);
            $this->nums[] = $node->val;
            //先右边 再左边；
            if (isset($node->left)) {
                array_push($stack, $node->left);
            }

            if (isset($node->right)) {
                array_push($stack, $node->right);
            }
        }
        // 原地反转就就可以了；
        $i = 0;
        $j = count($this->nums) - 1;
        while ($j > $i) {
            $tmp = $this->nums[$i];
            $this->nums[$i] = $this->nums[$j];
            $this->nums[$j] = $tmp;
            $j--;
            $i++;
        }
        return $this->nums;
    }
}


/**
 * 非递归 中序遍历
 * 这里使用 二叉树的递归序来做的；
 */
class Solution2
{
    public $stack = [];
    // 前序遍历的数组；
    public $pre = [];
    //中序遍历数组；
    public $res = [];

    function pushLeftBranch($p)
    {
        while (!empty($p)) {
            $this->stack[] = $p;
            //前序遍历
            $this->pre[] = $p->val;
            $p = $p->left;
        }
    }

    function zhongxu($root)
    {
        $this->pushLeftBranch($root);
        while (!empty($this->stack)) {
            $node = array_pop($this->stack);
            $this->res[] = $node->val;
            $this->pushLeftBranch($node->right);
        }
    }
}
// $obj2 = new Solution2();
// var_dump($obj2->zhongxu($root)); //输出是有序的；
// var_dump($obj2->res);
// var_dump($obj2->pre);


/**
 * 层级遍历
 * leetcode --- 102. 二叉树的层序遍历
 * 时间复杂度O(n)
 */

function levelOrder($root)
{
    // array_push  array_shift();
    if ($root == NULL) return [];
    $queue = [];
    $res = [];
    $queue[] = $root;
    while (!empty($queue)) {
        // 队列的内容全部遍历出来
        $tmp = [];
        $n = count($queue);
        //注意下面不能用count queue会慢慢的扩大；
        for ($i = 0; $i < $n; $i++) {
            $node = array_shift($queue);
            $tmp[] = $node->val;
            if (isset($node->left)) array_push($queue, $node->left);
            if (isset($node->right)) array_push($queue, $node->right);
        }
        $res[] = $tmp;
    }
    return $res;
}
// var_dump(levelOrder($root));

/**
 * 判断树是否对称；
 * leetcode -- LCR 145. 判断对称二叉树
 * 错误的思想，判断左右节点是否相等不行呀；
 *  */

/**
 * 两个指针去遍历左右节点全判断是否相等；
 */
class Solution4
{

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function checkSymmetricTree($root)
    {
        return $this->check($root, $root);
    }

    function check($p, $q)
    {
        //必须两个都存在；两个都是NULL；
        if (!$p && !$q) return true;
        //有一个不为NULL
        if (!$p || !$q) return false;
        //用双指针去比较就可以了；其实这边就是后序遍历
        return ($q->val == $p->val && $this->check($p->left, $q->right) && $this->check($q->left, $p->right));
    }
}

/**
 * 翻转二叉树；
 * leetcode --- LCR 144. 翻转二叉树
 * 就是一个前序 递归；
 *  */

function mirrorTree($root)
{
    if ($root == NULL) return NULL;
    $mid = $root->left;
    $root->left = $root->right;
    $root->right = $mid;
    mirrorTree($root->left);
    mirrorTree($root->right);
    return $root;
}

/**
 * 树的最大深度；
 * 后序遍历；从下往上进行计数；
 * 后序遍历都是从下往下计数；
 * 
 *  */

//时间复杂度是O(n) 空间复杂度是树的高度 === O(logn)
function maxDepth($root)
{
    if ($root == NULL) return 0;
    //n与n-1的关系；
    // return max(maxDepth($root->left), maxDepth($root->right)) + 1;
    $left = maxDepth($root->left);
    $right = maxDepth($root->right);
    // 左右节点都返回为0才会进行归的过程；
    return max($left, $right) + 1;
}

// echo maxDepth($root);


/**
 * 树的最小深度；
 * 111. 二叉树的最小深度
 * 最小深度是从根节点到最近叶子节点的最短路径上的节点数量。
 * 说明：叶子节点是指没有子节点的节点。
 * 注意   
 *   12
 *      13 
 *    10   14    他的最小深度是3；  不是1，
 *  */

function minDepth($root)
{
    //左右节点都等于0 才会去计算；
    if ($root == NULL) return 0;
    $left = minDepth($root->left);
    $right = minDepth($root->right);
    // 会存在一个节点为NULL 一个节点不为NULL的情况；    
    if ($root->left == NULL && $root->right != NULL) {
        return $right + 1;
    }

    if ($root->left != NULL && $root->right == NULL) {
        return $left + 1;
    }
    // 左右子树都不为NULL
    return min($left, $right) + 1;
}

/**
 * 222. 完全二叉树的节点个数
 * 使用完全二叉树的特性，来计算节点的数目；
 *  */
/**
 *普通的二叉树节点数目的统计； 
 *  */

function nodeNum($root)
{
    //后序遍历
    if ($root == NULL) return 0;
    $left = nodeNum($root->left);
    $right = nodeNum($root->right);
    return $left + $right + 1;
}


class Solution222
{

    /**
     * @param TreeNode $root
     * @return Integer
     */
    //普通二叉树的前序遍历进行节点的统计；
    public $count = 0;
    function countNodes1($root)
    {
        $this->traverse($root);
        return $this->count;
    }
    function traverse($root)
    {
        if ($root == NULL) return;
        $this->count++;
        $this->traverse($root->left);
        $this->traverse($root->right);
    }
    // 完全二叉树的节点的统计；
    /**
     * 也是后序遍历，但是通过去改变递归的结束条件来实现了这个计算；
     */
    function  countNodes($root)
    {
        if ($root == NULL) return 0;
        $left = $root->left;
        $right = $root->right;
        $leftNum = 0;
        $rightNum = 0;

        while ($left) { //这里是到叶子节点才会停止；
            $left = $left->left;
            $leftNum++;
        }

        while ($right) {
            $right = $right->right;
            $rightNum++;
        }

        if ($leftNum == $rightNum) {
            // 2^1 = 2 
            return (2  << $rightNum) - 1;
        }
        $leftCount = $this->countNodes($root->left);
        $rightCount = $this->countNodes($root->right);
        return $leftCount + $rightCount + 1;
    }
}
// $obj222 = new Solution222();
// echo $obj222->countNodes1($root);
// echo $obj222->countNodes($root);

/**
 * leetcode --  110 平衡二叉树；
 *  */
class Solution110
{

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isBalanced($root)
    {
        $res = $this->getHeight($root);
        if ($res < 0) {
            return false;
        }
        return true;
    }
    //对结果一级一级的做传递； 当不对称的时候 上面就不需要做比对了；比较牛皮呀；
    // 而且本层会接收上一层的结果，当上一层是-1的时候就不需要判断了直接传递给下一层就可以了；
    function getHeight($root)
    {
        if ($root == NULl) return 0;
        $left = $this->getHeight($root->left);
        if ($left === -1) return -1;
        $right = $this->getHeight($root->right);
        if ($right === -1) return -1;

        if (abs($left - $right) > 1) {
            return -1;
        } else {
            return max($left, $right) + 1;
        }
    }
}

/**
 * leetcode ---  404 左叶子节点之和；
 *  */

class Solution404
{

    /**
     * @param TreeNode $root
     * @return Integer
     */
    public $sum = 0;
    function sumOfLeftLeaves($root)
    {
        // 是否是左叶子还是右叶子 是由上一级 来判定的，你必须传递参数的时候给一定判定；
        if ($root->left == NULL && $root->right == NULL) return 0;

        //左叶子节点有 或者右边叶子节点有
        $this->traverse($root, 0);
        return $this->sum;
    }

    function traverse($root, $flag)
    {
        // 是否是左叶子还是右叶子 是由上一级 来判定的，你必须传递参数的时候给一定判定；
        if ($root == NULL) return;

        if ($flag == 1 && $root->left == NULL && $root->right == NULL) {
            $this->sum += $root->val;
        }
        //左叶子节点有 或者右边叶子节点有
        $this->traverse($root->left, 1);
        $this->traverse($root->right, 0);
    }
}
// $obj404 = new Solution404();
// echo $obj404->sumOfLeftLeaves($root);

/**
 * 513  --- 给定一个二叉树的 根节点 root，请找出该二叉树的 最底层 最左边 节点的值。
 * 层级遍历就可以了，取最后一层的第一个元素；
 *  */
function findBottomLeftValue($root)
{
    //层级遍历
    //定义一个队列；
    //层级遍历
    //定义一个队列；
    // 占用的内存也很少； 
    $queue = [];
    array_push($queue, $root);
    while (!empty($queue)) {
        $tmp = NULL;
        $n = count($queue);
        for ($i = 0; $i < $n; $i++) {
            $node = array_shift($queue);
            if ($i == 0) {
                $tmp = $node->val;
            }
            if ($node->left) array_push($queue, $node->left);
            if ($node->right) array_push($queue, $node->right);
        }
    }
    return $tmp;
}

/**
 * 106. 从中序与后序遍历序列构造二叉树
 * 中序是： 左中右  左右中；
 * 找中节点 看后序；最后一个数值；
 * 前序和中序  中序和后序 都可以唯一的确定一棵树； 但是 前序和后序并不能唯一的确定一棵树；
 * 中序很重要，在中间把左右子树给划分开了；所以为了确定唯一一棵树，中序很重要；
 *  */
class Solution106
{

    /**
     * @param Integer[] $inorder
     * @param Integer[] $postorder
     * @return TreeNode
     */
    function buildTree($inorder, $postorder)
    {
        //结束条件
        if (count($postorder) == 0) return NULL;
        // 找到中点
        $rootval = $postorder[count($postorder) - 1];
        $root = new TreeNode($rootval);
        if (count($postorder) == 1) return $root;
        //切割中序遍历
        // $i = 0;
        // for (;$i < count($inorder); $i++) {
        //     if ($inorder[$i] == $rootval) {
        //         break;
        //     }
        // }
        $i = array_search($rootval, $inorder);
        // 使用的是左闭区间，右闭区间；
        // 左中序[0 i -1]  [i+1,count($postorder) - 1]右中序；
        $leftinorder = array_slice($inorder, 0, $i);
        $rightinorder = array_slice($inorder, $i + 1);
        //切割后序遍历  根据中序的长度来左切割；
        //左后序   右后序；
        $leftpostorder = array_slice($postorder, 0, $i);
        // 因为从0开始计数；
        $rightpostorder = array_slice($postorder, $i, -1);
        $root->left = $this->buildTree($leftinorder, $leftpostorder);
        $root->right = $this->buildTree($rightinorder, $rightpostorder);
        return $root;
    }
}

/**
 * 889. 根据前序和后序遍历构造二叉树
 *  前序和后序并不能唯一的确定一棵树；
 * 前序遍历为：

 * (根结点) (前序遍历左分支) (前序遍历右分支)
 * (后序遍历左分支) (后序遍历右分支) (根结点)
 *  if (post[i] == pre[1]) //通过这种方式来找到中点；
 *             L = i+1;
 */
class Solution889
{

    /**
     * @param Integer[] $preorder
     * @param Integer[] $postorder
     * @return TreeNode
     */
    function constructFromPrePost($preorder, $postorder)
    {
        $pre = count($preorder);
        if ($pre == 0) return NULL;
        $root = new TreeNode($preorder[0]);
        $i = array_search($preorder[1], $postorder);
        //array_slice  左闭右开 ，
        $root->left = $this->constructFromPrePost(array_slice($preorder, 1, $i + 1), array_slice($postorder, 0, $i + 1));
        $root->right = $this->constructFromPrePost(array_slice($preorder, $i + 2), array_slice($postorder, $i + 1, -1));

        return $root;
    }
}

/**
 * 654. 最大二叉树
 * 以后优化把，目前时间复杂度是O(n^2)
 * 构造二叉树 一定要用前序；
 * 时间复杂度很高，是因为我们需要构建一个新的数组，所以时间复杂度很高；
 *array_slice的时间复杂度是O(n)
 */

class Solution654
{

    /**
     * @param Integer[] $nums
     * @return TreeNode
     */
    function constructMaximumBinaryTree($nums)
    {
        // 创建最大二叉树；
        //找到最大值的索引；
        if (empty($nums)) return NULL;
        $maxIndex = $this->maxIndex($nums);
        $root = new TreeNode($nums[$maxIndex]);
        if (count($nums) == 1) return $root;

        $root->left = $this->constructMaximumBinaryTree(array_slice($nums, 0, $maxIndex));
        $root->right = $this->constructMaximumBinaryTree(array_slice($nums, $maxIndex + 1));
        return $root;
    }

    function maxIndex($nums)
    {
        $maxI = 0;
        for ($i = 0; $i < count($nums); $i++) {
            if ($nums[$maxI] < $nums[$i]) {
                $maxI = $i;
            }
        }
        return $maxI;
    }
}
// $obj654 = new Solution654();
// var_dump($obj654->constructMaximumBinaryTree([3,2,1,6,0,5]));

/**
 * 617. 合并二叉树
 * 和成一个新的二叉树根节点开始呀；
 * 一般会用前序遍历
 */

class Solution617
{

    /**
     * @param TreeNode $root1
     * @param TreeNode $root2
     * @return TreeNode
     */
    //我这边不创建新的节点数，而是在t1树上做修改；
    function mergeTrees($root1, $root2)
    {
        //这点很重要 ，当有任意一个为NULL 直接拿该节点的全部；
        if ($root1 == NULL) return $root2;
        if ($root2 == NULL) return $root1;
        //两个值都不为NULL
        $root1->val += $root2->val;
        $root1->left = $this->mergeTrees($root1->left,$root2->left);
        $root1->right = $this->mergeTrees($root1->right,$root2->right);
        return $root1;
    }

}



###-----------------------------------------------------------------------------
/**
 * extra  extends
 * 二叉树 --- 首先要做到是确定遍历方式；-- 前序 或者 中序 或者后序；
 * 
 * 后序遍历可以收集上一个节点的信息，返回给本节点； 所以是从下到上的计数；
 * 边界 + 读题；
 *  */


/**
 * 
 * $p  $q
 * (!$p && !$q)  两个全部为NULL才会执行；
 * (!$p || !$q)  至少有一个是NULL；两个都是NULL的时候也执行；
 */
// $p = NULL;
// $q = NULL;
// if (!$p && !$q) echo 2;die; //必须两个都为NULL
// if (!$p || !$q) echo 1; // 至少有一个为NULL

/**
 * 递归要去写递归 还是更加关注与 n  和 n-1的关系会更好写代码；
 *  */

/**
 *  if ($root == NULL) return ;
 * 这边有两层意思：
 * 一层就是：就是$root == NULL的时候 返回的数据；
 * 还有另外一层意思就是：当遍历到叶子节点的时候 要进行return；也就是结束条件；
 * 所以 二叉树递归必须是这三条语句都是存在的；
 * if ($root == NULL) return NULL;
 * $this->travese($root->left);// 左节点；
 * $this->traverse($root->right);//右节点；
 */

/**
 * 
 *指数的位运算
 */
echo "\n";
// echo 2 << 1;  // 4
// echo 2 << 0; //2


/**
 * 二叉树的结束条件；
 * if（$root = NULL) return 0; // 会遍历到叶子节点；会对叶子节点来做操作；
 * if ($root->left == NULL && $root->right == NULL) return; 并不会对叶子节点来做操作；一进来就回退；
 * 所以要在终止条件前对 叶子节点做操作；比如 去保存该叶子节点的path；
 */

function traverseNoLeaves($root)
{
    if ($root->left == NULL && $root->right == NULL) return;
    // 注意这里一定要判断 $root->left 必须是一个对象；不能给root 传NULL
    if ($root->left) traverseNoLeaves($root->left);
    echo $root->val;
    if ($root->right) traverseNoLeaves($root->right);
}
// traverseNoLeaves($root); // 10 13 16仅仅遍历非叶子节点；



//array_slice() 位置一般都是左闭右开的；
//负数代表的是从倒数第几个位置；
//length  代表返回的数组长度；
// start 其实位置；end位置，开始和结束位置，当两个都是位置的时候 那么就是左开右闭；
$arr = [1, 2, 3, 4, 5];
//左闭右开；当start 和end 都表示位置的时候 就是左闭右开；
var_dump(array_slice($arr, 4, -1));//空数组；返回的是空数组；

// echo array_search(1,$arr);//返回值的key；这个时间复杂度是O(1) 数组的遍历是n所以还是尽量用这个函数；
