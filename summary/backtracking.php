<?php
// echo "run";die;
/**
 * 回溯运算； 溯 就是时间；
 * 相辅相成 有递归肯定有回溯；
 * 回溯 是一种暴力 解决方法 --- 唯一一个可以优化的方案就是剪枝操作；
 * 不剪枝，需要遍历所有的树；所以效率会很低；
 * 回溯很适合那种需要多个for循环嵌套的问题；---可以转换递归回溯的问题；
 * 
 * --- 对递归进行for循环--- 回溯；
 * 回溯的本质--- 递归嵌套n个for循环；
 * 所有的回溯算法解决 都可以抽象成一个树结构；
 * 
 */

/**
 *  回溯算法的基础知识；
 *回溯 搜索法，其实是一个纯粹暴力算法，有些问题只能通过回溯法来解决；
 * 回溯法能解决什么问题： 组合 和排列；切割问题；子集问题；棋盘问题；N皇后，解数独；
 */
/**
 *模板
 * if(终止条件) 一般回去收集结果；通常是在叶子节点收集结果；return；
 * for(集合元素集) 这里的for循环代表的是循环次数，也是回溯的几叉树；
 *    处理节点； 处理节点的操作；
 *    递归函数；--- 
 *    回溯操作；撤销处理节点的情况；为啥要撤销？肯定要撤销呀；不然数据就错误了；
 *   
 */
/**
 * for 循环遍历递归，首先向往下深度遍历，然后回退，然后再去做广度，继续深度，然后广度，深度的过程；
 * for的遍历次数就是代表几叉树；
 * 深度 是由结束条件来限定的；
 * 至于 保存数据实在 每一个节点还是再结束条件，可以根据实际情况去选择；
 */

/**
 * 回溯三个重点：
 *  回溯 
 *  剪枝
 *  去重问题； （当数组中由重复元素，然后如何去重；） 
 *
 */
/**
 * bst树的遍历
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
 * 求二叉树所有的路径；
 * 257. 二叉树的所有路径
 *  前序遍历
 *  */

class Solution257
{

    /**
     * @param TreeNode $root
     * @return String[]
     */
    //单个路径；
    public $path = [];
    public $res = [];
    function binaryTreePaths($root)
    {
        //必须放在 结束条件之前不然，叶子节点就没法保存到$path 里面了；
        array_push($this->path, $root->val); //处理节点的操作；
        if ($root->left == NULL && $root->right == NULL) {
            $this->res[] = $this->path;
            return;
        }

        if ($root->left) {
            $this->binaryTreePaths($root->left);
            //回溯？ 为啥要回溯？
            array_pop($this->path);
        }
        if ($root->right) {
            $this->binaryTreePaths($root->right);
            array_pop($this->path);
        }
        return $this->res;
    }
}
// $obj257 = new Solution257();
// var_dump($obj257->binaryTreePaths($root));



/**
 *112. 路径总和
 *  */

class Solution112
{

    /**
     * @param TreeNode $root
     * @param Integer $targetSum
     * @return Boolean
     */
    // 所有的路径的回溯； 一个东西；
    public $sum = 0;
    function hasPathSum($root, $targetSum)
    {
        if ($root == NULL) return false; // false;
        // return $this->traverse($root,$targetSum);
        return $this->traverse($root, $targetSum);
    }

    public function traverse($root, $targetSum)
    {
        $this->sum += $root->val; //对节点的操作；
        if ($root->left == NULL && $root->right == NULL) {
            //路径和 是多少 在这里？
            if ($this->sum == $targetSum) {
                return true;
            } else {
                return false;
            }
        }
        // 
        if ($root->left) {
            $left = $this->hasPathSum($root->left, $targetSum);
            if ($left == true) return true;
            // 对节点操作的回退；
            $this->sum -= $root->left->val; //就是把这个节点做的操作回退了；
        }
        //
        if ($root->right) {
            $right = $this->hasPathSum($root->right, $targetSum);
            if ($right == true) return true;
            $this->sum -= $root->right->val;
        }
        //最后一个有一个是真的就行啦；// 遍历完了没有就字节返回false；
        //没有提前返回true 就是false；
        return false;
    }
    // 做减法 确实比较简单；
    function traverse1($root, $count)
    {
        //这边使用的是局部变量，然后做的是减法运算；$count == 0 ；
        $count -= $root->val;
        if ($root->left == NULL && $root->right == NULL) {
            if ($count == 0) {
                return true;
            }
            // } else {
            //     //一定要返回false ；当只有一个节点的时候需要用到；
            //     return false;
            // }
        }
        if ($root->left) {
            $this->traverse1($root->left, $count);
            $count += $root->val;
        }

        if ($root->right) {
            $this->traverse1($root->right, $count);
            $count += $root->val;
        }
        // 当只有一个节点的时候直接走这里也行；
        return false;
    }
}
//  $obj112 = new Solution112();
//  echo $obj112->hasPathSum($root,43);


/**
 * 
 *  下面全是组合问题：
 * 组合 因为 1，2 和2，1 是一个组合，所以我们需要去重；是一个深度的剪枝；
 * 去重的实现就是用startIndex来实现的；
 * 每一层 都是一个循环；
 *  */
/**
 *  77. 组合
 *  剪枝操作  --- [1,2,3,4,5] 比如有五个数据 $n = 5; $k = 3; 其实你的$n值只需要取到3就可以了；
 * //$i< = $n - ($k - $this->tmp) + 1; => 5-(3 - 0) + 1 = 3; 3就代表的是结束；直接带入值来做测试就好了；
 */

class Solution77
{

    /**
     * @param Integer $n
     * @param Integer $k
     * @return Integer[][]
     */
    public $res = [];
    public $tmp = [];
    function combine($n, $k)
    {
        $this->traverse($n, $k, 1);
        return $this->res;
    }
    function traverse($n, $k, $startIndex)
    {
        // count() 必须是一个数组；
        if (count($this->tmp) == $k) {
            $this->res[] = $this->tmp;
            return;
        }
        //for循环次数就是 几叉数；
        // startIndex代表的是数组起始值；
        // 起始剪枝优化的就是for 循环的次数；
        // 就是要把不够$k数据给剪枝了；不需要用树往下遍历了；
        // $k - count($this->tmp) 还需要的元素数目；
        // $k - ($n - count($this->tmp)); 
        // $n -($k - count($this->tmp)) + 1 // 不够$k - count($this->tmp)的直接给剪掉；
        //关于这样的边界条件 直接带值 测试一下是最后的， $n = 4; $k = 2;一开始，不就是，一开始tmp = 0;所以 <= 2完全是争取到的；
        for ($i = $startIndex; $i <= $n - ($k - count($this->tmp)) + 1; $i++) {
            $this->tmp[] = $i;
            $this->traverse($n, $k, $i + 1);
            array_pop($this->tmp);
        }
    }
}

/**
 * 216. 组合总和 III
 * 
 */
class Solution216
{

    /**
     * @param Integer $k
     * @param Integer $n
     * @return Integer[][]
     */

    public $res = [];
    public $tmp = [];
    public $sum = 0;
    function combinationSum3($k, $n)
    {
        $this->traverse($k, $n, 1);
        return $this->res;
    }

    function traverse($k, $n, $startIndex)
    {
        //end; condition
        if ($this->sum == $n && count($this->tmp) == $k) {
            $this->res[] = $this->tmp;
            return;
        }
        //travese  超过 这么多就不够$k个数字了；
        for ($i = $startIndex; $i <= 9 - ($k - count($this->tmp)) + 1; $i++) {
            $this->tmp[] = $i;
            $this->sum += $i;
            $this->traverse($k, $n, $i + 1);
            array_pop($this->tmp);
            $this->sum -= $i;
        }
    }
}
// $obj216 = new Solution216();
// $obj216->combinationSum3(3, 7);
// var_dump($obj216->res);die;


class Solution
{

    /**
     * @param Integer $k
     * @param Integer $n
     * @return Integer[][]
     */

    public $res = [];
    public $tmp = [];
    public $sum = 0;
    function combinationSum3($k, $n)
    {
        $this->traverse($k, $n, 1);
        return $this->res;
    }

    function traverse($k, $n, $startIndex)
    {
        //end; condition//只要是 数量等于k都要进行返回；
        if ($k == count($this->tmp)) {
            if ($this->sum = $n) {
                $this->res[] = $this->tmp;
            }
            return;
        }
        //travese  超过 这么多就不够$k个数字了；
        //$startIndex 一个集合里面 ，防止得到重复的元素，所以这边使用的是startIndex;
        //$startIndex 记录的是遍历过的元素；
        for ($i = $startIndex; $i <= 9 - ($k - count($this->tmp)) + 1; $i++) {
            $this->tmp[] = $i;
            $this->sum += $i;
            $this->traverse($k, $n, $i + 1);
            array_pop($this->tmp);
            $this->sum -= $i;
        }
    }
}

/**
 * 17. 电话号码的字母组合
 *  */

class Solution17
{
    public $res = [];
    public $map = ['2' => 'abc', '3' => 'def', '4' => 'ghi', '5' =>
    'jkl', '6' => 'mno', '7' => 'pqrs', '8' => 'tuv', '9' => 'wxyz'];
    public $tmp = [];
    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        //遍历的深度 跟输入$digits 字母的个数有关；
        //level 层数；目前所出的层数；
        $this->backTracking($digits, 0);
        return $this->res;
    }
    //digits 遍历到第几个元素了；
    public function backTracking($digits, $index)
    {
        //两个数字就是两层；---- 超出索引范围了，所以肯定要开始收集数据了；
        if ($index == strlen($digits)) {
            //把数组转换成字符串，中间没有分隔符；
            $this->res[] = implode($this->tmp);
            return;
        }
        // 是几叉树，是由每个数字的字符串的字符的位数来决定；有的两位有的三位；
        //每一层 是不同的集合；
        // 并且每一个集合都是从0开始；
        //$index 代表的是digits字符串的第几个字母；从0开始计算；
        for ($i = 0; $i < strlen($this->map[$digits[$index]]); $i++) {
            $this->tmp[] = $this->map[$digits[$index]][$i];
            $this->backTracking($digits, $index + 1);
            array_pop($this->tmp);
        }
    }
}

/**
 * 
 *39. 组合总和
 */
class Solution39
{

    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    //可以看成整个对象的全局变量；
    public $tmp = [];
    public $res = [];
    public $sum = 0;
    function combinationSum($candidates, $target)
    {
        $this->backTracking($candidates, $target, 0);
        return $this->res;
    }
    function backTracking($candidates, $target, $startIndex)
    {
        //end cond
        if ($this->sum > $target)  return;
        if ($this->sum == $target) {
            $this->res[] = $this->tmp;
            return;
        }

        // traverse
        //用传入的参数是$startIndex = $i  来实现去重；
        for ($i = $startIndex; $i < count($candidates); $i++) {
            $this->tmp[] = $candidates[$i];
            $this->sum += $candidates[$i];
            $this->backTracking($candidates, $target, $i);
            array_pop($this->tmp);
            $this->sum -= $candidates[$i];
        }
    }
}
// $obj39 = new Solution39();
// $obj39->combinationSum();

/**
 * 40. 组合总和 II 
 * $nums 数组中 可以有重复元素的;
 * 就是重复元素，如何去重？？？
 * 两种去重 ： 树层去重 + 树枝去重；
 * $startIndex  防止组合中出现重复的元素；
 * 时间复杂度是2^n所以使用sort 排序并不会影响该组合总和的时间复杂度；
 *  */

class Solution40
{

    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    public $tmp = [];
    public $res = [];
    public $sum = 0;
    public $used = [];

    function combinationSum2($candidates, $target)
    {
        // used使用过元素的初始化；
        for ($i = 0; $i < count($candidates); $i++) {
            $this->used[$i] = 0;
        }
        //先做排序；nlogn
        sort($candidates);
        $this->backTracking($candidates, $target, 0);
        return $this->res;
    }

    function backTracking($candidates, $target, $startIndex)
    {
        $n = count($candidates);
        //end cond
        // sum 超过了值；
        if ($this->sum > $target)  return;
        if ($this->sum == $target) {
            $this->res[] = $this->tmp;
            return;
        }

        // traverse
        //用传入的参数是$startIndex = $i  来实现去重；
        //不知道树的层数 ，是没有办法来进行去重的；
        for ($i = $startIndex; $i < $n; $i++) {
            // 树层去重；$this->used[$i - 1] 是为了限定树层去重；
            if ($i > 0 && $candidates[$i] == $candidates[$i - 1] && $this->used[$i - 1] == 0) continue;
            $this->tmp[] = $candidates[$i];
            $this->sum += $candidates[$i];
            $this->used[$i] = 1;
            $this->backTracking($candidates, $target, $i + 1);
            array_pop($this->tmp);
            $this->sum -= $candidates[$i];
            $this->used[$i] = 0;
        }
    }
}
/**
 * 子集问题；
 *  * 子集中 1,2  和 2，1 是同一个子集，注意去重；
 * 子集也是一个组合，所以要去重； 用startIndex 来实现；
 * 每一个节点都会有我们的结果；
 * 子集也需要用到startIndex来做去重；；
 */
/**
 * 78. 子集
 */
class Solution78
{

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    public $res = [];
    public $tmp = []; // 就一个数组，为啥可以保存多个递归数据；
    function subsets($nums)
    {
        $this->backTracking($nums, 0);
        return $this->res;
    }
    //startIndex代表的是待遍历元素的索引；
    function backTracking($nums, $startIndex)
    {
        //每一个节点 刚进入节点的时候；[] 是什么时候输入进去的？ 前序遍历呀 我知道了；？ [] 不会输入多个吗？
        //是只会进入一次；捋一下业务逻辑；
        $this->res[] = $this->tmp;
        //假如是[1,2,3] 在$startIndex = 0的时候收获[] ,在1的时候受1,在2的时候收获[1,2],在三的时候去收获[1,2,3]，3正好等于数组的长度；也正好是结束条件；
        if ($startIndex == count($nums)) {
            //end  // 这个结束条件是怎么判断的；？？？
            return;
        }
        //traverse；
        //好好去理解一下 呀 卧槽；这里还是有点迷糊；
        //$startindex 仅仅是对下一层起作用，对下一层起到了去重作用；  只会往后面拿走；
        //而且要全部遍历完；
        for ($i = $startIndex; $i < count($nums); $i++) {
            //tmp的问题；好好看一下把；
            $this->tmp[] = $nums[$i];
            $this->backTracking($nums, $i + 1);
            array_pop($this->tmp);
        }
    }
}

/**
 *90. 子集 II 
 *  因为含有重复元素，最关键的是怎么去重；
 *   */

 class Solution90 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    public $res = [];
    public $tmp = []; // 就一个数组，为啥可以保存多个递归数据；
    public $used = [];//
    function subsetsWithDup($nums)
    {
        //init
        for ($i = 0; $i < count($nums); $i++) {
            $this->used[$i] = 0;
        }
        sort($nums);
        $this->backTracking($nums, 0);
        return $this->res;
    }
    //startIndex代表的是待遍历元素的索引；
    function backTracking($nums, $startIndex)
    {
        //每一个节点 刚进入节点的时候；
        $this->res[] = $this->tmp;
        //因为 startIndex进入到下一层了，count($nums);代表的是长度；
        if ($startIndex == count($nums)) {
            //end 
            return;
        }
        //traverse；
        //好好去理解一下 呀 卧槽；这里还是有点迷糊；
        //$startindex 仅仅是对下一层起作用，对下一层起到了去重作用；  只会往后面拿走；
        for ($i = $startIndex; $i < count($nums); $i++) {
            //tmp的问题；好好看一下把；
            if ($i > 0 && $nums[$i] == $nums[$i - 1] && $this->used[$i - 1] == 0) continue;
            $this->tmp[] = $nums[$i];
            $this->used[$i] = 1;
            $this->backTracking($nums, $i + 1);
            array_pop($this->tmp);
            $this->used[$i] = 0;
        }
    }
}
// $obj90 = new Solution90();
// var_dump($obj90->subsetsWithDup([1,1,3]));
/**
 * 全排列；
 */
/**
 * 46. 全排列
 * 没有重复的元素；
 */

 class Solution46 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */

    public $tmp = [];
    public $res = [];
    public $used = [];

    function permute($nums) {
        for ($i = 0; $i < count($nums); $i++) {
            $this->used[$i] = 0;
        }
        //数据的初始化；
        // $this->used = array_fill(0, count($nums),0);// 从0开始填充，填充数组的长度是count($nums); 用什么数据来做填充，就是用0来做填充；
        $this->backTracking($nums);
        return $this->res;
    }

    function backTracking($nums) {
        //在遍历结束，节点的地方来接收数据
        $n = count($nums);
        //end condition;
        if (count($this->tmp) == $n) {
            $this->res[] = $this->tmp;
            return ;
        }

        for ($i = 0; $i < $n; $i++) {
            //这边剪掉一些已经使用过的节点；
            if ($this->used[$i]) continue;
            $this->tmp[$i] = $nums[$i];
            $this->used[$i] = 1;
            $this->backTracking($nums);
            array_pop($this->tmp);
            $this->used[$i] = 0;
        }

    }
}

/***
 *全排列 并且有重复元素； 
 *  47. 全排列 II
 * 都是对 树层的去重；
 *  */ 

 class Solution7 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */

     public $tmp = [];
    public $res = [];
    public $used = [];
    function permuteUnique($nums) {
        //init
        //
        sort($nums);
        for ($i = 0; $i < count($nums); $i++) {
            $this->used[$i] = 0;
        }
        $this->backTracking($nums);
        return $this->res;
    }

    function backTracking($nums) {
        //在遍历结束，节点的地方来接收数据
        $n = count($nums);
        if (count($this->tmp) == $n) {
            $this->res[] = $this->tmp;
            return ;
        }

        for ($i = 0; $i < $n; $i++) {
            //这边剪掉一些已经使用过的节点；
            if ($this->used[$i]) continue;
            // 有重复元素的去重；
            if ($nums[$i] == $nums[$i - 1] && $i > 0 && $this->used[$i - 1] == 0) continue;
            $this->tmp[$i] = $nums[$i];
            $this->used[$i] = 1;
            $this->backTracking($nums);
            array_pop($this->tmp);
            $this->used[$i] = 0;
        }

    }
}
###--------------------------------------------------------------------------------
/**
 * 递归和回溯相互共存在，有递归就会有回溯；
 * extra extends
 * 普通的二叉树的深度优先遍历（递归）也会有回溯；
 */


function traverse($root)
{
    if ($root == NULL) return NULL;
    //下一层的root 是$root->left 回到该层确实$root
    // 这边就是隐藏了，回溯的过程； 直接在函数参数里面做操作，就可以隐藏回溯操作；
    // 当需要回溯的数据，不是函数参数的时候，你只能自己去手动回溯；
    traverse($root->left);
    traverse($root->right);
}


/**
 * 
 * 求组合的时间复杂度通常可以通过回溯算法来实现。假设我们要从 n 个元素中选取 k 个元素的所有组合，那么求组合的时间复杂度通常是 O(C(n, k))，其中 C(n, k) 表示从 n 个元素中选取 k 个元素的组合数。

 * 组合数 C(n, k) 的计算公式是 C(n, k) = n! / (k! * (n - k)!)，其中 ! 表示阶乘。因此，计算组合数的时间复杂度取决于计算阶乘和除法的时间复杂度。

 * 在一般情况下，计算阶乘的时间复杂度是 O(n)，因此计算组合数的时间复杂度可以近似为 O(n)。然而，需要注意的是，在实际的回溯算法中，可能会存在剪枝等优化技巧，这些技巧可以减少搜索空间，从而降低时间复杂度。

 * 因此，对于求组合的时间复杂度，可以近似地认为是 O(C(n, k))，但具体的时间复杂度取决于具体的算法实现和问题规模。

 */

/**
 *关于 集合 剪枝问题分析；
 *  */

