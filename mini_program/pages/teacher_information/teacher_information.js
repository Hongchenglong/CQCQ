var app = getApp();
Page({
  popSuccessTest2: function () {
    wx.showToast({
      title: '此处无法修改！请返回信息主页修改！',
      icon: 'none',
      duration: 2000, //停留时间
    })
  },
  //昵称：接口
  onShow: function (options) {
    var _this = this;
    if (getApp().globalData.user.phone == null) {
      getApp().globalData.user.phone = "暂无";
    }
    if (getApp().globalData.user.email == null) {
      getApp().globalData.user.email = "暂无";
    }
    _this.setData({
      gr1: getApp().globalData.user.username,
      gr2: getApp().globalData.user.grade,
      gr3: getApp().globalData.user.department,
      gr6: getApp().globalData.user.phone,
      gr7: getApp().globalData.user.email,
    })
  },
  data: {
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
    // hiddenmodalput: true,
    gr1: '',
    name: '',
    gr: '',
    department: ''
  },

  //点击按钮弹窗指定的hiddenmodalput弹出框 
  modalinput: function (e) {
    this.setData({
      modalName: e.currentTarget.dataset.target
    })
  },
  cancel: function (e) {
    this.setData({
      name: '',
      modalName: null
    });
  },
  //确认 
  confirm: function (e) {
    getApp().globalData.name = this.data.gr;
    var that = this;
    wx.request({
      'url': getApp().globalData.server + '/cqcq/public/index.php/api/change/changeusername',
      //发给服务器的数据
      data: {
        id: getApp().globalData.user.id,
        username: getApp().globalData.name,
      },
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.error_code != 0) {
          wx.showModal({
            title: '提示',
            content: res.data.msg,
            showCancel: false,
            success: function (res) {}
          })
        } else if (res.data.error_code == 0) {
          that.setData({
            config: {
              tipsshow: "none"
            },
            modalName: null,
            name: '',
          })
          wx.showModal({
            title: '提示',
            content: '修改成功！',
            showCancel: false,
            success: res1 => {
              getApp().globalData.user.username = that.data.gr;
              console.log(res);
              that.setData({
                data: {
                  name: res.data.username,
                },
                gr1: getApp().globalData.user.username,
              })
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


  },
  getInput: function (e) {
    getApp().globalData.name = this.data.gr1
    const that = this;
    //let gr1; 
    that.setData({
      gr: e.detail.value,
    })
  },

  //年级
  data2: {
    gr2: '',
    grade: '',
    gr: ''
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
  },
  //点击按钮弹窗指定的hiddenmodalput弹出框 
  modalinput2: function (e) {
    this.setData({
      modalName: e.currentTarget.dataset.target
    });
  },
  //取消按钮 
  cancel2: function (e) {
    this.setData({
      grade: '',
      modalName: null
    });
  },
  //确认 
  confirm2: function (e) {
    getApp().globalData.grade = this.data.gr;
    var that = this;
    wx.request({
      'url': getApp().globalData.server + '/cqcq/public/index.php/api/change/changegrade',
      //发给服务器的数据
      data: {
        id: getApp().globalData.user.id,
        grade: getApp().globalData.grade,
      },
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.error_code != 0) {
          wx.showModal({
            title: '提示',
            content: res.data.msg,
            showCancel: false,
            success: function (res) {}
          })
        } else if (res.data.error_code == 0) {
          that.setData({
            config1: {
              tipsshow: "none"
            },
            modalName: null,
            grade: '',
          })
          wx.showModal({
            title: '提示',
            content: '修改成功！',
            showCancel: false,
            success: res1 => {
              getApp().globalData.user.grade = that.data.gr;
              console.log(res);
              that.setData({
                data: {
                  name: res.data.grade,
                },
                gr2: getApp().globalData.grade,
              })
            },
            fail: function (e) {
              console.log(e);
              wx.showModal({
                title: '提示',
                content: '修改失败!',
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
      },
    })
  },
  getInput2: function (e) {
    getApp().globalData.grade = this.data.gr2
    const that = this;
    that.setData({
      gr: e.detail.value
    })
  },
  data3: {
    gr3: '',
    department: '',
    gr: '',
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
  },
  //点击按钮弹窗指定的hiddenmodalput弹出框 
  modalinput3: function (e) {
    this.setData({
      modalName: e.currentTarget.dataset.target
    });
  },
  //取消按钮 
  cancel3: function () {
    this.setData({
      department: '',
      modalName: null
    });
    console.log(this.data.department)
  },
  //确认 
  confirm3: function (e) {
    getApp().globalData.department = this.data.gr;
    var that = this;
    wx.request({
      'url': getApp().globalData.server + '/cqcq/public/index.php/api/change/changeDepartment',
      //发给服务器的数据
      data: {
        id: getApp().globalData.user.id,
        department: getApp().globalData.department,
      },
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.error_code != 0) {
          wx.showModal({
            title: '提示',
            content: res.data.msg,
            showCancel: false,
            success: function (res) {}
          })
        } else if (res.data.error_code == 0) {
          that.setData({
            config2: {
              tipsshow: "none"
            },
            modalName: null,
            department: '',
          })
          wx.showModal({
            title: '提示',
            content: '修改成功！',
            showCancel: false,
            success: res1 => {
              getApp().globalData.user.department = that.data.gr;
              console.log(res);
              that.setData({
                data: {
                  depatrment: res.data.department,
                },
                gr3: getApp().globalData.department,
              })
            },
            fail: function (e) {
              console.log(e);
              wx.showModal({
                title: '提示',
                content: '修改失败!',
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

  },
  getInput3: function (e) {
    getApp().globalData.department = this.data.gr3
    const that = this;
    that.setData({
      gr: e.detail.value
    })
  },
})