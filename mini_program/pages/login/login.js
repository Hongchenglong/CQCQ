// pages/login/login.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    is_disabled: false,
    id: "",
    password: "",
    isShow1:true,
    inputType1:"password",
  },

  /*signup: function () {
    wx.navigateTo({
      url: '/pages/enroll/enroll'
    })
  },*/

  login: function () {
    var that = this
    if (that.data.id == '') {
      wx.showModal({
        title: '提示！',
        showCancel: false,
        content: '请输入账号！',
        confirmColor:'#7EC4F8',
        success: function (res) { }
      })
    } else if (that.data.password == '') {
      wx.showModal({
        title: '提示！',
        showCancel: false,
        content: '请输入密码！',
        confirmColor:'#7EC4F8',
        success: function (res) { }
      })
    } else {
      wx.request({
        // url: 'http://localhost:8080/cqcq/back_end/public/index.php/index/user/login',
        url: getApp().globalData.server + '/cqcq/public/index.php/index/user/login',
        data: {
          id: that.data.id,
          password: that.data.password,
        },
        method: "POST",
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        success: function (res) {
          console.log(res.data)
          if (res.data.error_code == 1 || res.data.error_code == 2 || res.data.error_code == 3) {
            wx.showModal({
              title: '提示！',
              content: res.data.msg,
              confirmColor:'#7EC4F8',
              showCancel: false,
              success(res) { }
            })
          } else if (res.data.error_code != 0) {
            wx.showModal({
              title: '哎呀～',
              content: '出错了呢！' + res.data.data.msg,
              confirmColor:'#7EC4F8',
              showCancel: false,
              /*success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                } else if (res.cancel) {
                  console.log('用户点击取消')
                }
              }*/
            })
          } else if (res.data.error_code == 0) {
            getApp().globalData.user = res.data.data
            //console.log(getApp().globalData.user.username)
            wx.showModal({
              title: '恭喜!',
              showCancel: false,
              content: '登录成功',
              confirmColor:'#7EC4F8',
              success: function (res) {
                /*if (res.confirm) {
                  console.log('用户点击确定')
                }*/
              },
              complete: function (res) {
                console.log(getApp().globalData.user.user)
                
                if (  getApp().globalData.user.user == 'counselor' ){
                  //console.log(that.data.id.length),
                  wx.reLaunch({
                    url: '/pages/teacher_home/teacher_home'
                  })
                }
                else if ( getApp().globalData.user.user == 'student'  ){
                  wx.reLaunch({
                    url: '/pages/student_home/student_home'
                  })
                }
              }
            })
          }
        },
        fail: function (res) {
          wx.showModal({
            title: '哎呀～',
            showCancel: false,
            confirmColor:'#7EC4F8',
            content: '网络不在状态呢！',
            success(res) { }
            }
          )
        }
      })
    }
  },

  idInput: function (e) {
    this.data.id = e.detail.value
  },

  passwordInput: function (e) {
    this.data.password = e.detail.value
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

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