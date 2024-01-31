<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/1/11
 * Time 12:17
 */


/**
 * 快排问题
 * pivot 随机选择，不然有序数组或者逆序数组的时间复杂度会变高；
 */


class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     * // 快排问题
     */

    function sortArray($nums) {
        $l = 0;
        $r = count($nums) - 1;
        $this->process($nums, $l, $r);
    }

    function process(&$nums, $l, $r) {
        // p[0] lessR 小于分区的右边   p[1] moreL //大于分区的左边
        if ($l >= $r) return;
        //分区来做分区；
        $p = $this->partition($nums, $l, $r);

        $this->process($nums, $r, $p[0]);
        $this->process($nums, $p[1], $r);
    }

    /**
     * 三路快排  +  随机povit
     * 三路快排
     */
    function partition(&$nums, $l, $r) {
        //随机分区cddd  sss点
        $pivot = rand($l, $r - 1);
        //随机pivot 和最后元素 交换
        $this->swap($nums[$pivot], $nums[$r]);
        //分区点 交换之后 还是最后一个;
        $divide = $r;
        $moreL = $r; // 已经排序大于分区值的左边
        $lessR = $l - 1; //已经排序小于分区值的右边
        $index = $l;
        //
        while ($index < $moreL) {
            if ($nums[$index]  > $nums[$divide]) {
                // index
                // 加入到 右边；
                $this->swap($nums[$moreL - 1], $nums[$index]);
                $moreL--;
            } else if ($nums[$index] < $nums[$divide]) {
                // 加入到 左边;
                $this->swap($nums[$index] , $nums[$lessR + 1]);
                $lessR++;
                $index++;
            } else {
                $index++;
            }
        }
        //
        $this->swap($nums[$divide], $nums[$moreL]);
        $moreL++;

        //
        return [$lessR, $moreL];
    }

    function swap(&$val, &$val2) {
        [$val, $val2] = array($val2, $val);
    }
}



class Solution1 {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     * // 快排问题
     * 随机分区点 ；
     * 重复元素的排序；
     */

    function sortArray($nums) {
        $l = 0;
        $r = count($nums) - 1;
        $this->process($nums, $l, $r);
        return $nums;
    }

    function process(&$nums, $l, $r) {
        // end condition
        if ($l >= $r) return null;// 当只有一个元素的时候 结束递归；
        $p = $this->partition($nums, $l, $r);
        $this->process($nums, $l, $p[0]);
        $this->process($nums, $p[1], $r);
    }

    // 三路快排
    // 主要是分为三部分 大于 分区点小于分区点和等于分区点 三个部分；
    function partition(&$nums, $l, $r) {
        // 先不随机 先选择最后一个元素作为分区点
        // 这边会有问题，当数组是逆序或者是顺序的再排序的时候时间复杂度会很高，达到了O(n^2)的时间复杂度；
        $randomkey = rand($l, $r);
        // 和最后一个做交换；
        $this->swap($nums[$randomkey], $nums[$r]);
        // 然后还是用最后一个元素来做分区点 但是已经是随机分区点了；
        $pivot = $r;
        //
        $moreL = $r;
        $lessR = $l - 1;
        //索引 从 $l  开始
        $index = $l;

        while ($index < $moreL) {
            if ($nums[$index] > $nums[$pivot]) {
                //大于 放在后面
                $this->swap($nums[$moreL - 1], $nums[$index]);
                $moreL--;
            } else if ($nums[$index] < $nums[$pivot]) {
                $this->swap($nums[$index], $nums[$lessR + 1]);
                $index++;
                $lessR++;
            } else {
                $index++;
            }
        }


        //分区点要移动到等于他的位置
        $this->swap($nums[$moreL], $nums[$pivot]);
        $moreL++;
        //
        return [$lessR, $moreL];
    }

    function swap(&$val, &$val1) {
        [$val, $val1] = array($val1, $val);
    }
}
//$arr1 = [5,2,3,1];
//$obj1 = new Solution1();
//var_dump($obj1->sortArray($arr1));die;

/**
 * Class Solution2
 * 堆排序利用了 splMInheap 小顶堆；
 */
class Solution2 {

   function sortArray($nums)  {
        $minhead = new SplMinHeap();
       //创建堆 但是这种时间复杂度 偏高
       // nlogn
        foreach ($nums as $num) {
            $minhead->insert($num);
        }
        // 排序
       $ret = [];
        while (!$minhead->isEmpty()) {
            $ret[] = $minhead->extract();
        }
        return $ret;
   }
}
//$arr2 = [5,2,3,1];
//$obj2 = new Solution1();
//var_dump($obj2->sortArray($arr2));die;

/**
 * Class Solution3
 * 归并时间复杂度；
 */
class Solution3 {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     * // 快排问题
     * 随机分区点 ；
     * 重复元素的排序；
     */

    function sortArray($nums) {
        $l = 0;
        $r = count($nums) - 1;
        return $this->process($nums, $l, $r);

    }

    function process(&$nums, $l, $r) {
        // end condition
        //注意这里要返回一个数组
        //注意这里不因该是一个坐标而是一个 值；$l 的值;
        if ($l >= $r) return [$nums[$l]];///////////
        $p = $l + (($r - $l) >> 1);//      // /// //
        //
        $left = $this->process($nums, $l, $p);
        $right = $this->process($nums, $p + 1, $r);
        //合并  后序递归
        return $this->merge($left,$right);
    }

    //有序数组的合并;
    //需要有额外的空间
    // n的时间复杂度；
    function merge($left, $right) {
        // 双指针  和 一个空闲数组来合并
        $p0 = 0;
        $p1 = 0;
        $lmax = count($left);  // 这里是长度  所以不会达到  自己注意一下；
        $rmax = count($right);
        //合并后的数组的坐标
        $ret = [];
        $i = 0;
        $retmax = $lmax + $rmax;

        while ($p0 < $lmax && $p1 < $rmax) {
            //稳定性
            $ret[$i++] = $left[$p0]  > $right[$p1] ? $right[$p1++] : $left[$p0++];
        }
        //左边满了  直接添加右边的就行了
        while ($p0 >= $lmax && $i < $retmax) {
            $ret[$i++] = $right[$p1++];
        }
        //右边满了
        while ($p1 >= $rmax && $i < $retmax) {
            $ret[$i++] = $left[$p0++];
        }
        return $ret;
    }

    function swap(&$val, &$val1) {
        [$val, $val1] = array($val1, $val);
    }
}

$arr3 = [5,2,3,1];
//$obj3 = new Solution3();
//var_dump($obj3->sortArray($arr3));die;

/**
 * bubble  冒泡时间复杂度；
 * 每一次循环都要把 最大值放在最后面;
 * 时间复杂度 o(n^2);
 * 原地排序 k空间复杂度是O(1)
 * 稳定的；
 */
function swap($a, $b) {
    [$a,$b] = array($b,$a);
}
//  bubble 排序  超出时间限制 时间太长了
function bubble(&$nums) {
    $len = count($nums);

    $flag = false;

    for ($i = 0; $i < $len; $i++) {
        //$j+1 < $len - $i   不要溢出；
        // $i就代表有序的元素；
        // $len - $i  代表需要排序的元素；
        for ($j = 0; $j < $len - $i - 1; $j++) {
            //稳定性
            // 只有大于的时候才会交换;
            if ($nums[$j + 1] < $nums[$j]) {
                swap($nums[$j + 1], $nums[$j]);
                $flag = true;
            }
        }
        if (!$flag) break;
    }
    return $nums;
}

/**
 * 插入排序
 * 类似于 打扑克牌 摸牌的时候 一张张的给排序
 * 首先a[0] 肯定是有序的  然后依次a[1] 开始进行插入排序， 到底是在a[0]的左边还是右边；
 * 数组的交换；多注意一下把；
 * 关键是寻找插入位置，分为很多类型的插入排序，主要是分为直接插入排序，二分插入排序和希尔插入排序；
 * 希尔排序 就是缩小增量，多遍插入排序；
 */

/**
 * 直接插入排序；
 * 时间复杂度是 O(n^2)
 * 空间复杂度 原地排序
 * 稳定的，相等的时候插入到后面就行了；
 * direct
 * 查找 ，可以从后往前找，大于的就往后移位，当小于等于的就插入就行了；
 * 当有序的时候，
 * 向后移动元素这里其实就是覆盖；会简单一些；
 * 先找到 需要插入的位置，然后插入；
 */

function directinsertSort($nums) {
    $n = count($nums);
    //从1开始
    for ($i = 1; $i < $n; $i++) {
        //  要插入的数据
        $tmp = $nums[$i];
        //和有序的比较
        //[$i , ($n - 1)]是无序的，[0 , $i]是有序的；
        //寻找位置
        // 位置就是$j + 1;
        for ($j = $i - 1; $j >= 0; $j--) {
            if ($nums[$j] > $tmp) {
                // 移动数据 向后移动数据 ，就是覆盖后面的元素；
                // 覆盖掉；后面的元素；
                $nums[$j + 1] = $nums[$j];
            } else {
                //直接放在排序的后面；
                break;
            }
        }
        // 插入数据
        // break  跳出 寻找到位置，位置就是$j + 1,
        $nums[$j + 1] = $tmp;
    }
    return $nums;
}

function directinsertSort1($nums) {
    $n = count($nums);
    //从1开始
    for ($i = 1; $i < $n; $i++) {
        //  要插入的数据
        $tmp = $nums[$i];
        //和有序的比较
        //[$i , ($n - 1)]是无序的，[0 , $i]是有序的；
        //寻找位置
        // 位置就是$j + 1;
        // 只有 $j >= 0 &  $tmp < $nums[$j]; $j--
        for ($j = $i - 1; $j >= 0 & $tmp < $nums[$j]; $j--) {
                // 移动数据 向后移动数据 ，就是覆盖后面的元素；
                // 覆盖掉；后面的元素；
                $nums[$j + 1] = $nums[$j];
        }
        // 插入数据
        // break  跳出 寻找到位置，位置就是$j + 1,
        $nums[$j + 1] = $tmp;
    }
    return $nums;
}
//var_dump(directinsertSort1($arr3));die;
// 直接排序
//var_dump(directinsertSort($arr3));die;
// 减少比较次数的哨兵模式
function sentryInsertSort($nums) {
    $n = count($nums);
    for ($i = 2; $i < $n; $i++) {
        //只有大于来回执行下面的元素
        // 等于 也是直接进行下一个元素的插入；
        if ($nums[$i - 1] > $nums[$i]) {
            //sentry guard ??? 哨兵
            $nums[0] = $nums[$i];
            for ($j = $i - 1; $nums[$j] > $nums[0]; $j--) {
                $nums[$j + 1] = $nums[$j];
            }
            $nums[$j + 1] = $nums[0];
        }
    }
    return $nums;
}
//var_dump(sentryInsertSort($arr3));die;

// 二分法的插入排序
// 因为是本身是有序的，再一个是提高了查询位置的效率；
//
function sentrybinaryInsertSort($nums) {
    $n = count($nums);
    for ($i = 2; $i < $n; $i++) {
        $nums[0]  = $nums[$i];
        //这个是遍历的方式
//        for ($j = $i - 1; $nums[$j] > $nums[0]; $j--) {
//
//        }
        $l = 1;
        $r = $i - 1;
        //闭区间，所以可以等于  注意这里是左闭，右闭；
        while ($l <= $r) {
            $mid = $l + (($r - $l) >>1);
            //$mid $nums[$mid] 和value值的判断；$mid太小了，肯定要往右边去；
            if ($nums[$mid] <= $nums[0]) {
                // 去右边找；
                //注意等于的时候 也要去往右边去找
                $l = $mid + 1;
            } else {
                $r = $mid - 1;
            }
        }
        //上面找完位置  然后下面是移动  位置
        // 需要插入的位置是 $r + 1
        //向后移动位置
        for ($j = $i - 1; $j >= $r + 1; $j--)  $nums[$j + 1] = $nums[$j];
        //插入数据
        $nums[$r + 1] = $nums[0];
    }
    return $nums;
}
//var_dump(sentrybinaryInsertSort($arr3));die;
/**
 * 希尔排序
 * 对移动时间复杂度的优化；
 */

/**
 * 选择排序
 */
echo "ceshi";
echo "ceshi";
echo "ceshi";
echo "ceshi";

/**
 * 下面的排序 需要在特定的条件下才能进行的排序方式！！！ 特殊情况下的排序方式！！！
 */
/**
 * 桶排序
 */


/**
 * 基数排序
 */


/**
 * 外排序
 * external  sort
 */
