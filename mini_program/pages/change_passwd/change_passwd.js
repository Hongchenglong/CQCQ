Page({
  data: {
    passwd: "",
    repasswd:"",
    email:{},
    phone:{}
  },

  passwdInput: function (e) {
    this.data.passwd = e.detail.value
  },

  repasswdInput: function (e) {
    this.data.repasswd = e.detail.value
  },
  
  onLoad:function(options){
    var that = this
    that.setData({
        email:options.email,
        phone:options.phone
    })
  },

  onLaunch: function () {
    var that = this;
    var myreg = /(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,16}$/;
    if (that.data.passwd == '') {
      wx.showModal({
        title: '提示',
        content: '请输入密码',
        showCancel: false,
        success(res) {}
      })
    }
    else if (!myreg.test(that.data.passwd)) {
      wx.showModal({
        title: '提示！',
        content: '密码格式错误！',
        showCancel: false,
        success(res) {}
      })
    } 
    else if (that.data.repasswd == '') {
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
      wx.request({
        url: getApp().globalData.server + '/cqcq/public/index.php/index/forget/changePassword',
        data: {
          phone:that.data.phone,
          email:that.data.email,
          password:that.data.passwd,
          password_again:that.data.repasswd
        },
        method: "POST",
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        success: function (res) {
          console.log(res.data)
          if (res.data.error_code != 0) {
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
          }
          else if (res.data.error_code == 0) {
            wx.showModal({
              title: '恭喜！',
              showCancel: false,
              content: '修改成功',
              success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                } else if (res.cancel) {
                  console.log('用户点击取消')
                }
              },
              complete: function(res){
                wx.reLaunch({
                  url: "../login/login"
                })
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
        }
      })
    }
  }
})