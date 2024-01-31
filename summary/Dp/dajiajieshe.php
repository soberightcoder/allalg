<?php

/**
 *打家劫舍 
 *  */ 


/**
 * 198. 打家劫舍
 * 能偷的最大金币数量；
 * 当前的房间可以偷或者不偷，跟前面的几个房间偷不偷有关；
 * 动态的问题；
 *  */ 


 class Solution198 {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    
    function rob($nums) {
        // 偷到第i家的最大金币数；
        //dp数组 ，dp数组的含义；$i偷到$i(包含$i)家的最大金币数；$dp[$i]  $i 不一定偷；
        //$i 仅仅是我们考虑的范围； 最后一个元素并不一定会偷，仅仅是把最后一个元素考虑进去；并不一定会偷，这是整个$i的含义；
        //dp初始化；
        $dp[0] = $nums[0];
        $dp[1] = $nums[0] <= $nums[1] ? $nums[1] : $nums[0];
        
        // 遍历顺序；
        // 根据递推公式，我们一定要知道$dp[$i - 2] $dp[$i - 1]前面的状态，所以肯定是从前往后遍历；
        // 递推公式 就是第i 个房间 有可能会偷 也有可能不会偷；
        for ($i = 2; $i < count($nums); $i++) {
            //递推公式；   偷$i   
            //          之前所有房间偷的金币            不偷 i
            $dp[$i]  = max($dp[$i - 2] + $nums[$i],$dp[$i - 1]);
        }
        //打印要这么打印； 打印最后一个元素；
        return $dp[count($nums) - 1];

    }
}

/**
 * 213 打家劫舍
 * 分为三种情况来考虑： 
 * 1. 只考虑 首元素
 * 2. 只考虑尾元素；  考虑 首元素，但是并不一定，一定会偷首元素；
 * 3. 首元素和尾元素都不考虑；
 * 仅仅是考虑首元素或者尾元素，至于没有去偷首元素或者尾元素，要根据实际情况来计算；
 * 那么 1，2肯定是包含3这种情况；
 * 所以我们只需要考虑 情况1和情况2两种情况就好了；
 */




 class Solution213 {

    /**
     * @param Integer[] $nums
     * @return Integer
     */

    function rob($nums) {
        if (count($nums) == 0) return 0;
        if (count($nums) == 1) return $nums[0];
        // 保证下面的数组不为空数组；
        //最好的办法还是不要使用这种array_slice因为牵扯到数组的copy 所以 时间复杂度是O(n) 
        $left = $this->dp(array_slice($nums,0,-1));
        $right = $this->dp(array_slice($nums,1));
        //求两个的其中一个最大值就好了；
        return max($left,$right);
    }
    
    function dp($nums) {
        //dp数组 ，dp数组的含义；$i偷到$i(包含$i)家的最大金币数；$dp[$i]  $i 不一定偷；
        //$i 仅仅是我们考虑的范围； 最后一个元素并不一定会偷，仅仅是把最后一个元素考虑进去；并不一定会偷，这是整个$i的含义；
        //dp初始化；
        $dp[0] = $nums[0];
        $dp[1] = $nums[0] <= $nums[1] ? $nums[1] : $nums[0];
        
        // 遍历顺序；
        // 根据递推公式，我们一定要知道$dp[$i - 2] $dp[$i - 1]前面的状态，所以肯定是从前往后遍历；
        for ($i = 2; $i < count($nums); $i++) {
            //递推公式；   偷$i   
            //          之前所有房间偷的金币            不偷 i
            $dp[$i]  = max($dp[$i - 2] + $nums[$i],$dp[$i - 1]);
        }
        //打印要这么打印； 打印子最后一个元素；
        return $dp[count($nums) - 1];
    }

    function rob1($nums) {
        if (count($nums) == 0) return 0;
        if (count($nums) == 1) return $nums[0];
        // 保证下面的数组不为空数组；
        //最好的办法还是不要使用这种array_slice因为牵扯到数组的copy 所以 时间复杂度是O(n) 
        $left = $this->betterDp($nums,0,count($nums) - 2);
        $right = $this->dp($nums,1,count($nums) - 1);
        //求两个的其中一个最大值就好了；
        return max($left,$right);

    }
    //注意这边是左闭右闭；
    // 如果是左闭右闭怎么计算数组的长度；
    //这个时间复杂度会高很多；
    function betterDp($nums,$left,$right) {
        $dp[0] = $nums[$left];
        $dp[1] = $nums[$left] <= $nums[$left + 1] ? $nums[$left + 1] : $nums[$left];
        for ($i = 2; $i <= $left; $i++) {
            //递推公式；   偷$i   
            //          之前所有房间偷的金币            不偷 i
            $dp[$i]  = max($dp[$i - 2] + $nums[$i],$dp[$i - 1]);
        }
        //求数组的长度；
        
        //打印要这么打印； 打印子最后一个元素；
        return $dp[$right - $left];// 因为从0开始i；
    }

}

/**
 * 337. 打家劫舍 III
 * 树形dp；
 * 在二叉树中进行状态的转义；
 * 如何写 递推公式；
 *  */ 
/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
class Solution {

    /**
     * @param TreeNode $root
     * @return Integer
     */
    function rob($root) {
       $res = $this->treeRob($root);
       return max($res[0],$res[1]);
    }
    function treeRob($root) {
         //每一个节点$dp[0]代表的是不偷，$dp[1]代表的是偷； 分别代表的是 偷和不偷的最大值；
        if ($root == NULL) return [0,0]; // 

        //travese  后序遍历
        $leftDp = $this->treeRob($root->left);
        $rightDp = $this->treeRob($root->right);
        //递归公式；
        //偷；rootq去偷了，但是左右叶子节点肯定是没有偷的；
        $value1 = $root->val + $leftDp[0]  + $rightDp[0];
        //不偷    左节点偷不偷，看返回的数据 
        //cur 节点不偷 左右节点偷不偷都无所谓，选取最大值就好了；
        $value2 = max($leftDp[0],$leftDp[1]) + max($rightDp[0],$rightDp[1]);

        return [$value2,$value1];
    }
}
/**
 * extra-extends 
 * 已经知道数组的两个索引，怎么求数组的长度；
 * $length = $end - $start + 1;
 *  */ 

/****
 * 
 * 如果一个数组的两个索引是左闭右闭；如何计算数组的长度；
 * $l = x $r = y;
 *  y - x + 1;
 *  */ 
