# 常见问题
1. (overtrue/laravel-wechat)扩展包无法安装
   `composer install  --with-all-dependencies --ignore-platform-req=ext-sodium`
2. 之前好好的，突然收不到消息了，检查是否修改了用户的id,并重新同步成员`php artisan sync:user` 或者登录后台手动同步员工
3. 企微/微信找不到新建的自建应用？`php artisan hello`会给当前应用可见范围内的所有人发送消息
