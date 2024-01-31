<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:44
 */
/**
 * 其他的一些算法
 */

/**
 * 区间的问题
 * leetcode-1288. 删除被覆盖区间
 * // 先排序
 * /
 */


class Solution {

    /**
     * @param Integer[][] $intervals
     * @return Integer
     *
     */
    function removeCoveredIntervals($intervals) {
        usort($intervals,function ($a,$b) {
            if ($a[0] == $b[0]) {
                return $b[1] - $a[1]; // 相等的时候逆序排序
            }
            return $a[0] - $b[0]; // 顺序排序；
        });
//        var_dump($intervals);die;
        // 记录 合并起点的  // 合并的起点；
        $left = $intervals[0][0];
        $right = $intervals[0][1];

        $n = count($intervals);
        $res = $n; // 覆盖的区间
        for ($i = 1; $i < $n; $i++) {
            $invt = $intervals[$i]; //
            //1. 覆盖； 前面的覆盖
            // 第二个 线段的比较；
            // 第一个是否覆盖 第二个；因为 按照开始排序了，只能前面的覆盖后面的；
            // 覆盖删除
            //相等的时候逆序，是因为，当相同的时候 $right 不会发生变化；
            if ($left <= $invt[0] && $right >= $invt[1]) {
                $res--;
            }
            // 相交 合并 // 注意 invt[1] == $right   只在 right相交；合并
            if ($right >= $invt[0] && $right <= $invt[1]) {
                $right = $invt[1];
            }
            echo $left."--->".$right;
            echo "\n";
            // 不相交  区间不相交
            // 因为是左边界有序的！
            if ($right < $invt[0]) {
                $left = $invt[0];
                $right = $invt[1];
            }
        }
        return $res;
    }
}
$obj = new Solution();
// $intervals =  [[1,4],[3,6],[2,8],[2,7]];// 2
// $intervals = [[66672,75156],[59890,65654],[92950,95965],[9103,31953],[54869,69855],[33272,92693],[52631,65356],[43332,89722],[4218,57729],[20993,92876]];
$intervals = [[1,3],[3,8],[2,6]];//注意这里做排序了，肯定是，2肯定排在3前面；
echo $obj->removeCoveredIntervals($intervals);
