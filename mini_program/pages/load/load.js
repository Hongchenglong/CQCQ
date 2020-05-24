// pages/login/load.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    canIUse: wx.canIUse('button.open-type.getUserInfo'), //查看微信版本是否支持微信授权 若支持则会显示 授权登陆 按钮
    current: 'mine'

  },

  handleChange ({ detail }) {
    this.setData({
        current: detail.key
    });
    
 if(detail.key == 'group'){
      wx.reLaunch({
        url: '../teacher_dorm/teacher_dorm',
      })
    }
    else if(detail.key == 'homepage'){
      wx.reLaunch({
        url: '../teacher_home/teacher_home',
      })
    }
  },

  next:function (e) {
    console.log("res.userInfo",getApp().globalData.userInfo)
    wx.reLaunch({
      url: '../teacher_mine/teacher_mine',
    })
  },

  /**
   * 生命周期函数--监听页面加载
   */

  onLoad: function(options) {
    var that = this

    wx.showLoading({
      title: '加载中',
    })

    wx.login({
      success(res) {
        if (res.code) {
          //发起网络请求
          // wx.request({
          //   url: 'https://test.com/onLogin',
          //   data: {
          //     code: res.code
          //   }
          // })

          // 查看是否授权
          wx.getSetting({
            success(res) {
              if (res.authSetting['scope.userInfo']) {
                // 已经授权，可以直接调用 getUserInfo 获取头像昵称
                getApp().globalData.load = true
                wx.getUserInfo({
                  success: function(res) {
                    console.log(res.userInfo)
                    getApp().globalData.userInfo = res.userInfo
                    
                    that.next();
                  }
                })
              }
            }
          })

        } else {
          console.log('登录失败！' + res.errMsg)
        }
      }
    })

    setTimeout(function() {
      wx.hideLoading()
    }, 1000)
  },

  bindGetUserInfo(e) {
    getApp().globalData.userInfo = e.detail.userInfo
    console.log(e.detail.userInfo)
    if(e.detail.userInfo == undefined){}
    else{
      getApp().globalData.load = true
      wx.reLaunch({
        url: '../teacher_mine/teacher_mine',
      })
    }
  },


  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    wx.hideHomeButton()
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})