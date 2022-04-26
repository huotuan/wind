# 功能

 - [x] 企微员工同步 
 - [x] 企微消息回复
 - [ ] 手动同步企微员工
 - [ ] 信息加密
 - [ ] 阅后即焚
 - [ ] 敏感信息报警
 - [ ] 自动回收
 - [ ] 统计信息
 - [ ] 信息支持附件
 - [ ] 信息支持链接
 - [ ] 信息支持更多格式
 - [ ] 定时信息
 - [ ] 日程（生日、课程表、任务、纪念日、里程碑等等）提醒


# 安装
> 基于 laravel9+dcat-admin2.*,需要php8+
1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. 配置数据库，php artisan migrate
5. [配置自建应用的appid和回调地址](WEWORK_APP.md)
6. **开启队列进程守护**
7. 【可选】开启定时任务，也可以可以手动更新成员(`php artisan sync:user`)
8. [常见问题](ISSUES.md)


# 更新日志
## v1.1
- 🔥【新功能】增加初始化消息推送
- ⚡️【优化】企微回调优化
- 🐞解决列表时间展示按照预期显示的问题

## v1.0
- 🔥【新功能】后台搭建
- 🔥【新功能】企微回调处理
- 🔥【新功能】企微员工同步
- 🔥【新功能】企微自动回复

# 扩展
- [overtrue/laravel-wechat](https://github.com/overtrue/laravel-wechat)
- [guanguans/notify](https://github.com/guanguans/notify)

# 其他
- [企微开发文档](https://developer.work.weixin.qq.com/document/path/90556)
- [easywechat 文档](https://www.easywechat.com/6.x/index.html)
- [企微应用配置](WEWORK_APP.md)
- [常见问题](ISSUES.md)

# 版权信息
本项目可以免费使用。
