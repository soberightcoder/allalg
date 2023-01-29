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


/**
 * 77. 组合
 *  n个数 k的组合
 * // 第一种求解方法 可以用暴力求解 就是需要用 k次for循环，k越大那么时间复杂度越高； 不建议使用；
 * // 第二种就是回溯 算法，其实就是一个二叉树 可以去画图看一下 但是注意去重问题；
 * ***** 去重 剪枝问题
 */
class Solution {

    /**
     * @param Integer $n
     * @param Integer $k
     * @return Integer[][]
     *
     */
    public $res = [];
    public $tmp = [];
    /**
     * n [1,n] // 1--n  n个整数
     */
    function combine($n, $k) {
        $this->traversel($n,$k,1);
        return $this->res;
    }

    /**
     * @param $n
     * @param $k
     * @param $startIndex //来做去重处理 搜索的起始位置
     *
     */

    function traversel($n,$k,$startIndex) {
        //end //end c 结束条件
        if (count($this->tmp) == $k) {
            $this->res[] = $this->tmp;
            return;
        }
        //单层递归逻辑
        for ($i = $startIndex; $i <= $n; $i++) {//本层 i++ 本层数据的循环
            array_push($this->tmp, $i);
//            $i = $i + 1;
//            $this->traversel($n, $k, ++$i);  // 下一层的；// 下一层的startIndex+1//下一层数据的循环
            $this->traversel($n, $k, $i + 1);  // 下一层的；// 下一层的startIndex+1//下一层数据的循环
//            $i--;
            array_pop($this->tmp);//回溯
        }
    }
    /**
     * 剪枝操作原理
     * 至少是“最少有几个，相当于大于等于的意思”；至多是“最多有几个，相当于小于等于的意思。至少是“最少有几个，相当于大于等于的意思”；至多是“最多有几个，相当于小于等于的意思。
     */
    /**
     *   剪枝操作
     */
    function combine1($n, $k) {
        $this->help($n, $k, 1);
        return $this->res;
    }


    function help($n, $k, $startIndex) {
        $len = count($this->tmp);
        //end c
        if ($len == $k) {
            $this->res[] = $this->tmp;
            return;
        }
        // 单层递归
        for ($i = $startIndex; $i <= $n - ($k - $len) + 1; $i++) {
            array_push($this->tmp, $i);
            $this->help($n, $k, $i + 1);
            array_pop($this->tmp);
        }
    }

}
//$obj = new Solution();
//var_dump($obj->combine(4, 2));die;

/**
 * leetcode 216 - 组合和
 */
class Solution1 {

    /**
     * @param Integer $k
     * @param Integer $n  //sum  == $n
     * @return Integer[][]
     * 只有数字  1 - 9 ；
     */
    public $res = [];
    public $tmp = [];
    public $sum = 0;//和

    function combinationSum3($k, $n) {
        //1-9 ;;;;;;
        $this->help($k,$n,1);
        return $this->res;
    }

    function help($k,$n,$startIndex) {
        //end cond
        $len = count($this->tmp);
        if ($len == $k) {
            if ($this->sum == $n) {
                $this->res[] = $this->tmp;
            }
                return;//就算不等于 也要做回溯；做回退；
        }
//        if ($this->sum == $n && $len == $k) {
//            $this->res[] = $this->tmp;
//            return;
//        }

        //单层遍历
        // 1-9;
        for ($i = $startIndex; $i <= 9 - ($k - $len) + 1; $i++) {
            array_push($this->tmp,$i);
            $this->sum += $i;
            $this->help($k, $n, $i + 1);
            $this->sum -= $i;
            array_pop($this->tmp);
        }
    }
}

//$obj1 = new Solution1();
//var_dump($obj1->combinationSum3(3,7));die;

/**
 * 17. 电话号码的字母组合 leetcode
 * // b暴力求解 就是for循环的方式； 多个for循环去实现
 */
class Solution2 {

    /**
     * @param String $digits
     * @return String[]
     */
    public $map = ['2'=>'abc','3'=>'def','4'=>'ghi','5'=>
        'jkl','6'=>'mno','7'=>'pqrs','8'=>'tuv','9'=>'wxyz'];
    public $tmp = [];
    public $res = [];
    //
    function letterCombinations($digits) { //level  从0开始；
        $max = strlen($digits);// 0 - 4;
        // 需要那几个参数？？？
        //需要多少层；
        if (!$max) return [];
        $level = 0;
        $this->help($digits,$max,$level);//   从第0层开始
        return $this->res; // 字符串；
    }

    public function help($digits,$max,$level) {
        // 决定了怎么结束
        if ($max == 0) { // $max == 0 就代表[] 返回的是[]
            $this->res[] = implode($this->tmp);
            return;
        }

        //单层遍历  第一层的个数
        for ($i = 0; $i < strlen($this->map[$digits[$level]]); $i++) {
            array_push($this->tmp,$this->map[$digits[$level]][$i]);
            $this->help($digits,$max - 1,$level + 1);
            array_pop($this->tmp);
        }

    }
}
/**
 * ##leetcode - 39. 组合总和
 */

class Solution3 {

    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    public $tmp = [];
    public $res = [];
    public $sum = 0;

    function combinationSum($candidates, $target) {
        //结束条件是什么
//        natsort($candidates);//保留索引关系 坑B
        sort($candidates); //  不保留索引关系
//        var_dump($candidates);die;
        //找到
        //怎么才算找不到？？
        //sum >= 都要结束； =  添加到res   > return
        $this->help($candidates,$target,0);
        return $this->res;//这边最好用一个set 来保存；但是php的key 不能保存复式数据结构；
    }

    /**
     * @param $candidates
     * @param $target
     * @param $startIndex // 去重去重； 去重；去重；去重；去重；去重；去重； // 利用往后找的特性来去重；
     */

    public function help($candidates,$target,$startIndex) {//注意去重；//
//        var_dump($candidates);die;
        // end cond
        if ($this->sum == $target) { //
            $this->res[] = $this->tmp;
            return;
        } else if ($this->sum > $target) {  //
            return;
        }
        // 单层递归
        $len = count($candidates);
        //剪枝 操作必须要先做排序
        // $this->sun + $candidates[$i] > $target  //当超过target 就不需要再往下判断了；
        for ($i = $startIndex; $i <= $len - 1 && ($this->sum + $candidates[$i] <= $target); $i++) {
            array_push($this->tmp, $candidates[$i]);
            $this->sum += $candidates[$i];
            $this->help($candidates,$target,$i); // 这里必须要$i  但是深度 不变 所以是 $i + 1;// 深度会变成加1 ；
            $this->sum -= $candidates[$i];
            array_pop($this->tmp);
        }
    }
}
$cand = [8,7,4,3];
$obj3 = new Solution3();
var_dump($obj3->combinationSum($cand,11));die;

/**
 * 全排列；
 * 不存在重复的问题；
 *  123
 */

class Solution4 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    // 不重复；没有重复元素
    //全排列 需要一个visited 访问过的元素

    public $res = []; // 这个不算space 因为要求返回一个数组 这不算是额外内存；
    public $tmp = []; // 6 const； // 常量space 空间； 并不是n的space
    public $visited = []; //  6 const // 常量space 空间；并不是n的space；

    function permute($nums) {
        $this->help($nums);
        return $this->res;
    }

    public function help($nums) {
        //end c
        $len = count($nums);
        if ($len == count($this->tmp)) {
            $this->res[] = $this->tmp;
            return;
        }

        // single level recursion
        for ($i = 0; $i <= $len - 1; $i++) {
            // exists //
            if ($this->visited[$nums[$i]]) continue;
            //not exists
            array_push($this->tmp,$nums[$i]);
            $this->visited[$nums[$i]] = 1;
            $this->permute($nums);
            array_pop($this->tmp);
            unset($this->visited[$nums[$i]]);
        }
    }
}

/**
 * 全排类2
 * // 存在重复元素；的全排列 怎么去去重的问题； 1123
 * 1123
 * 1123 是同一个排列 去重的问题；
 */
