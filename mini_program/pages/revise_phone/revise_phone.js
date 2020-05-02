const app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {

    phone: '',//手机号
        code: '',//验证码
        iscode: null,//用于存放验证码接口里获取到的code
        codename: '获取短信验证码',
        disabled: false, //按钮是否禁用
  },
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
//判断手机号
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
        return false;
    } else if (!myreg.test(this.data.phone)) {
        wx.showToast({
            title: '请输入正确的手机号',
            icon: 'none',
            duration: 1000
        })
        return false;
    } else {
        wx.request({
            data: {
                phone: a
            },
            'url': 'https://oeong.xyz/cqcq/public/index.php/index/forget/sendSms',
            success(res) {
                console.log(res.data)
                _this.setData({
                    iscode: res.data
                })
                var num = 61;
                var timer = setInterval(function () {
                    num--;
                    if (num <= 0) {
                        clearInterval(timer);
                        _this.setData({
                            codename: '重新发送',
                            disabled: false
                        })

                    } else {
                        _this.setData({
                            codename: num + "s"
                        })
                    }
                }, 1000)
            }
        })
    }
},
//获取验证码
getVerificationCode() {
    this.getCode();
    var _this = this
    _this.setData({
        disabled: true
    })
},
formSubmitHandle: function (e) {
  var myreg = /^(14[0-9]|13[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$$/;
  if (this.data.phone == "") {
      wx.showToast({
          title: '手机号不能为空',
          icon: 'none',
          duration: 1000
      })
      return false;
  }
  else if (this.data.code == "") {
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
// 表单提交事件
      console.log('form表单submit：', e.detail.value);
      var provinceid = getApp().provinceid;
      var cityid = getApp().cityid;
      var areaid = getApp().areaid;
      // console.log('form表单submit：', e.detail.formId);
      this.setData({
          ind: e.detail.value
      })
      wx.request({
          url: 'https://oeong.xyz/cqcq/public/index.php/index/change/verifyPhone',
          method: "POST",
          data: {
              title: this.data.ind.title,
              mobile: this.data.ind.mobile,
              content: this.data.ind.content,
              type_name: this.data.ind.type_name,
              province: provinceid,
              city: cityid,
              area: areaid
          },
          header: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          success: function (res) {
              wx.showToast({
                  title: '提交成功！',
                  icon: 'success',
                  duration: 2000
              })
              wx.navigateBack({
                  delta: 1  //小程序关闭当前页面返回上一页面
              })
          },
          fail: function (res) {
              wx.showToast({
                  title: '提交失败！',
                  icon: 'fail',
                  duration: 2000
              })
          }
      })
  }
},

  
})