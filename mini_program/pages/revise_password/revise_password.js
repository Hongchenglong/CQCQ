const app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    oldpwd:'',
    newpwd:'',
    newpwd2:''
  },
  getOldPwdValue: function (e) {
    this.setData({
      oldpwd: e.detail.value
    })
  },
  getNewPwdValue: function (e) {
    this.setData({
      newpwd: e.detail.value
    })
  },
  getNewPwd2Value: function (e) {
    this.setData({
      newpwd2: e.detail.value
    })
  },
  formSubmit: function (e) {
    var that = this;
    if (that.data.oldpwd == '' || that.data.newpwd == '' || that.data.newpwd2 == '') {
      wx.showToast({
        title: '密码不能为空',
        icon: 'none',
        duration: 1000
      })
    } else if (that.data.newpwd != that.data.newpwd2) {
      wx.showToast({
        title: '两次密码输入不一致',
        icon: 'none',
        duration: 1000
      })
    } else {
      wx.request({
        'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/changePassword',
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        data: {
          id: getApp().globalData.user.id,
          oldPassword: that.data.oldpwd,
          newPassword: that.data.newpwd,
          password_again: that.data.newpwd2,
        },
        success: (res) => {
          if (res.data.error_code) {
            wx.showToast({
              title: res.data.msg,
              icon: 'none',
              duration: 2000,
            })
          } else {
            wx.showToast({
              title: res.data.msg,
              icon: 'success',
              duration: 2000,
              success: function () {
                setTimeout(function () {
                  wx.navigateTo({
                    url: '../student_mine/student_mine',
                  })
                }, 2000)
              }
            })
          }
        }
      })
    }
  },
})