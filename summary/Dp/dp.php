<?php

/**
 * 动态规划；
 */

/**
 * 基础知识  动态规划； --- 状态转移;
 * Dp 主要是要处理哪几类问题？
 * 动态基础题型：斐波那契数列， 爬楼梯,背包问题，打家劫舍，股票问题，子序列问题；
 * 最短路径的问题？？是 Dp 问题吗？
 */


/**
 * 
 * 本质解题步骤:五步曲；
 * dp数组(数组有可能是一维的，也有可能是二维的；$dp[$i][$j])以及下标的含义； 
 * 递归公式； --- 很重要；
 * dp数组如何初始化？
 * 遍历顺序；---在背包问题中很重要； 从前到后，还是从后到前；
 * 打印dp数组；--- 用来debug；dp数组有问题，一般代码就有问题；
 *  */

/**
 * total:
 * 今天做到打家劫舍；
 */

/**
 * 509 斐波那契数列
 * 第n个斐波那契数是多少？
 *  */

class Solution509
{

    /**
     * @param Integer $n
     * @return Integer
     */
    // 2^n的时间复杂度； 树的高度是n 并且每一层的时间复杂度最高的是也是n
    // 1 + 1*2 + 1*2^2   + 2^n  ===等比数列，时间复杂度就是2^n  
    // 使用递归的方式；
    // function fib($n) {
    //     if ($n == 0 || $n == 1) return $n;
    //     return $this->fib($n - 1) + $this->fib($n - 2);
    // }

    //这个时间复杂度是O(n)
    function fib($n)
    {
        // dp数组和初始化部分；
        // i 代表的是斐波那契数列的值；
        $dp = [0, 1];
        // 遍历 从前往后遍历
        for ($i = 2; $i <= $n; $i++) {
            //递归公式；
            $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
        }
        //dp数组
        return $dp[$n];
    }
}

/**
 * 70. 爬楼梯
 *  */

class Solution
{

    /**
     * @param Integer $n
     * @return Integer
     */
    // function climbStairs($n) {
    //     //end cond
    //     if ($n == 1 && $n == 2) return $n;
    //     return $this->climbStairs($n - 2) + $thi->climbStairs($n - 1);
    // }

    function climbStairs($n)
    {
        //end cond
        //dp数组，和dp数组的初始化； i代表i阶你有多少种爬到楼听的方式；
        $dp[1] = 1;
        $dp[2] = 2;
        //遍历顺序也是从前到后；
        for ($i = 3; $i <= $n; $i++) {
            //递归公式
            $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
        }
        return $dp[$n];
    }
}

/**
 * 746. 使用最小花费爬楼梯
 * 递归公式 就是状态转义方程；
 *  */

class Solution746
{

    /**
     * @param Integer[] $cost
     * @return Integer
     */
    function minCostClimbingStairs($cost)
    {
        $n = count($cost);
        //dp数组初始化，和$i的含义；到$i阶梯的最小费用；//注意到$dp[$i] 需要$dp[$i - 1] 跳一次； + $dp[$i -2 ]跳跃的花费；
        $dp[0]  =  0;
        $dp[1]  =  0;
        //$i <= count($cost);   
        //带进入一个值 测试一下；当 $cost[$i] 第i阶台阶向上爬取需要支付的费用；
        // $cost = [10,15,20]; 
        for ($i = 2; $i <= count($cost); $i++) {
            //递归公式  怎么写？ 递归公式没有搞出来；
            //递归公式；
            $dp[$i] = min($dp[$i - 1] + $cost[$i - 1], $dp[$i - 2] + $cost[$i - 2]);
        }
        return $dp[$n];
        // var_dump($dp);  
        // return end($dp);// end 使用完，最好还是使用reset(); 给重置就好了；
    }
}
// $obj746 = new Solution746;
// echo $obj746->minCostClimbingStairs([10,15,20]);

/**
 * 
 * 62. 不同路径
 */

class Solution62
{

    /**
     * @param Integer $m
     * @param Integer $n
     * @return Integer
     */
    function uniquePaths($m, $n)
    {
        //$m= $n = 1;
        //dp数组；
        //$dp[$i][$j]  $i $j 分别代表到$i,$j 的不同路径；  到那边只有一种方法，所以都是1； 注意这一点；
        for ($i = 1; $i <= $m; $i++) {
            $dp[$i][1] = 1;
        }
        for ($j = 1; $j <= $n; $j++) {
            $dp[1][$j] = 1;
        }

        for ($i = 2; $i <= $m; $i++) {
            for ($j = 2; $j <= $n; $j++) {
                //递归公式
                $dp[$i][$j] = $dp[$i - 1][$j] + $dp[$i][$j - 1];
            }
        }
        //打印 
        return $dp[$m][$n];
    }
}

// $obj62 = new Solution62();
// echo $obj62->uniquePaths(3,7);

/**
 * 
 * 63. 不同路径 II
 *  */

class Solution63
{

    /**
     * @param Integer[][] $obstacleGrid
     * @return Integer
     */
    function uniquePathsWithObstacles($obstacleGrid)
    {
        //$m 代表的是i行; $n 代表的是列；
        //$dp   数组  代表的是位置；
        //行；
        $m = count($obstacleGrid); //
        //列；
        $n = count($obstacleGrid[0]); //列
        // 起始和终止位置有障碍 直接为0；
        if ($obstacleGrid[0][0] == 1 && $obstacleGrid[$m - 1][$n - 1]) return 0;
        //因为只能往下和往右移动 ，所以 
        //dp数组的初始化 
        for ($i = 0; $i < $m; $i++) {
            $dp[$i][0] = 0;
        }
        for ($j = 0; $j < $n; $j++) {
            $dp[0][$j] = 0;
        }
        // 障碍物后面的全部是0；
        for ($i = 0; $i < $m && $obstacleGrid[$i][0] == 0; $i++) {
            $dp[$i][0] = 1;
        }
        for ($j = 0; $j < $n && $obstacleGrid[0][$j] == 0; $j++) {
            $dp[0][$j] = 1;
        }
        //障碍物 也变为0；//因为前面没有对整个dp初始化为0，所以需要把障碍物变为0；
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($obstacleGrid[$i][$j] == 1) {
                    $dp[$i][$j] = 0;
                }
            }
        }
        // var_dump($dp);die;
        // 障碍物肯定是0
        //也是要做初始化；
        //遍历顺序 从左到右 ，从上 到下；
        //因为数组$arr[$i - 1]  // 所以 $i 要从1开始计数，这个也是一个根据；
        //也是因为 $i = 0; 和$j = 0 ;都已经做了初始化了；所以都从1开始；
        for ($i = 1; $i < $m; $i++) {
            for ($j = 1; $j < $n; $j++) {
                if ($obstacleGrid[$i][$j] == 0) {
                    $dp[$i][$j] = $dp[$i][$j - 1] + $dp[$i - 1][$j];
                }
            }
        }
        return $dp[$m - 1][$n - 1];
    }
}

// $obj63 = new Solution63();
// echo $obj63->uniquePathsWithObstacles([[0,0,0],[0,1,0],[0,0,0]]);


/**
 * 343. 整数拆分
 * 为了保证拆分后的乘积最大，那么我们尽可能的拆分成近似相等的数；
 * 数值近似相等，那么相乘的乘积才会是最大；
 * 整个先不做了，考虑一下背包问题；
 */



/**
 * 0-1 背包问题；--- 很重要；
 * 完全背包 这两个背包 搞清楚就可以了；
 * 一定要明白整个问题，一维数组，是对二维数组的压缩，所以他是一个滚动的数组，为什么要使用倒叙，以及遍历的顺序，都可以使用一维数组是从1为数组那边压缩过来的来解释；
 */

/**
 * 01 背包一定要理解透彻；
 * 物品n个，每一个物品只有一个，有一个只可以装m的背包，装包背包，整个背包的总价值；
 *  */
/**
 *01背包问题是一个经典的组合优化问题，通常用动态规划算法来解决。该问题描述如下：有一个背包，最大承重为W，现有n个物品，每个物品的重量为w[i]，价值为v[i]。要求选择一些物品放入背包，使得背包中物品的总重量不超过W，且价值最大。

 *因此，01背包问题是要在给定的物品集合中，选择不超过背包承重限制的物品，使得这些物品的总价值最大化。这是一个经典的组合优化问题，可以通过动态规划算法高效地求解。 
 *  */
/**
 *      重量    价值
 *物品0   1      15
 *物品1   3      20
 *物品2   4      30
 * 背包的最大重量是4  求装满整个背包的最大价值；
 */

/**
 * 可以使用回溯暴力求解，因为每一个物品都会有两种状态，取这个物品，或者不取这个物品，列举出所有的情况；
 * 所以时间复杂度是 2^n;
 *  */

/**
 * code---dp动态规划；
 * $dp 数组的定义 -- 二维dp数组-- $dp[$i][$j] 整个数组的含义是：任意取放[0-$i]个物品，背包容量是$j的最大价值；
 * [0-$i]物品，任取放在容器$j的背包；$j 是代表背包的容量；
 * 递推公式：
 */

class BagProblem
{
    public function main()
    {
        $weight = [1, 3, 4];
        $value = [15, 20, 30];
        $bagSize = 4;
        return $this->testBagValue($weight, $value, $bagSize);
    }

    function testBagValue($weight, $value, $bagSize)
    {
        // 行；
        $m = count($weight);
        $n =  $bagSize + 1; // 多少列；//因为从0开始；
        //$dp二维数组 $i 代表的是$i物品， $j 代表的是背包的容量；
        //小于等于2 就是物品数量；
        // $dp 数组的初始化；
        for ($i = 0; $i < $m; $i++) {
            //注意这边初始化，列是重量bagSize
            for ($j = 0; $j < $n; $j++) {
                //起始这里初始化，根据递推公式，跟$dp[$i][$j] 本身是没有任何关系的，所以初始化赋啥值都是可以的；
                $dp[$i][$j] = 0;
            }
        }
        //$i = 0;$i 代表的是物品，$j代表的是背包的容量；
        // for ($j = 0; $j < $n; $j++) {
        //     // 物品$i的重量 小于背包的容量，那么就代表可以放到背包里去；
        //     if ($weight[0] <= $j) {
        //         $dp[0][$j] = $value[0];
        //     } else {
        //         $dp[0][$j] = 0;
        //     }
        // }
        //上面的初始化可以变化成下面这种；
        // 从等于重量开始 直到最后面；
        for ($j = $weight[0]; $j < $n; $j++) {
            $dp[0][$j] = $value[0];
        }
        // print_r($dp);die;
        //遍历顺序  --- 从左到右 ，从上到下；
        //为什么二维数组的dp遍历顺序无所谓呢？？？
        //因为求$dp[$i][$j] 只需要知道 左上边的值$dp[$i - 1][$j - $weight[$i]]，和 上面的值$dp[$i -1][$j]就可以了；所以无论先遍历哪一个都无所谓；
        for ($i = 1; $i < $m; $i++) {
            for ($j = 1; $j < $n; $j++) {
                // 递推公式；不放i物品               放i物品 放i物品 要 减去重量  + 价值；
                if ($j < $weight[$i]) {
                    $dp[$i][$j] = $dp[$i - 1][$j];
                } else {
                    //能装进去 但是可以不装；注意这边；--- 会有两种选择，选择出价值最大的那种；
                    $dp[$i][$j] = max($dp[$i - 1][$j], $dp[$i - 1][$j - $weight[$i]] + $value[$i]);
                }
            }
        }
        //打印$dp
        return $dp[$m - 1][$n - 1];
    }
}
// $obj = new BagProblem();
// echo $obj->main();

/**
 * 用一维数组来实现背包；是一个滚动数组，自己拷贝自己的值；就是更新的这个值，跟自己的值是有关的；所以初始化一定要注意；
 * dp[j] 容量j的背包装的最大价值；数组的整个含义和j索引的含义；
 * 递推公式：      没有放$i物品         放了$i物品；
 * $dp[$j] = max[$dp[$j],$dp[$j - $weight[$i]] + $value[$i]]
 * $dp 数组的初始化；
 * $dp[0] = 0;
 * 因为不可能为负数，所以初始化为非负数最小值就可以了，就是0；
 * //遍历顺序
 * //物品做正序遍历
 * for ($i = 0; $i < 物品数目；$i++) {
 * // 背包的容量，来做反向遍历
 *      for ($j = $bagSize;$j >= $weight[$i]; $j++) {
 * }
 * }
 *  */


class BagProblem2
{
    public function main()
    {
        $weight = [1, 3, 4];
        $value = [15, 20, 30];
        $bagSize = 4;
        return $this->testBagValue($weight, $value, $bagSize);
    }

    function testBagValue($weight, $value, $bagSize)
    {
        //行  行列都是长度；
        $m = count($weight);
        //列
        $n = $bagSize;
        //一维数组dp的含义是背包容量是$j的最大价值； $j 代表的是背包的容量;
        //dp arr init 根据递推公式，可以选择 最小的非负数就可以了；
        for ($j = 0; $j <= $n; $j++) {
            $dp[$j] = 0;
        }
        //遍历
        //物品的遍历   ---- 先遍历 物品也是因为这是一个滚动数组；
        // 因为是一个滚动数组，所以只能先去遍历物品；
        // 先形成 $i = 0 物品的滚动数组；
        for ($i = 0; $i < $m; $i++) {
            // 背包大小的遍历顺序 从大到小；
            for ($j = $n; $j >= $weight[$i]; $j--) {
                //递推公式；
                //这便是一个滚动数组；
                //根据递归公式 当前的$dp[$j] 跟$dp[$j - $weight[$i]] 有关，所以$dp最好还是从后面更新，这样才会不出错；
                $dp[$j] = max($dp[$j], $dp[$j - $weight[$i]] + $value[$i]);
                //else  $dp[$j] = $dp[$]//就不用更新了，也可以用上面二维数组的概念；
            }
        }
        return $dp[$n];
    }

    //对遍历顺序中的，背包容量来做一个顺序遍历；
    //会发现每一个物品会用到很多次；
    public function main1()
    {
        $weight = [1, 3, 4];
        $value = [15, 20, 30];
        $bagSize = 4;
        return $this->testBagValue1($weight, $value, $bagSize);
    }

    function testBagValue1($weight, $value, $bagSize)
    {
        //行  行列都是长度；
        $m = count($weight);
        //列
        $n = $bagSize;
        //一维数组dp的含义是背包容量是$j的最大价值； $j 代表的是背包的容量;
        //dp arr init 根据递推公式，可以选择 最小的非负数就可以了；
        for ($j = 0; $j <= $n; $j++) {
            $dp[$j] = 0;
        }
        //遍历
        //物品的遍历   ---- 先遍历 物品也是因为这是一个滚动数组；
        // 因为是一个滚动数组，所以只能先去遍历物品；
        // 先形成 $i = 0 物品的滚动数组；
        for ($i = 0; $i < $m; $i++) {
            // 背包大小的遍历顺序 从大到小；
            for ($j = 0; $j <= $n; $j++) {
                //递推公式；
                //这便是一个滚动数组；
                //根据递归公式 当前的$dp[$j] 跟$dp[$j - $weight[$i]] 有关，所以$dp最好还是从后面更新，这样才会不出错；
                if ($j >= $weight[$i]) { //容量大于他的重量，那么就可以装这个物品；
                    $dp[$j] = max($dp[$j], $dp[$j - $weight[$i]] + $value[$i]);
                }
                // } else {
                //     //可以不用写，这部分就是省略的内容；
                //     $dp[$j] = $dp[$j];
                // }
                //else  $dp[$j] = $dp[$]//就不用更新了，也可以用上面二维数组的概念；
            }
        }
        return $dp[$n];
    }
}
// $obj2 = new BagProblem2();
// // echo $obj2->main();die;
// echo $obj2->main1();die;//顺序遍历

/**
 * 416. 分割等和子集
 * //就是一个子集是一半是不是；
 *  */
class Solution416
{

    /**
     * @param Integer[] $nums
     * @return Boolean
     */

    /**
     * 主要是找那几值；
     * 物品种类  $m  = count($nums)
     * 背包的容量  $n  = $sum/2
     * weight  $nums
     * value   $nums
     * ##----------------------------------------------------------------------------------
     * 背包的体积为sum / 2
     * 背包要放入的商品（集合里的元素）重量为 元素的数值，价值也为元素的数值
     * 背包如果正好装满，说明找到了总和为 sum / 2 的子集。
     * 背包中每一个元素是不可重复放入。
     * ##-----------------------------------------------------------------------------------
     */
    function canPartition($nums)
    {
        $sum = 0;
        //行 也是  weight 或者value 数组的长度；
        $m = count($nums);
        // 求和；
        for ($i = 0; $i < $m; $i++) {
            $sum += $nums[$i];
        }
        // 判断是奇数；
        if ($sum & 1)  return false;
        $n = $sum / 2; //这个就是背包的容量； 
        //$nums既是价值 也是重量；
        //$dp[j] 数组的含义，就是容量是$j（$j容量，并不一定被填满了）的最大值；最大值一般就是$j ；当然也说不定没有被填满 所以下面要做判断；是否等于他的容量，如果不等于还是false；就是最后的结果判断；
        //$dp数组的初始化；$j 代表的是背包容量是$j背包的价值；
        for ($j = 0; $j <= $n; $j++) { //注意这里是从0开始到背包容量；
            $dp[$j] = 0;
        }

        //遍历公式
        for ($i = 0; $i < $m; $i++) {
            for ($j = $n; $j >= $nums[$i]; $j--) {
                // 递推公式；
                $dp[$j] = max($dp[$j], $dp[$j - $nums[$i]] + $nums[$i]);
            }
        }
        //打印
        // 因为这里是背包的最大值？？？ 
        if ($dp[$n] == $n) return true;
        return false;
    }
}


// $obj416 = new Solution416();
// $obj416->canPartition([1, 2, 3, 5]);

/**
 * 1049. 最后一块石头的重量 II
 */
class Solution1049
{

    /**
     * @param Integer[] $stones
     * @return Integer
     */
    // 同样是，分成两堆，如果两堆之间的差最小就可以了；
    //就是两个子集的最小差值；
    function lastStoneWeightII($stones)
    {
        $m = count($stones);
        $sum = 0;
        for ($i = 0; $i < $m; $i++) {
            $sum += $stones[$i];
        }
        // 没有石头剩下；
        if ($sum & 1 == 0) return 0;
        $n = $sum >> 1;

        //$dp 数组$j容量是$j的背包能装的最大价值；

        //dp arr init
        for ($j = 0; $j <= $n; $j++) {
            $dp[$j] = 0;
        }

        //traverse
        for ($i = 0; $i < $m; $i++) {
            for ($j = $n; $j >= $stones[$i]; $j--) {
                //递推公式--- 重量就是他的价值吗？
                $dp[$j] = max($dp[$j], $dp[$j - $stones[$i]] + $stones[$i]);
            }
        }

        //打印；//注意返回的结果；
        return $sum - $dp[$n] - $dp[$n];
    }
}

/**
 * 494. 目标和
 *  */

class Solution94
{

    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function findTargetSumWays($nums, $target)
    {
        //它的价值 由两部分来组成一个是$nums  一个是符号位；

        // 背包容量是$target 都是一样的，这里是+ 或者- 而背包问题是取或者不取；所以这里表达式会发生改变；

        $m = count($nums); // 行 物品数量；

        $n = $target; // 背包容量；

        //dp数组 代表的是背包容量是j的方法种类;

        //递推公式  --- 这个题递推公式肯定发生改变了； 
        //加法一个集合 减法一个集合；那么left 加法集合，right 减法集合；
        //left + right = sum;  ==》 right = sum -left 带入下面的公式；
        //left - right = target ==》 left -sum + left = target ==> left = (sum + target)/2 主要是正数的集合sum 是sum + target /2 就可以了；背包大小就是这个；这些全部都是正数，剩下的全部都是负数；

        //dp[$j] 含义 装满$j背包共有多少种方法？

        //递推公式   本题还是有点难度，大家也可以记住，在求装满背包有几种方法的情况下，递推公式一般为：

        //dp[j] += dp[j - nums[i]];


    }
}

/**
 * 完全背包的理论基础；
 * 完全背包和01背包的区别就是：完全背包，每一个物品可以使用无数次，而01背包每一个物品只能使用一次；
 * 完全背包和物品容量的遍历顺序是无关的！！！1
 * 
 *  */
class FullBagProblem
{
    public function main()
    {
        $weight = [1, 3, 4];
        $value = [15, 20, 30];
        $bagSize = 4;
        return $this->testBagValue($weight, $value, $bagSize);
    }

    /**
     * $m 就是物品的个数；
     * $n 就是背包的容量；
     * $weight   很多时候价值和  重量都是一个数组，甚至是某个数的值；
     * $value
     * 
     *  */
    function testBagValue($weight, $value, $bagSize)
    {
        //行  行列都是长度；
        $m = count($weight);
        //列
        $n = $bagSize;
        //一维数组dp的含义是背包容量是$j的最大价值； $j 代表的是背包的容量;
        //dp arr init 根据递推公式，可以选择 最小的非负数就可以了；
        for ($j = 0; $j <= $n; $j++) {
            $dp[$j] = 0;
        }
        //遍历
        //物品的遍历   ---- 先遍历 物品也是因为这是一个滚动数组；
        // 因为是一个滚动数组，所以只能先去遍历物品；
        // 先形成 $i = 0 物品的滚动数组；
        for ($i = 0; $i < $m; $i++) {
            // 背包大小的遍历顺序 从大到小；
            //可以有重复元素；
            for ($j = 0; $j <= $n; $j++) {
                //递推公式；
                //这便是一个滚动数组；
                //根据递归公式 当前的$dp[$j] 跟$dp[$j - $weight[$i]] 有关，所以$dp最好还是从后面更新，这样才会不出错；
                if ($j >= $weight[$i]) {
                    $dp[$j] = max($dp[$j], $dp[$j - $weight[$i]] + $value[$i]);
                }

                //else  $dp[$j] = $dp[$]//就不用更新了，也可以用上面二维数组的概念；
            }
        }
        return $dp[$n]; //确实 最大的是 60；
    }

    public function main1()
    {
        $weight = [1, 3, 4];
        $value = [15, 20, 30];
        $bagSize = 4;
        return $this->testBagValueTest($weight, $value, $bagSize);
    }

    function testBagValueTest($weight, $value, $bagSize)
    {
        //行  行列都是长度；
        $m = count($weight);
        //列
        $n = $bagSize;
        //一维数组dp的含义是背包容量是$j的最大价值； $j 代表的是背包的容量;
        //dp arr init 根据递推公式，可以选择 最小的非负数就可以了；
        for ($j = 0; $j <= $n; $j++) {
            $dp[$j] = 0;
        }
        //遍历
        //物品的遍历   ---- 先遍历 物品也是因为这是一个滚动数组；
        // 因为是一个滚动数组，所以只能先去遍历物品；
        // 先形成 $i = 0 物品的滚动数组；
        for ($j = 0; $j <= $n; $j++) {
            for ($i = 0; $i < $m; $i++) {
                // 背包大小的遍历顺序 从大到小；
                //可以有重复元素；

                //递推公式；
                //这便是一个滚动数组；
                //根据递归公式 当前的$dp[$j] 跟$dp[$j - $weight[$i]] 有关，所以$dp最好还是从后面更新，这样才会不出错；
                if ($j >= $weight[$i]) {
                    $dp[$j] = max($dp[$j], $dp[$j - $weight[$i]] + $value[$i]);
                }

                //else  $dp[$j] = $dp[$]//就不用更新了，也可以用上面二维数组的概念；
            }
        }
        return $dp[$n]; //确实 最大的是 60；
    }
}

$obj3 = new FullBagProblem();
echo $obj3->main();


/**
 * 
 * php中 >> 1  才是除以2 傻逼 --- >> 1 === /2
 */

/**
 * 01背包解决的是，装满这个背包的最大价值是多少！！！ 当然 这个背包不一定会被装满，需要注意；也有可能达到了最大价值；
 *  */

/**
 * 解决背包的遍历顺序问题；
 * 递归公式的核心；
 * 我大概悟了；就是每次打算放一个东西时，首先要考虑它放不放得下，放不下的话就直接不放；放得下的话，就要看放他划算还是不放它划算
 * 最大价值 起始就是当前情况下的最优解；
 * 下面的单元格都是 当前条件下的最优解；记住整个东西；
 * 注意$dp的最右下角是他的最优解；
 *  */

/**
 * 遍历顺序问题；
 *         weight   value
 *  good0     1      15
 *  good1     3      20
 *  good2     4      30
 *  bagSize = 4;
 * // 01 背包；--- 二维数组dp；
 * // 二维数组$dp[$i][$j] ==> 任意取放p[0-$i]个物品（每一个物品只能用一次），背包的容量是$j,求装满背包的最大价值；
 * $i 代表的是任意[0-$i]个元素取放；
 * $j 背包的容量； 
 * 递推公式  --- 
 *   //遍历 物品；
 *  for ($i = 0; $i < $m;$i++) {
 *     // 遍历容量；
 *    for ($j = 0; $j < $n;$j++) {
 *     if ($j >= $weight[$i])  $dp[$i][$j] = $dp[$i - 1][$j];
 *                            // 不放入i也就是价值并没有发生改变；       放入i 那么肯定价值和容量发生了改变；
 *     else $dp[$i][$j] = max($dp[$i -1][$j],$dp[$i - 1][$j - $weight[$i]] + $value[$i]);
 * }
 * }
 * 遍历顺序
 * //1 先遍历物品 然后遍历容量；
 *  $i  $j 0  1  2  3  4   == bagsize背包的容量；
 *  good0  0  15 15 15 15  --- dp arr init
 *  good1  0  15 15 20 35 //  
 *  good2  0  15 15 20 35  // 35 
 *        init
 * 
 *遍历顺序
 * //1 容量 然后遍历 物品  就是
 *  $i  $j 0  1  2  3  4   == bagsize背包的容量；
 *  good0  0  15 15 15 15  --- dp arr init
 *  good1  0  15 15 20 35
 *  good2  0  15 15 20 35
 *        init 
 * 
 * ###------------------------------------------------------------------------------------------------------------------------------
 * //单位数组的遍历顺序，因为是一个滚动数组 起始可以展开看成一个二维数组；
 *  递推公式---这个递推公式可以实现的条件就是 背包容量可以装$weight[$i]
 * - $dp[$j] = max($dp[$j],$dp[$j - $weight[$i]] + $value[$i]]; //就是从二维数组压缩来的；所以要了解的话，先去仔细了解一下二维数组的实现把；
 *  遍历顺序
 * for($i = 0; $i < $m; $i++)  // 物品要做正向遍历？？？
 * for ($j = $bagSize;$j >= $weight[$j];$j--)  //  为什么容量要做倒叙遍历？？？
 * 遍历顺序---
 * //1 先遍历物品 ，然后逆序遍历容量；
 *  $i  $j 0  1  2  3  4   ==> bagSize背包的容量；
 *  init   0  0  0  0  0    init arr dp？？  因为初始化 跟自身有关，所以直接取0就可以了；0本身就是非负的最小值；所以并不会对结果产生影响；
 *  good0  0 15 15 20 35
 *  good1  0 15 15 20 35
 *  good2  0 15 15 20 35
 * 
 * 
 * 容量逆序顺序  $i 代表的是前$i种都可以选择，达到容量最大就行了；
 * //1 先遍历物品，然后正序遍历容量；
 *  
 *  $i  $j 0  1  2  3  4   == bagsize背包的容量；
 *  init   0  0  0  0  0
 *  good0  0 15 30 45 60      这里已经出问题了，当正序遍历的时候，$dp[2] = 30;也就是物品重复使用了；
 *  good1  0 15 30 45 60
 *  good2  0 15 30 45 60       
 * #------------------------------------------------------------------------------
 *  
 * // 完全背包--- 也就是 每一个物品可以重复放入；--完全背包先遍历物品或者先遍历容量，都是可以的；
 *
 *   遍历顺序容量是正序的  $i 代表的是前$i种都可以选择，达到容量最大就行了；
 * //1 先遍历物品，然后正序遍历容量；
 *  
 *  $i  $j 0  1  2  3  4   == bagsize背包的容量；
 *   init  0  0  0  0  0
 *  good0  0  15 30 45 60
 *  good1  0  15 30 45 60 
 *  good2  0  15 30 45 60
 *  
 *  
 *  //先遍历容量然后遍历物品 他会有影响吗？
 * 
 *  $j $i  0  1  2  3  4   == bagsize背包的容量；
 *   init  0  0  0  0  0
 *  good0  0  15 30 45 60
 *  good1  0  15 30 45 60
 *  good2  0  15 30 45 60
 * 
 */
