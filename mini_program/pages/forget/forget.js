// pages/forget/forget.js
Page({

  /**
   * 页面的初始数据
   */

  onClickEmail: function (options) {
    wx.navigateTo({
      url: "../email_verify/email_verify"
    })
  },

  onClickPhone: function (options) {
    wx.navigateTo({
      url: "../phone_verify/phone_verify"
    })
  },
  
})