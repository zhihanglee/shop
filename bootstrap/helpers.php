<?php
//辅助函数
function route_class()
{
    // 将当前请求的路由名称转换为 CSS 类名称，
    return str_replace('.', '-', Route::currentRouteName());
}
