// pages/forget/forget.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    elements: [{
        title: '通过邮箱验证修改密码',
        name: 'Mail',
        color: 'newColor2',
        icon: 'mail',
        page: 'email_verify',
      },
      {
        title: '通过手机验证修改密码',
        name: 'Phone',
        color: 'newColor3',
        icon: 'mobile',
        page: 'phone_verify',
      }
    ],
  },
  
})