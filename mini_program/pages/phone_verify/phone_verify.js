// pages/teacher_phone_verify/teacher_phone_verify.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    phone: "",
    num: "",
    codename: '获取验证码',
    code:""
  },

  phoneInput: function (e) {
    this.data.phone = e.detail.value
  },

  numInput: function (e) {
    this.data.num = e.detail.value
  },

  onInput: function (e) {
    var that = this;
    var myreg = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
    if (that.data.phone == "") {
      wx.showModal({
        title: '提示',
        content: '请输入手机号',
        showCancel: false
      })
      getApp().globalData.Flag = 1
    } else if (!myreg.test(that.data.phone)) {
      wx.showModal({
        title: '提示！',
        content: '请输入正确的手机号！',
        showCancel: false,
        success(res) {
          getApp().globalData.Flag = 1
        }
      })
    } else if (that.data.num == "") {
      wx.showModal({
        title: '提示',
        content: '请输入验证码',
        showCancel: false
      })
      getApp().globalData.Flag = 1
    } else {
      wx.request({
        url: getApp().globalData.server + '/cqcq/public/index.php/index/forget/verifyPhone',
        data: {
          phone: that.data.phone,
          captcha: that.data.num
        },
        method: "POST",
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        success: function (res) {
          console.log(res.data)
          if (res.data.error_code == 1) {
            wx.showModal({
              title: '提示！',
              showCancel: false,
              content: res.data.msg,
              success: function (res) {}
            })
          } else if (res.data.error_code == 2) {
            wx.showModal({
              title: '提示！',
              showCancel: false,
              content: res.data.msg,
              success: function (res) {}
            })
          } else if (res.data.error_code != 0) {
            wx.showModal({
              title: '哎呀～',
              content: '出错了呢！' + res.data.msg,
              success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                } else if (res.cancel) {
                  console.log('用户点击取消')
                }
              }
            })
          } else if (res.data.error_code == 0) {
            if(that.data.num == that.data.code){
              wx.reLaunch({
                url: "../change_passwd/change_passwd?phone=" + that.data.phone
              })
            }
            else{
              wx.showModal({
                title: '哎呀～',
                showCancel: false,
                content: '验证码错误',
                success: function (res) {
                  if (res.confirm) {
                    console.log('用户点击确定')
                  } else if (res.cancel) {
                    console.log('用户点击取消')
                  }
                }
            })
          }
        }
      }
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
  },

  onClick: function (e) {
    var that = this;
    if (that.data.phone == "") {
      wx.showModal({
        title: '提示',
        content: '请输入手机号',
        showCancel: false
      })
      getApp().globalData.Flag = 1
    } else {
      wx.request({
        url: getApp().globalData.server + '/cqcq/public/index.php/index/forget/sendSms',
        data: {
          phone: that.data.phone
        },
        method: "POST",
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        success: function (res) {
          console.log(res.data)
          if (res.data.error_code == 1) {
            wx.showModal({
              title: '提示！',
              showCancel: false,
              content: res.data.msg,
              success: function (res) {
                getApp().globalData.Flag = 1
              }
            })
          } else if (res.data.error_code == 2) {
            wx.showModal({
              title: '提示！',
              showCancel: false,
              content: res.data.msg,
              success: function (res) {
                getApp().globalData.Flag = 1
              }
            })
          } else if (res.data.error_code != 0) {
            wx.showModal({
              title: '哎呀～',
              content: '出错了呢！' + res.data.msg,
              success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                } else if (res.cancel) {
                  console.log('用户点击取消')
                }
                getApp().globalData.Flag = 1
              }
            })
          } else if (res.data.error_code == 0) {
            that.setData({
              code : res.data.data.captcha
            })
            wx.showModal({
              title: '恭喜！',
              showCancel: false,
              content: '发送成功',
              success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                } else if (res.cancel) {
                  console.log('用户点击取消')
                }
                getApp().globalData.Flag == 0
                var number = 61;
                var timer = setInterval(function () {
                  number--;
                  if (number <= 0) {
                    clearInterval(timer);
                    that.setData({
                      codename: '重新发送',
                      disabled: false
                    })
                    getApp().globalData.Flag = 1
                  } else {
                    that.setData({
                      codename: number + "s"
                    })
                  }
                }, 1000)
              }
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
              getApp().globalData.Flag = 1
            }
          })
        }
      })
    }
  }
})