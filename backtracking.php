<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/10
 * Time 23:54
 */
/**
 * 回溯
 *
 * 应用场景；
 * 组合排列；
 * 子集； subset
 * 分割；
 * 棋盘；
 */

/**
 * Class ListNode
 * 2.list Node
 */

class ListNode
{
    public $val = 0;
    public $next = null;


    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}
//head 直接 指向的就是 头结点；
//变量名 其实就是一个地址；在php中 变量名 通过 active_symbol 转换成地址，进一步得到对象；
//  这里了解一下；
$head = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5)))));
$middle = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5, new ListNode(6))))));

/**
 * 链表倒叙遍历
 */

function reverseTraversal($head) {
    if ($head == null) return null;
    reverseTraversal($head->next);
    print($head->val);
}
//reverseTraversal($head);
/**
 *leetcode 77 组合问题；
 * 1234  大小是2的组合；
 */

/**
 * force question
 * 组合大小是2的组合；
 */
$combine = [1,2,3,4];
function combination2($combine) {
   $len = count($combine);
   for ($i = 0; $i < $len; $i++) {
       for ($j = $i+1; $j < $len; $j++) {
           echo $combine[$i].'--'.$combine[$j];
       }
   }
}
//combination2($combine);



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

/*
*
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
//$cand = [8,7,4,3];
//$obj3 = new Solution3();
//var_dump($obj3->combinationSum($cand,11));die;

/**
 * 全排列；
 * leetcode - 46
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
    //注意这种存储方式很不适合 有重复的时候建议用 [0,0,0,0]; 来代替
    public $visited = []; //  6 const // 常量space 空间；并不是n的space；

    function permute($nums) {
        $this->help($nums);
        return $this->res;
    }

    public function help($nums) {
        //end c
        $len = count($nums);
        //数组的大小 就是他的结束条件
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
            //nums存在于重复数据会存在问题;
            $this->visited[$nums[$i]] = 1;
            $this->permute($nums);
            array_pop($this->tmp);
            unset($this->visited[$nums[$i]]);
        }
    }
    // used 存储的数据类型不一样；
    function permute1($nums) {
        $this->helpmore($nums);
        return $this->res;
    }

    public function helpmore($nums) {
        //end c
        $n = count($nums);
        if (count($this->tmp) == $n) {
            $this->res[] = $this->tmp;
            return;
        }
        // 单层recus
        for ($i = 0; $i < $n; $i++) {
            // visited
            if ($this->visited[$i]) {
                continue;
            }
            array_push($this->tmp,$nums[$i]);
            // $i 第几个元素是否使用
            $this->visited[$i] = 1;
            $this->helpmore($nums);
            array_pop($this->tmp);
            unset($this->visited[$i]);
        }
    }
}

/**
 * 全排类2
 * leetcode -- 47
 * // 存在重复元素；的全排列 怎么去去重的问题； 1123
 * 1123
 * 1123 是同一个排列 去重的问题；
 * 有重复元素  去重的问题；
 * 同样的元素    不能用多次；只能用一次；
 */

class Solution47 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    public $res = [];
    public $tmp = [];
    public $used = [];

    function permuteUnique($nums) {
        //先要排序
        sort($nums);
        $this->help($nums);
        return $this->res;
    }

    function help($nums) {
        //end cond
        $n = count($nums);
        if (count($this->tmp) == $n) {
            $this->res[] = $this->tmp;
            return;
        }
        //recursion
        for ($i = 0; $i < $n; $i++) {
            // 就是剪层 不存在 第一次进入；
            // 第一个元素是0 有问题；// 注意；
            if ($nums[$i] === $nums[$i - 1] && !isset($this->used[$i - 1])) {
                continue;
            }

            // 被访问过了的  就不再访问了
            if (isset($this->used[$i])) {//注意0
                continue;
            }

            //
            array_push($this->tmp,$nums[$i]);
            $this->used[$i] = true;
            $this->help($nums);
            unset($this->used[$i]);
            array_pop($this->tmp);
        }
    }
}

//$arr47 = [3,3,0,3];
//$obj47 = new Solution47();
//var_dump($obj47->permuteUnique($arr47));die;


/**
 * leetcode -  78
 * 子集
 * 收获的结果 都是在每一个结点里面  每一个结点都会有结果；
 */
class Solution78 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    public $res = [];
    public $tmp = [];

    function subsets($nums) {
        $this->help($nums,0);
        return $this->res;
    }

    public function help($nums,$startIndex) {
        //每进入一个递归就是 一个结点； // 要放在前面
        $this->res[] = $this->tmp;
        //end cond
        $n = count($nums);
//        if ($startIndex >= $n) return; // 代码 可以不写；
        if (count($this->tmp) == $n) {
            //
//            $this->res[] = $this->tmp;
            return;
        }
//        $this->res[] = $this->tmp;

        //single level recursion
        for ($i = $startIndex; $i < $n; $i++) {
            array_push($this->tmp,$nums[$i]);
            $this->help($nums,$i + 1);
            array_pop($this->tmp);
        }
    }
}


///**
// * leetcode 101  分割等和子集
// * 这个  超过时间限制了；
// */
//class Solution101 {
//
//    /**
//     * @param Integer[] $nums
//     * @return Boolean
//     */
//    public $sum = 0;
//    public $res = false;
//    // sum = set1sum + set2sum;
//    //子集和；set1sum = set2sum = sum/2 //
//    //找target = sum/2的集合是否等于两个
//    //是奇数 直接淘汰；
//    //存在子集 等于$sum/2
//    function canPartition($nums) {
//        $sum = array_sum($nums);
//        if ($sum & 1) return false; //奇数
//        $target = $sum/2;
//        $this->help($nums, $target, $sum, 0);
//        return $this->res;
//    }
//
//    //找一个就行；
//    function help($nums, $target, $sum, $startIndex) {
//
//        $n = count($nums);
//        //end cond
//        if ($sum == $this->sum) {  // 没必要判断了； 因为另外一个是空数组；
//            return;
//        }
//
//        if ($this->sum == $target) {
//            $this->res = true;
//            return;// 没必要往下走了把；直接回退把；
//        }
//
//        for ($i = $startIndex; $i < $n; $i++) {
//            $this->sum += $nums[$i];
//            $this->help($nums,$target,$sum,$i + 1);
//            $this->sum -= $nums[$i];
//        }
//        //not found
//
//    }
//}
//
//$nums101 = [1,5,11,5];
//$obj101 = new  Solution101();
//var_dump($obj101->canPartition($nums101));die;

/**
 *  子集2
 * leetcode -- 90
 *  存在重复数组
 */

class Solution90 {

    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */


    public $res = [];
    public $tmp = [];
    public $used = [];

    function subsetsWithDup($nums) {
        sort($nums);
        $this->help($nums,0);

        return $this->res;
    }

    function help($nums,$startIndex) {
        // 结点
        $this->res[] = $this->tmp;
        //end c
        $n = count($nums);
        if ($startIndex >= $n) return;

        for ($i = $startIndex; $i < $n; $i++) {
            //这里是剪去分支；
            // if (isset($this->used[$nums[$i]])) continue;
            //是真的需要排序 吗的；
            if ($nums[$i] === $nums[$i - 1] && $this->used[$i -1 ] == false) continue;
            // for 循环代表的是 树的分支；可以判断要不要这个分支；
            $this->used[$i] = true;
            array_push($this->tmp,$nums[$i]);
            $this->help($nums,$i + 1);
            array_pop($this->tmp);
            unset($this->used[$i]);
        }
    }
}

/**
 * 40. 组合总和 II
 * 有重复的数组
 * leetcode -- 40
 */

class Solution40 {

    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    public $res = [];
    public $tmp = [];
    public $sum = 0;

    function combinationSum2($candidates, $target) {
        //sort
        sort($candidates);
        $this->help($candidates,$target,0);
        return $this->res;
    }

    function help($candidates,$target,$startIndex) {
        //end cond
//        var_dump($candidates);die;
        $n = count($candidates);
        //等于 结束
        //这样就可以了；
        if ($this->sum == $target) {
            $this->res[] = $this->tmp;
            return;
        }
        // 都要return；
//        if ($startIndex >= $n || $this->sum > $target) {
//            return;
//        }
        //为什么这里要删除 $startIndex  >= $n;就是整个就小于 $target;
        if ($startIndex >= $n || $this->sum > $target) return;

        //
        for ($i = $startIndex; $i < $n; $i++) {
            //去重；
            if ($candidates[$i] == $candidates[$i - 1] && $i > $startIndex) continue;
            //
            array_push($this->tmp,$candidates[$i]);
            $this->sum += $candidates[$i];
            $this->help($candidates,$target,$i + 1);
            $this->sum -= $candidates[$i];
            array_pop($this->tmp);
        }
//        return; //函数隐藏的回溯 ；；
    }
}
$arr40 = [2,5,2,1,2];
$obj40 = new Solution40();
var_dump($obj40->combinationSum2($arr40,5));die;
