// pages/forget/forget.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    StatusBar: app.globalData.StatusBar,
    CustomBar: app.globalData.CustomBar,
    /*ColorList: app.globalData.ColorList,*/
    elements: [{
        title: '邮箱验证',
        name: 'Email',
        color: 'newColor2',
        icon: 'mail',
        page: 'email_verify',
      },
      {
        title: '短信验证',
        name: 'Phone',
        color: 'newColor3',
        icon: 'mobile',
        page: 'phone_verify',
      }
    ],
  },
  
})