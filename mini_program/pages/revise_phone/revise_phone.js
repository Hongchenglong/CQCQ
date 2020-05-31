const app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    phone: '', //手机号
    code: '', //验证码
    iscode: null, //用于存放验证码接口里获取到的code
    codename: '获取验证码',
  },
  //获取input输入框的值
  getPhoneValue: function (e) {
    this.setData({
      phone: e.detail.value
    })
  },
  getCodeValue: function (e) {
    this.setData({
      code: e.detail.value
    })
  },
  getCode: function () {
    var a = this.data.phone;
    var _this = this;
    var myreg = /^(14[0-9]|13[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$$/;
    if (this.data.phone == "") {
      wx.showToast({
        title: '手机号不能为空',
        icon: 'none',
        duration: 1000
      })
      getApp().globalData.Flag = 1
      return false;
    } else if (!myreg.test(this.data.phone)) {
      wx.showToast({
        title: '请输入正确的手机号',
        icon: 'none',
        duration: 1000
      })
      getApp().globalData.Flag = 1
      return false;
    } else {
      wx.request({
        data: {
          id: getApp().globalData.user.id,
          phone: this.data.phone,
        },
        'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/sendMessage',
        method: "POST",
        header: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          if (res.data.error_code != 0) {
            wx.showModal({
              title: '提示！',
              content: res.data.msg,
              showCancel: false,
              success: function (res) {
                getApp().globalData.Flag = 1
              }
            })
          } else if (res.data.error_code == 0) {
            wx.showModal({
              title: '恭喜！',
              content: '发送成功！',
              showCancel: false,
              success: res1 => {
                console.log(res.data.data)
                var value = JSON.parse(res.data.data.captcha);
                _this.setData({
                  iscode: value
                })
                getApp().globalData.Flag = 0
                var num = 61;
                var timer = setInterval(function () {
                  num--;
                  if (num <= 0) {
                    clearInterval(timer);
                    _this.setData({
                      codename: '重新发送',
                      disabled: false
                    })
                    getApp().globalData.Flag = 1
                  } else {
                    _this.setData({
                      codename: num + "s"
                    })
                  }
                }, 1000)
              },
            })
          }
        },
      })
    }
  },

  //获取验证码
  getVerificationCode() {
    var _this = this;
    this.getCode();
    if (getApp().globalData.Flag == 1) {
      _this.setData({
        disabled: false
      })
    } else {
      _this.setData({
        disabled: true
      })
    }
  },
  //提交表单信息
  save: function () {
    var myreg = /^(14[0-9]|13[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$$/;
    var that = this;
    if (this.data.phone == "") {
      wx.showToast({
        title: '手机号不能为空',
        icon: 'none',
        duration: 1000
      })
      return false;
    } else if (!myreg.test(this.data.phone)) {
      wx.showToast({
        title: '请输入正确的手机号',
        icon: 'none',
        duration: 1000
      })
      return false;
    }
    if (this.data.code == "") {
      wx.showToast({
        title: '验证码不能为空',
        icon: 'none',
        duration: 1000
      })
      return false;
    } else if (this.data.code != this.data.iscode) {
      wx.showToast({
        title: '验证码错误',
        icon: 'none',
        duration: 1000
      })
      return false;
    } else {
      wx.request({
        'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/verifyModifyPhone',
        // 发给服务器的数据
        data: {
          id: getApp().globalData.user.id,
          phone: this.data.phone,
          captcha: this.data.iscode,
        },
        method: "POST",
        header: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          if (res.data.error_code != 0) {
            wx.showModal({
              title: '提示！',
              content: res.data.msg,
              showCancel: false,
              success: function (res) {}
            })
          } else if (res.data.error_code == 0) {
            wx.showModal({
              title: '恭喜！',
              content: '修改成功！',
              showCancel: false,
              success: function (res) {},
              complete: function (res) {
                getApp().globalData.user.phone = that.data.phone;
                wx.navigateBack({
                  delta: 1
                  })
                /*if (getApp().globalData.user.user == 'student') {
                  wx.navigateTo({
                    url: '../student_mine/student_mine',
                  })
                } else {
                  wx.navigateTo({
                    url: '../teacher_mine/teacher_mine',
                  })
                }*/
              },
              fail: function (e) {
                console.log(e);
                wx.showModal({
                  title: '提示',
                  content: '修改失败！',
                  showCancel: false
                })
              },
            })
          }
        },
        fail: function (res) {
          wx.showModal({
            title: '哎呀～',
            content: '网络不在状态呢！',
            success: function (res) {
              if (res.confirm) {
                console.log('用户点击确定')
              } else if (res.cancel) {
                console.log('用户点击取消')
              }
            }
          })
        }
      })
    }
  },
})