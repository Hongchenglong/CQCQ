# 辅助查寝系统

## 项目介绍
为解决目前高校宿舍查寝制度的不足，本系统使用微信小程序结合人脸识别技术实现了一套高校查寝系统。在本系统中，辅导员发布随机限时查寝任务，学生在规定的时间范围内，上传宿舍合照，系统即时进行人脸识别得到签到结果，并快速统计各个宿舍的查寝情况。

本项目基于微信小程序，小程序和Web后台的后端均使用ThinkPHP5框架，Web后台管理系统的前端采用Layui为核心框架，大大地简化了系统开发。同时系统部署在阿里云ECS上，云服务器的环境是LAMP，并接入百度AI开放平台的在线人脸识别API完成人脸库的管理和人脸搜索M:N识别，实现对学生上传的宿舍合照进行人脸识别以及汇总统计签到结果。

本系统可以解决目前高校查寝制度的不足，准确、高效地反馈学生晚间在宿舍的真实情况，减轻辅导员的工作负担，方便数据统计，建立起现代化的高校查寝系统。

| 所属课程 |[软件工程 (福州大学至诚学院 - 计算机工程系)](https://edu.cnblogs.com/campus/fzzcxy/SE?filter=all_members)|
| -------- | -------------------------------------------- |
| 团队名称 | [爱是用心码](https://www.cnblogs.com/yongxinma/)      |
| 项目名称 | 辅助查寝系统   |
|  Gitee地址| https://gitee.com/oeong/CQCQ |
|  Github地址| https://gitee.com/hongchenglong/CQCQ |
| 微信小程序 | mini_program |

<img src="https://gitee.com/oeong/picgo/raw/master/images/20210223193909.png" alt="小程序二维码" style="zoom:50%;" />

## 基础

### 官方文档
> 遇到不懂的问题，多查看官方文档。

- [微信小程序文档](https://developers.weixin.qq.com/miniprogram/dev/framework/)
小程序提供了一个简单、高效的应用开发框架和丰富的组件及API，帮助开发者在微信中开发具有原生 APP 体验的服务。

- [ThinkPHP5.0完全开发手册](https://www.kancloud.cn/manual/thinkphp5)
ThinkPHP是一个免费开源的，快速、简单的面向对象的轻量级PHP开发框架，是为了敏捷WEB应用开发和简化企业应用开发而诞生的。

- [百度人脸识别API文档](https://ai.baidu.com/ai-doc/FACE/yk37c1u4t)
人脸搜索：也称为1:N识别，在指定人脸集合中，找到最相似的人脸。

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

## 安装教程

### 本地部署



### 服务器部署





注册[百度智能云账号](https://login.bce.baidu.com/)

