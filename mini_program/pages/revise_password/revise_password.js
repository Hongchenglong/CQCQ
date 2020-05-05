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
  formSubmit: function (e) {
    console.log(e);
    //var oldpwd = e.detail.value.oldpwd;
    //var newpwd = e.detail.value.newpwd;
   //var newpwd2 = e.detail.value.newpwd2;
    oldpwd = e.detail.value.oldpwd;
    newpwd = e.detail.value.newpwd;
    newpwd2 = e.detail.value.newpwd2;

    if (oldpwd == '' || newpwd == '' || newpwd2 == '') {
      wx.showToast({
        title: '密码不能为空',
        icon: 'none',
        duration: 1000
      })
    } else if (newpwd != newpwd2) {
      wx.showToast({
        title: '两次密码输入不一致',
        icon: 'none',
        duration: 1000
      })
    } else {


      wx.request({
        'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/changePassword',
        method: 'POST',
        data: {
          id: getApp().globalData.user.id,
          oldPassword: e.detail.value.oldpwd,
          newPassword: newpwd,
          password_again: newpwd2,
        },
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: (res) => {
          console.log(res.data);
          if (res.data.error) {
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
  globalData: {
    id: null,
    oldPassword: null,
    newPassword: null,
    password_again: null,
    server: 'https://oeong.xyz/cqcq'
  }
})