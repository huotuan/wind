<?php

use Carbon\Carbon;

/**************** 时间相关开始 ******************/
/**
 * @return Carbon
 * @description carbon 格式的昨天
 */
if (!function_exists('yesterday')) {
    function yesterday(): Carbon
    {
        return Carbon::yesterday();
    }
}

if (!function_exists('trans_time')) {
    /**
     * 转为可读性更高的时间
     * 37秒前、1天前、57分钟前
     * @Date: 2021/8/31
     * @param $date
     * @return string
     */
    function trans_time($date): string
    {
        Carbon::setLocale('zh');

        return Carbon::parse($date)->diffForHumans();
    }
}

/**
 * @return int
 * @description 获取当天的剩余时间
 */
if (!function_exists('left_time')) {
    function left_time(): float|int|string
    {
        return Carbon::tomorrow()->timestamp - time();
    }
}
