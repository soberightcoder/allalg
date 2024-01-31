<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/10
 * Time 23:55
 */
/**
 * 动态规划；----> 状态转移！！！   
 * 很重要的一章节；
 * 1. dp数组以及下标的含义；都需要定义一个一维或者二维的数组；
 * 2. 递推公式；---比较重要；也就那么几种把；
 * 3. DP输入如何初始化；
 * 4. 遍历顺序；
 * 5. 打印dp数组；---debug---result 返回结果；--debug 时候一定要打印，debug数组；
 */

/*
 *基础 
 *  斐波那契数列
 * 112358;
 *  */
function fib($n) {
    //第i个dp数组数值,dp[i];
    //递推公式 dp[i] = dp[i-1] + dp[i+1];
    //初始化；
    //数组的初始化！
    $dp = [0,1];
    //遍历顺序，从前往后遍历；
    for ($i = 2; $i <=$n; $i++) {
        //要求第n个数值；
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
    }
    //打印dp数组；---怎么验证代码没有问题？
    // var_dump($dp);
    return $dp[$n];
}

// echo fib(4);

/**
 * @param Integer $n
 * @return Integer
 */
function fib1($n) {
    $mod = 1000000007;
    if ($n <=1) return $n;
    $a = 0; // 0
    $b = 1; //1
    for ($i = 2; $i <= $n; $i++) {
        $c = ($a + $b) % $mod; 
        $a = $b;
        $b = $c;
    }
    return $c;
}
/**
 * 最简洁的方法！
 */
function Fibonacci($n) {
    // write code here
    $a = 1;
    $b = 1;
    for ($i = 3; $i <= $n;$i++) {
        $c = $a + $b;
        $a = $b;
        $b = $c;
    }
    // $n = 1,2的时候，直接返回$b 会好一些；
    return $b;
}
/**
 * 爬楼梯的问题；
 * leetcode --- 70
 *  通项公式：f(n) = f(n-1) + f(n-2);
 * n的递推需要 n-1 和n-2来实现；
 * 通项公式：多去寻找 n和n-1之间的关系；
 * dp[$i]i的意义！！！
 * */

 function  climbStairs($n) {
    $dp = [1,2];
    for ($i = 2; $i < $n; $i++) {
        $dp[$i] = $dp[$i - 1] + $dp[$i -2];
    }
    //返回的时候，
    return $dp[$n - 1];
 }
 /**
  * 初始化要变得有意义
  * $dp[$i] $i 代表的是第i台阶需要的方法的！
  * 这样写会更好一些$dp[$i]会有意义！
  * $dp[0] 初始化没有意义；
  * 遍历顺序 从前往后遍历，因为n依赖于n-1和n-2所以我们应该从前往后遍历；
  */
 function climbStairs2($n) {
    // 0阶默认是1把；不用初始化了
    $dp = [1,1,2];
    for ($i = 3; $i <= $n; $i++) {
        $dp[$i] = $dp[$i - 1] + $dp[$i -2];
    }
    return $dp[$n];
 }
/**
 *  爬楼梯；
 */
 function climbStairs1($n) {
    //method 1 时间复杂度是2^n  空间复杂度是n
    // if ($n <= 2) return $n;
    // return $this->climbStairs($n - 2) + $this->climbStairs($n - 1);
    //method 2 时间复杂度是n  空间复杂度是n
    // $dp = [1,2];
    // for ($i = 2;$i < $n;$i++) {
    //     $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
    // }
    // return $dp[$n - 1];
    //method 3  时间复杂度是 n 空间复杂度是1
    if ($n <=2) return $n;
    $a = 1; //1
    $b = 2; //2
    for ($i = 3; $i <= $n; $i++) {
        $c = $a + $b;
        $a = $b;
        $b = $c;
    }
    return $c;
}
 
/**
 *leetcoe - 746最小花费爬楼梯问题；
 *求到台阶顶部的最小花费；
 * 跳跃的时候才会花费；
 * */

 function minCostClimbingStairs($cost) {
    //$dp数组的定义和意义
    //i台阶的最小花费代价；
    // 初始位置可以选择0或者1；所以两者全部为0；
    $dp = [0,0];
    //递推公式；
    $n = count($cost);//多少个台阶；
    //注意$i 的范围需要查看$dp中$i的代价；
    for ($i = 2;$i <= $n;$i++) {
       $dp[$i] = min($dp[$i - 1] + $cost[$i - 1],$dp[$i - 2] + $cost[$i - 2]);
    }
    return $dp[$n];
 }
//  echo minCostClimbingStairs([10,15,20]);


/**
 * leetcode-- 62 路径问题；不同路径1
 * 时间复杂度：O(nm)
 * 空间复杂度：O(nm) 即是为存储所有状态需要的空间；
 *  */ 

 function uniquePaths($m, $n) {
    //初始化$dp
    // 注意 $i  和 $j的意义！！！是图里面的位置，值是对应的是多少条不同的路径！
    //二维数组$dp[$i][$j]
    $dp = [];
    for ($i = 0;$i < $m;$i++) $dp[$i][0] = 1;
    for ($j = 0;$j < $n;$j++) $dp[0][$j] = 1;
    // 递推公式；
    for ($i = 1;$i < $m; $i++) {
        for ($j = 1;$j< $n;$j++) {
            $dp[$i][$j] = $dp[$i - 1][$j] + $dp[$i][$j - 1];
        }
    }
    return $dp[$m-1][$n-1];
 }
/**
 * leetcode --63 不同路径2 
 */

 function uniquePathsWithObstacles($obstacleGrid) {
      //
      $rows = count($obstacleGrid);
      $columns = count($obstacleGrid[0]);
      // start and end have obstacle
      if ($obstacleGrid[0][0] || $obstacleGrid[$rows-1][$columns-1]) {
          return 0;
      }
      //$dp[$i][$j] init
      for ($i = 0; $i < $rows && $obstacleGrid[$i][0] == 0 ;$i++) {
          $dp[$i][0] = 1;
      }
      for ($j = 0; $j < $columns && $obstacleGrid[0][$j] == 0; $j++) {
          $dp[0][$j] = 1;
      }
      //traverse
      for ($i = 1;$i < $rows; $i++) {
          for ($j = 1; $j < $columns; $j++) {
              if ($obstacleGrid[$i][$j] == 0) {
                  $dp[$i][$j] = $dp[$i - 1][$j] + $dp[$i][$j - 1];
              }
          }
      }
      //print dp array
      return $dp[$rows - 1][$columns - 1];
 }

 /**
  * 
  * 剑指 Offer II 099. 最小路径之和
  */
  
function minPathsSum($grip) {
    $n = count($grip); //rows 行号，$dp[$i][$j] 对应的是$i
    $m = count($grip[0]); //columns 列号，$j;
    $dp = [];
    //初始化；
    $p[0][0] = $grip[0][0];
    for ($i = 1;$i < $n;$i++) {
        $dp[$i][0] = $dp[$i - 1][0] + $grip[$i][0];
    }
    for ($j = 1; $j < $m;$j++) {
        $dp[0][$j] = $dp[0][$j -1] + $grip[0][$j];
    }
    //遍历顺序
    for ($i = 1; $i < $n;$i++) {
        for ($j = 1;$j < $m;$j++) {
            $dp[$i][$j] = min($dp[$i - 1][$j],$dp[$i][$j-1]) + $grip[$i][$j];
        }
    }
    return $dp[$n-1][$m-1];
}
// minPathsSum([[1,3,1],[1,5,1],[4,2,1]]);


/**
 * leetcode ---整数拆分；
 */
function integerBreak($n) {
    echo "ceshi";
}