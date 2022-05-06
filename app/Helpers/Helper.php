<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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


if (!function_exists('set_agent')) {
    /**
     * @param $string
     * @param $key
     * @return string
     */
    function set_agent(array $data=[])
    {
        if (isset($data['errcode']) && $data['errcode']==0) {
            $data['updated_at'] = now();
            Cache::put('agent', $data);
        }
        return $data;
    }
}

if (!function_exists('get_agent')) {
    /**
     * @param $string
     * @param $key
     * @return string
     */
    function get_agent($key=null)
    {
        $data = Cache::get('agent');
        if (blank($key)) {
            return $data;
        }
        if ($key=='updated_at') {
            return trans_time($data[$key]??now());
        }
        return $data[$key]??'';
    }
}
