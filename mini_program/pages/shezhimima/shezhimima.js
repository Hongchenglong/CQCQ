Page({
  data: {
    passwd: "",
    repasswd:""
  },
  passwdInput: function (e) {
    this.data.passwd = e.detail.value
  },
  repasswdInput: function (e) {
    this.data.repasswd = e.detail.value
  },
  onLaunch: function () {
    var that = this
    if (that.data.passwd == '') {
      wx.showModal({
        title: '提示',
        content: '请输入密码',
        showCancel: false,
        success(res) {}
      })
    }else if (that.data.repasswd == '') {
      wx.showModal({
        title: '提示',
        content: '请输入确认密码',
        showCancel: false,
        success(res) {}
      })
    }else if (that.data.passwd != that.data.repasswd) {
      wx.showModal({
        title: '提示',
        content: '密码不一致',
        showCancel: false
      })
    }
    else{
    wx.showToast({
      title: '修改成功！',
      icon: 'success',
      duration: 2000//持续的时间
    })
  }
  },

})