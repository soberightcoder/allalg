<?php

/**
 * 
 * 主要是说明的是树中的二叉搜索树；
 * binary search tree === bst;
 * 特性： 中序遍历是单调递增；
 * 注意： NULL 既是一个平衡二叉树也是一个完全二叉树也是一个满二叉树，也是一个搜索二叉树；
 * 二叉搜索树 一般都使用的是中序遍历，来保证其有序性；
 * 在bst中搜索方向是确定的，所以会很简单；--- 所以很多时候都会用迭代法；
 * 遍历方向是确定的，所以找到某个元素的时间复杂度是log2N；
 * bst binary search tree 一般使用的都是中序遍历；
 */

/**
 * 破局点： 业务逻辑部分；你可以把bst看成一个有序数组，然后中间的业务逻辑用有序数组去做就好了；
 */
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
 * 700. 二叉搜索树中的搜索
 * 你可以看到 其实递归式线性的；他有确定的路线；所以时间复杂度式log2N;
 */

class Solution700
{

    /**
     * @param TreeNode $root
     * @param Integer $val
     * @return TreeNode
     */
    function searchBST($root, $val)
    {
        if ($root == NULL || $root->val == $val) return $root;
        //下面的两个只能运行 一个；
        if ($root->val > $val) $res = $this->searchBST($root->left, $val);
        if ($root->val < $val) $res = $this->searchBST($root->right, $val);
        // 其实函数运行结束 没有返回 就是返回return NULL； 这是函数的默认返回；可以不加；最好加上 好理解；
        return $res;
    }
}

/**
 * 
 * 98. 验证二叉搜索树
 * 就是验证中序遍历中的有序性；
 *  */

class Solution98
{

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    //因为 -231 <= Node.val <= 231 - 1 仅仅是四个字节，而phpint是long 是根据操作系统有关，8个字节的时候不会出问题的；
    public $minInt = PHP_INT_MIN;
    function isValidBST($root)
    {
        // 用中序遍历的bst 是单调递增的来判断是否是二叉树；
        //用中序遍历 判断 中序遍历是否是有效的？
        if ($root == NULL) return true;
        $left = $this->isValidBST($root->left);
        //可以做一些剪纸操作，有false；直接返回不用去遍历右子树；
        if (!$left) return false;
        if ($this->minInt < $root->val) {
            $this->minInt = $root->val;
        } else {
            return false;
        }
        $right = $this->isValidBST($root->right);
        //左子树 和右子树必须是bst 然后中序遍历递增，中序节点也是bst的；
        return $left && $right;
    }
    //记录遍历的上一个节点；
    public $pre = NULL;
    function isValidBSTByPtr($root)
    {
        // 用中序遍历的bst 是单调递增的来判断是否是二叉树；
        //用中序遍历 判断 中序遍历是否是有效的？
        if ($root == NULL) return true; // 只有全部遍历完成之后才为true；
        $left = $this->isValidBST($root->left);
        //可以做一些剪纸操作，有false；直接返回不用去遍历右子树；
        if (!$left) return false;
        // 注意第一个节点的时候 没有上一个节点 就不需要判断了；直接赋值；
        // 必须存在，（不为NULL）；pre上一个节点必须存在，且不为NULL；
        if ($this->pre && $this->pre->val >= $root->val) {
            return false;
        }
        $this->pre = $root; // 保存上一个节点的值，我们判断在保存之前，所以保存的是上一个节点的值；
        $right = $this->isValidBST($root->right);
        //左子树 和右子树必须是bst 然后中序遍历递增，中序节点也是bst的；
        return $left && $right;
    }
}
// $obj98 = new SOlution98();
// echo $obj98->isValidBST($root);

/**
 * 530. 二叉搜索树的最小绝对差
 *  */
class Solution530
{

    /**
     * @param TreeNode $root
     * @return Integer
     */
    //0 <= Node.val <= 105
    public $minInt = PHP_INT_MAX;
    public $pre = NULL;
    function getMinimumDifference($root)
    {
        //暴力先转换成一个有序数组，然后找相邻元素最小值的绝对值；
        //双指针来直接得到 最小绝对值；
        if ($root == NULL) return NULL;
        $this->getMinimumDifference($root->left);
        if ($this->pre != NULL && abs($this->pre->val - $root->val) < $this->minInt) {
            $this->minInt = abs($this->pre->val - $root->val);
        }
        $this->pre = $root;
        $this->getMinimumDifference($root->right);
        return $this->minInt;
    }
}
// $obj530 = new Solution530();
// echo $obj530->getMinimumDifference($root);
/**
 *  501. 二叉搜索树中的众数
 * 出现频率最高的众数，并且可以有多个！！！
 */
class Solution501
{

    /**
     * @param TreeNode $root
     * @return Integer[]
     */
    //这种方法 会占用大量的空间，并且时间复杂度是 nlogn  需要排序，所以时间复杂度很高；
    // 并且占用空间是O(n);
    public $arr = [];
    function findMode1($root)
    {
        //使用额外的空间就比较简单；
        $this->traverse($root);
        // echo current($this->arr);die;
        //找出频率最高的元素；
        arsort($this->arr); // 索引并不一定是有序的；
        $res = [];
        foreach ($this->arr as $k => $v) {
            if (current($this->arr) ==  $v) {
                $res[] = $k;
            } else {
                break;
            }
        }
        return $res;
    }
    //中序遍历，那么相同的值只会挨到一起；
    function traverse($root)
    {
        if ($root == NULL) return NULL;
        $this->traverse($root->left);
        if (isset($this->arr[$root->val])) {
            $this->arr[$root->val]++;
        } else {
            $this->arr[$root->val] = 1;
        }
        $this->traverse($root->right);
    }

    // 双指针的思路 -- 只遍历一遍怎么去计算；$root (当前节点) $pre 上一个节点；这里可以用双指针；这里就是双指针；
    //上一个节点；注意第一个节点的处理；
    public $pre = NULL;
    //因为是有序的，代表的是当前节点出现的次数；因为是有序的呀；所以可以统计；就是有序数组 怎么计算出频率最大数值；
    public $count = 0;
    // 出现频率最大的节点值；
    public $maxCount = 0;
    // 存放结果；
    public $result = [];
    //时间复杂度 是O(n)
    function findMode($root)
    {
        // 怎么去遍历一次，并且不需要额外的一个内存空间；比如上面的arr,这个有序数组，然后去看一下怎么实现；
        if ($root == NULL) return;
        $this->findMode($root->left);

        //看看这个怎么计算！！！ 看下面求有序数组的出现频率最高的元素；！！！ 下面有解释；仔细去看看；
        //pre 就对应的是数组的$arr[$i - 1];本质都是双指针；
        if ($this->pre == NULL) $this->count++;
        elseif ($this->pre->val == $root->val) $this->count++;
        else $this->count = 1;
        $this->pre = $root;
        if ($this->maxCount == $this->count) $this->result[] = $root->val;

        if ($this->count > $this->maxCount) {
            $this->maxCount = $this->count;
            $this->result = []; // 清空；
            $this->result[] = $root->val;
        }

        $this->findMode($root->right);
        return $this->result;
    }
}
$obj501 = new Solution501();
// var_dump($obj501->findMode($root));

/**
 * 最近公共祖先的问题；
 * 一个是二叉树的最近公共祖先；一个是bst的公共祖先；
 * */
/**
 * 236. 二叉树的最近公共祖先
 * 最近的公共祖先；
 *  因为其是从下往上找的，所以肯定找到的是最近的；
 */
class Solution236
{
    /**
     * @param TreeNode $root
     * @param TreeNode $p
     * @param TreeNode $q
     * @return TreeNode
     */
    function lowestCommonAncestor($root, $p, $q)
    {
        //结束条件；---  这便是找到结果的业务逻辑；
        if ($root == NULL) return;
        if ($p === $root || $q === $root) return $root;
        //自下往上遍历  有点回溯的意思

        $left = $this->lowestCommonAncestor($root->left, $q, $p);
        $right = $this->lowestCommonAncestor($root->right, $q, $p);
        //一级级返回数据；
        //左子树 和右子树返回的结果；
        //就是找到结果一级级的返回，这边是一级级返回的业务逻辑
        if ($left == NULL && $right == NULL) return;
        if ($left != NULL && $right == NULL) return $left;
        if ($right != NULL && $left == NULL) return $right;
        // 因为是从下往上遍历 所以一找到左右节点不等于NULL，那么就是该公共节点；
        if ($right != NULL && $left != NULL) return $root;
    }
}


/**
 * 235. 二叉搜索树的最近公共祖先
 * 因为是二叉搜索树，想比较二叉树不需要遍历所有的二叉树节点；
 *  */
class Solution235
{
    /**
     * @param TreeNode $root
     * @param TreeNode $p
     * @param TreeNode $q
     * @return TreeNode
     */
    function lowestCommonAncestor($root, $p, $q)
    {
        //end condition 结束条件才是找到结果
        if ($root == NULL) return;

        // 利用bst的特性来做一个剪枝操作；并不是遍历全部的元素；
        if ($root->val > $p->val && $root->val > $q->val) {
            //应该往左边走
            $left = $this->lowestCommonAncestor($root->left, $p, $q);
            if (isset($left))  return $left;
        }
        if ($root->val < $p->val && $root->val < $q->val) {
            //应该往右边走；
            $right = $this->lowestCommonAncestor($root->right, $p, $q);
            //一级级的返回；存在就一级级的返回就可以了；
            if (isset($right)) return $right;
        }
        // $q和$p中间，那么一定是最近的公共接节点；
        return $root;
    }
}


/**
 * 
 * Bst 插入和删除节点问题；
 */
/**
 * 701. 二叉搜索树中的插入操作
 * 插入任何一个节点，都可以是叶子节点；
 * 因为要求 是一颗bst，并不是一颗平衡二叉树，所以直接在叶子节点插入就可以了；
 *  */

class Solution701
{

    /**
     * @param TreeNode $root
     * @param Integer $val
     * @return TreeNode
     */
    // 我不知道为啥这种方法不行呀；
    function insertIntoBST($root, $val)
    {
        //找到叶子节点，然后进行插入；
        if ($root->left == NULL && $root->right == NULL) {
            if ($root->val > $val) {
                $root->left = new TreeNode($val);
            } else {
                $root->right = new TreeNode($val);
            }
            //一定要return；结束条件；
            return;
        }
        //traverse bst 这两条路 只走一条；
        if ($root->val > $val && isset($root->left)) $this->insertIntoBST($root->left, $val);
        if ($root->val < $val && isset($root->right)) $this->insertIntoBST($root->right, $val);
        //res
        return $root;
    }

    /**
     * 递归法；
     */
    function insertIntoBST1($root, $val)
    {
        if ($root == NULL) return new TreeNode($val);
        if ($root->val > $val) $root->left = $this->insertIntoBST($root->left, $val);
        else $root->right = $this->insertIntoBST($root->right, $val);
        return $root;
    }
    /**
     * 迭代法；----
     * leetcode 有问题；傻逼；
     *  */
    function insertIntoBST2($root, $val)
    {
        if ($root == NULL) {
            $root = new TreeNode($val);
            return $root;
        }
        $pre = NULL;
        $cur = $root;

        while (isset($cur)) {
            //上一个节点； 就是叶子节点的父节点；
            $pre = $cur;
            if ($cur->val > $val) $cur = $cur->left;
            else $cur = $cur->right;
        }
        //
        // var_dump($pre);die;
        if ($pre->val > $val) $pre->left = new TreeNode($val);
        else $pre->right = new TreeNode($val);

        return $root;
    }
}
// $obj701  = new Solution701();
// var_dump($obj701->insertIntoBST2($root, 7));

/**
 * 450. 删除二叉搜索树中的节点
 *删除二叉树中的节点；  
 * 调整二叉树的结构是最难的；--- 需要改变树的结构；
 *  */
class Solution450
{

    /**
     * @param TreeNode $root
     * @param Integer $key
     * @return TreeNode
     */
    function deleteNode($root, $key)
    {
        //对上一层的返回；
        //没找到删除的节点；
        if ($root == NULL) return NULL;
        // 找到了删除节点；
        if ($root->val == $key) {

            // 删除的是叶子节点 不需要改变二叉树的结构；左边空 右边空；
            if ($root->left == NULL && $root->right == NULL) {
                return NULL;
            }
            //要删除的节点，左不空，右为空；
            if ($root->left != NULL && $root->right == NULL) {
                return $root->left;
            }
            //左为空，右不为空，要不为空的节点来代替要删除的节点；
            if ($root->left == NULL && $root->right != NULL) {
                return $root->right;
            }
            //
            // 左不空，右不空，这个节点的删除；--- 这个是最难的；需要大幅度的调整二叉树；
            if ($root->left != NULL && $root->right != NULL) {
                // 往右子树去找比较小的值；
                $cur = $root->right;
                while ($cur->left != NULL) {
                    $cur = $cur->left;
                }
                $cur->left = $root->left;
                return $root->right;
            }
        }
        //遍历；
        if ($root->val > $key) {
            $root->left = $this->deleteNode($root->left, $key);
        } else {
            $root->right = $this->deleteNode($root->right, $key);
        }
        //res
        return $root;
    }
}

/**
 * 669. 修剪二叉搜索树
 * 修建二叉树，并不是剪枝操作；
 * 注意 $root->val < $low 因为他的右子树，是有可能大于$low 所以要对右子树来进行修剪；
 * 同理 ， $root->val  > $high 我们只需要对他的左子树进行修剪就好了；
 *  */

class Solution669
{

    /**
     * @param TreeNode $root
     * @param Integer $low
     * @param Integer $high
     * @return TreeNode
     */
    function trimBST($root, $low, $high)
    {
        //
        if ($root == NULL) return NULL;

        //前序遍历；
        //$root->val 和  $low  和 high的关系；
        if ($root->val < $low) {
            //因为一直 往右边走，所以值一直变大，所以肯定先删除的是，
            //修剪他的右子树，因为他的右子树，有可能会有比他大的值；
            $right = $this->trimBST($root->right, $low, $high);
            //修剪后的结果；
            return $right;
        }
        if ($root->val > $high) {
            //
            $left = $this->trimBST($root->left, $low, $high); //修剪之后的结果；
            return $left;
        }
        // 遍历   这里有问题 到底是往左边走的呀还是往右边走的呀？
        //都要去遍历 ？ 左右 都要去遍历 ，  怎么利用 bst的二叉树特性！！！

        // 在整个范围内，就正常接收就可以了；
        $root->left = $this->trimBST($root->left, $low, $high);
        $root->right = $this->trimBST($root->right, $low, $high);
        return  $root;
    }
}

/**
 * 108. 将有序数组转换为二叉搜索树 --- 并不唯一，直接从中间取就行啦；
 * 高度平衡的二叉树；  左右子树的高度相差不要超过1；
 * 不高度平衡，直接写成链表就好了，也是一种特殊的二叉树；
 * 也是构建二叉树，先找root；
 * 都选中间点来做左右子树分割就好了；
 *  */

class Solution108
{

    /**
     * @param Integer[] $nums
     * @return TreeNode
     */
    function sortedArrayToBST($nums)
    {
        // 注意结束条件；
        if (empty($nums)) return;
        $mid =  count($nums) >> 1;  // eg: 7  3 是中间, 6 3 也差不多吧 ，反正就不唯一，随便生成一个就行啦；
        $root = new TreeNode($nums[$mid]);
        $left = array_slice($nums, 0, $mid);
        $right = array_slice($nums, $mid + 1);
        $root->left = $this->sortedArrayToBST($left);
        $root->right = $this->sortedArrayToBST($right);
        return $root;
    }
}

// $obj108 = new Solution108();
// $obj108->sortedArrayToBST([1,2,3,4,5]);
/**
 * 538. 把二叉搜索树转换为累加树
 * 在有序数组里面就是把后一个数相加到本数里面；
 * 为什么难，是因为二叉树，遍历比较难；
 * 注意 在bst里面保证 有序性 ，必须是中序遍历  然后再倒叙，那么就变成了 右中左；
 * 有序数组的累加想到的最多的也是双指针去实现；
 * bst 双指针  +  倒叙遍历；
 *  */

class Solution538
{

    /**
     * @param TreeNode $root
     * @return TreeNode
     */
    //如何倒叙的呢
    //上一个节点；
    public $pre = NULL; // 一开始默认是0
    function convertBST($root)
    {
        //倒叙；
        if ($root == NULL) return;
        //先往右边走，肯定是找最大值呀；    
        $this->convertBST($root->right);
        // echo $root->val."->";
        //后序遍历；倒叙遍历 + 双指针；
        $root->val = $this->pre->val + $root->val;
        $this->pre = $root; //保留上一个节点值；
        $this->convertBST($root->left);
        return $root;
    }
}
// $obj538 = new Solution538();
// $obj538->convertBST($root);
##---------------------------------------------------------
/**
 * extra extends 
 * ||  至少有一个是true；是真的； 因为是交集，那么两个都是true 也可以；
 */
$a = false;
$b = true;
if (!$a || !$b) {
    echo 'run';
}


/**
 * 有序数组的众数
 * 暴力求解；
 *  */

/**
 * 169. 多数元素 --- 一个数组内，大多数的数值是那个数；
 * 也可以做有序数组的众数；
 * 时间复杂度是O(n) 空间复杂度是O(1)
 * 投票算法；
 * 主要思路： 如果我们把众数记为 +1，把其他数记为 −1，将它们全部加起来，显然和大于 0，从结果本身我们可以看出众数比其他数多；；
 */
class Solution169
{

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function majorityElement($nums)
    {
        //众数只有一个呗；
        // 单个元素出现的频率 --- 减到0就说明该元素有可能会比上一个元素出现的概率高；
        $count = 1;
        $candidate = $nums[0];

        for ($i = 1; $i < count($nums); $i++) {
            // 如果等于候选数字就做  加1 操作；
            if ($nums[$i] == $candidate) {
                $count++;
            } else {
                $count--;
                if ($count == 0) {
                    //就是$num[0] = 和$nums[$i] 出现的频率是一样的了；所以就给下一个元素了；
                    $candidate = $nums[$i];
                    $count = 1;
                }
            }
        }
        return $candidate;
    }
}

/**
 * unset 可以unset 一个数组吗？
 * 销毁一个变量  unset(); 
 * $arr = []; 清空一个数组；
 */

$arr = [1, 2, 3, 4];

// unset($arr);//销毁一个变量；
$arr = []; // 清空 一个数组；
// var_dump($arr);

/**
 *BST 二叉搜索树； 
 *要做对树做节点添加或者删除一定要使用后序遍历
 * 删除和增添节点的模板；
 * // 下面是伪代码；
 */

function addAndDelete($root, $val)
{
    // 结束条件；
    //未找到
    if ($root == NULL) return NULL;
    //找到的业务逻辑；
    if ($root->val == $val) {
        //业务逻辑  很多的业务逻辑；
        // if () {

        // return $obj;
        // }
        // if () {

        // return $obj;
        // }

    }
    if ($root->val > $val) $root->left = addAndDelete($root->left, $val);
    else $root->right = addAndDelete($root->right, $val);
    //返回根节点；
    return $root;
}

/**
 * 在bst中查找比该节点，大一丢丢的数字，肯定在这个左子树的的左下角；
 *  */


/**
 *注意在 递归中二叉树中 ，这代表的是二叉树子树的结果值； 
 *  */

function test($root)
{
    if ($root == NULl) return NULL;
    //这个代表的是左子树的 结果值； 和test 从根节点开始计算的结果值是一样的，只是一个代表的是根节点 root 整个树，另外一个代表的是左子树的结果；
    test($root->left);
    test($root->right);
}


/**
 *怎么找出来 有序数组出现频率最高的数组集合呢？
 * leetcode  501；
 *  */
$sortArr =  [1, 1, 1, 2, 2, 3, 3, 3, 4, 4, 5, 6, 7];

class Solution5012
{
    public $count = 0;
    public $maxCount = 0;
    public $res = [];

    function findMode2($arr)
    {
        // pre = $arr[$i - 1];
        for ($i = 0; $i < count($arr); $i++) {
            if ($i == 0) {
                $this->count = 1;
            }
            if ($i > 0 && $arr[$i] == $arr[$i - 1]) {
                $this->count++;
            } else {
                //不等于 要清空 变成1；无论如何都会去做清空；
                $this->count = 1;
            }
            //先判断相等；
            if ($this->maxCount == $this->count) {
                //会加入很多；所以 当大于的时候才会需要清空；
                $this->res[] = $arr[$i];
            }
            //必须在后面；
            if ($this->maxCount < $this->count) {
                //清空； 因为加入了很多；
                $this->res = [];
                $this->res[] = $arr[$i];
                $this->maxCount = $this->count;
            }

            
        }
        return $this->res;
    }
}
$obj5012 = new Solution5012();
var_dump($obj5012->findMode2($sortArr));

/**
 *  有序数组 怎么变成累加数组； 
 * 就是倒叙遍历，把后一个加在本元素的上面；
 * leetcode --- 538 $pre 就是类似于$nums[$i + 1]; 上一个节点；
 *  */
function com1($arr)
{
    $n = count($arr);
    for ($i = $n - 1; $i >= 0; $i--) {
        if ($i  < $n - 1) {
            $arr[$i] += $arr[$i + 1];
        }
    }
    return $arr;
}
// var_dump(com1($sortArr));