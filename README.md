# 辅助查寝系统

## 项目介绍
为解决目前高校宿舍查寝制度的不足，本系统使用微信小程序结合人脸识别技术实现了一套高校查寝系统。在本系统中，辅导员发布随机限时查寝任务，学生在规定的时间范围内，上传宿舍合照，系统即时进行人脸识别得到签到结果，并快速统计各个宿舍的查寝情况。

![小程序二维码](./public/images/QRcode.jpg)

## 基础

### 目录结构

```
CQCQ  应用部署目录
├─application           
│  ├─api              	小程序后台
│  │  └─controller      
│  ├─index              Web后台
│  │  ├─controller      控制器目录
│  │  └─view            视图目录
│  ├─config.php         应用（公共）配置文件
│  ├─database.php       数据库配置文件
│  ├─route.php          路由配置文件
│  └─...
├─extend                扩展类库目录（可定义）
├─mini_program          微信小程序
│  ├─pages				
│  ├─app.js             全局配置文件
│  └─ ...  
├─public                WEB 部署目录（对外访问目录）
│  ├─face				学生人脸
│  ├─upload				宿舍合照
│  ├─index.php          应用入口文件
│  └─ ...        
├─runtime               应用的运行时目录（可写，可设置）
├─vendor                第三方类库目录（Composer）
├─thinkphp              框架系统目录
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
```

### 官方文档

- [微信小程序文档](https://developers.weixin.qq.com/miniprogram/dev/framework/)
小程序提供了一个简单、高效的应用开发框架和丰富的组件及API，帮助开发者在微信中开发具有原生 APP 体验的服务。

- [ThinkPHP5.0完全开发手册](https://www.kancloud.cn/manual/thinkphp5)
ThinkPHP是一个免费开源的，快速、简单的面向对象的轻量级PHP开发框架，是为了敏捷WEB应用开发和简化企业应用开发而诞生的。

- [百度人脸识别API文档](https://ai.baidu.com/ai-doc/FACE/yk37c1u4t)
人脸搜索：也称为1:N识别，在指定人脸集合中，找到最相似的人脸。

## 安装教程

### 本地部署

1. 下载`phpstudy`，启动`Apache2.4`和`MySQL5.7`;
2. 下载项目`CQCQ`,放在`D:\phpstudy_pro\WWW\`下
3. 新建数据库`CQCQ`，导入`CQCQ.sql`。修改`/application/database.php`中的用户名和密码。
4. 在`https://mp.weixin.qq.com/`申请微信小程序。
5. 登录后台地址`http://localhost:8080/cqcq/public/index.php/index/login/index.html`，账号密码都是`8848`。在系统设置中的微信小程序配置`AppID `和`AppSecret `，若有用到其他模块，也进行相应配置。
6. 微信开发者工具导入`mini_program`,修改`app.js`中的`server`,并全局替换`https://oeong.com`为`http://localhost:8080`。并在右上角的详情->本地设置中勾选`不校验合法域名`。



