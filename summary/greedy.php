<?php


/**
 * 什么是贪心算法：由局部最优来推算全局最优；
 *  贪心的两个极端？
 *  贪心的套路？ 无套路；
 */

 

 /**
  * 122. 买卖股票的最佳时机 II
  * 
  * 可以把股票的价格波动画出来，单调上升就是盈利，题解就是每一段单调上升的总和[doge]
   * 只收集每天的正利润；
   */

class Solution122 {

    /**
     * @param Integer[] $prices
     * @return Integer
     */
    function maxProfit($prices) {
        $result = 0;
        for ($i = 1; $i < count($prices); $i++) {
            $result += max($prices[$i] - $prices[$i - 1],0);
        }
        return $result;
    }
}

