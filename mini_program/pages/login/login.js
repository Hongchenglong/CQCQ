// pages/login/login.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    is_disabled: false,
    id: "",
    password: "",
    isShow1: true,
    inputType1: "password",
    height: '',
    StatusBar: app.globalData.StatusBar,
    CustomBar: app.globalData.CustomBar,
    /*ColorList: app.globalData.ColorList,*/
    height:''
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
        confirmColor: '#7EC4F8',
        success: function (res) {}
      })
    } else if (that.data.password == '') {
      wx.showModal({
        title: '提示！',
        showCancel: false,
        content: '请输入密码！',
        confirmColor: '#7EC4F8',
        success: function (res) {}
      })
    } else {
      wx.request({
        url: getApp().globalData.server + '/cqcq/public/index.php/api/user/login',
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
              confirmColor: '#7EC4F8',
              showCancel: false,
              success(res) {}
            })
          } else if (res.data.error_code != 0) {
            wx.showModal({
              title: '哎呀～',
              content: '出错了呢！' + res.data.data.msg,
              confirmColor: '#7EC4F8',
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
            console.log(getApp().globalData.user)
            console.log(getApp().globalData.user.user)
            //加载中的样式
            wx.showToast({
              title: '加载中...',
              mask: true,
              icon: 'loading',
              duration: 400
            })
            if (getApp().globalData.user.user == 'counselor') {
              //console.log(that.data.id.length),
              wx.reLaunch({
                url: '/pages/teacher_index/teacher_index'
              })
            } else if (getApp().globalData.user.user == 'student') {
              wx.reLaunch({
                url: '/pages/student_index/student_index'
              })
            }
            var _this = this;
            wx.request({
              data: {
                id: getApp().globalData.user.id
              },
              'url': getApp().globalData.server + '/cqcq/public/index.php/api/getinfo/getHomeInfo',
              method: "POST",
              header: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              success: function (res) {
                getApp().globalData.userInfomation = res.data.data;
                console.log(getApp().globalData.userInfomation);
              }
            })
          }
        },
        fail: function (res) {
          wx.showModal({
            title: '哎呀～',
            showCancel: false,
            confirmColor: '#7EC4F8',
            content: '网络不在状态呢！',
            success(res) {}
          })
        }
      })
    }

    // 若已经授权，则获取用户信息
    wx.getSetting({
      success: res => {
        //判断是否授权，如果授权成功
        if (res.authSetting['scope.userInfo']) {
          //获取用户信息
          wx.getUserInfo({
            success: res => {
              // console.log(res);
              getApp().globalData.userInfo = res.userInfo
              getApp().globalData.load = true
              //网络延迟，回调函数
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      },
    })
  },

  idInput: function (e) {
    this.data.id = e.detail.value
  },

  passwordInput: function (e) {
    this.data.password = e.detail.value
  },

  to_forget: function () {
    wx.showToast({
      title: '加载中...',
      mask: true,
      icon: 'loading',
      duration: 400
    })
    wx.navigateTo({
      url: '../forget/forget',
    })
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that = this;
    wx.getSystemInfo({
      success: function (res) {
        // 获取可使用窗口宽度
        var clientHeight = res.windowHeight;
        // 获取可使用窗口高度
        var clientWidth = res.windowWidth;
        // 算出比例
        let ratio = 750 / clientWidth;
        //height = clientHeight * ratio;
        // 设置高度
        that.setData({
          height: clientHeight * ratio
        });
        getApp().globalData.height = that.data.height
        getApp().globalData.width = that.data.width
        //getApp().globalData.height=that.data.height
        // console.log(that.data.height)
        // console.log(getApp().globalData.height)
      }
    });
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function (res) {},

  wxlogin: function () {
    var that = this
    wx.login({
      success: function (res) {
        console.log("code: ", res.code)
        wx.request({
          url: getApp().globalData.server + '/cqcq/public/index.php/api/user/wxlogin',
          data: {
            code: res.code,
          },
          method: "POST",
          header: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          success: function (res) {
            if (res.data.error_code != 0) {
              wx.showModal({
                title: '提示！',
                content: res.data.msg,
                confirmColor: '#7EC4F8',
                showCancel: false,
                success(res) { }
              })
            } else if (res.data.error_code == 0) {
              getApp().globalData.user = res.data.data
              //加载中的样式
              wx.showToast({
                title: '加载中...',
                mask: true,
                icon: 'loading',
                duration: 400
              })
              if (getApp().globalData.user.user == 'counselor') {
                wx.reLaunch({
                  url: '/pages/teacher_index/teacher_index'
                })
              } else if (getApp().globalData.user.user == 'student') {
                wx.reLaunch({
                  url: '/pages/student_index/student_index'
                })
              }
              var _this = this;
              wx.request({
                data: {
                  id: getApp().globalData.user.id
                },
                url: getApp().globalData.server + '/cqcq/public/index.php/api/getinfo/getHomeInfo',
                method: "POST",
                header: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                success: function (res) {
                  getApp().globalData.userInfomation = res.data.data;
                  console.log(getApp().globalData.userInfomation);
                }
              })
            }
          },
          fail: function (res) {
            wx.showModal({
              title: '哎呀～',
              showCancel: false,
              confirmColor: '#7EC4F8',
              content: '网络不在状态呢！',
              success(res) {}
            })
          }
        })
      }
    })
    

    // 若已经授权，则获取用户信息
    wx.getSetting({
      success: res => {
        //判断是否授权，如果授权成功
        if (res.authSetting['scope.userInfo']) {
          //获取用户信息
          wx.getUserInfo({
            success: res => {
              // console.log(res);
              getApp().globalData.userInfo = res.userInfo
              getApp().globalData.load = true
              //网络延迟，回调函数
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      },
    })
  }
})
