var app = getApp();
Page({

  //昵称：接口
  onShow: function (options) {
    var _this = this;
    wx.request({
      data: {
        id: 666666
      },
      'url': getApp().globalData.server + '/public/index.php/index/getinfo/getHomeInfo',
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        getApp().globalData.userInfomation = res.data.data;
        _this.setData({
          gr1: getApp().globalData.userInfomation.username,
          gr2: getApp().globalData.userInfomation.grade,
          gr3: getApp().globalData.userInfomation.department,
        })
      }
    })
  },
  data: {
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
    hiddenmodalput: true,
    gr1: '',
    name: '',
    gr: '',
  },

  //点击按钮弹窗指定的hiddenmodalput弹出框 
  modalinput: function () {
    this.setData({
      config: {
        tipsshow: "block"
      },
      hiddenmodalput: !this.data.hiddenmodalput,
    })
  },
  cancel: function () {
    this.setData({
      config: {
        tipsshow: "none",
      },
      hiddenmodalput: true,
      name: ''
    });
  },
  //确认 
  confirm: function (e) {
    var that = this;
    getApp().globalData.name = this.data.gr,
      wx.request({
        'url': getApp().globalData.server + '/public/index.php/index/change/changeusername',
        //发给服务器的数据
        data: {
          id: 666666,
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
              hiddenmodalput: true,
              name: '',
            })
            wx.showModal({
              title: '提示',
              content: '修改成功！',
              showCancel: false,
              success: res1 => {
                console.log(res);
                that.setData({
                  data: {
                    name: res.data.username,
                  },
                  gr1: getApp().globalData.name,
                })
              }
            })
          }
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
    hiddenmodalput2: true,
    gr2: '',
    grade: '',
    gr: ''
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
  },
  //点击按钮弹窗指定的hiddenmodalput弹出框 
  modalinput2: function () {
    this.setData({
      config1: {
        tipsshow: "block"
      },
      hiddenmodalput2: !this.data2.hiddenmodalput2
    });
  },
  //取消按钮 
  cancel2: function () {
    this.setData({
      config1: {
        tipsshow: "none"
      },
      hiddenmodalput2: true,
      grade: ''
    });
  },
  //确认 
  confirm2: function (e) {
    var that = this;
    getApp().globalData.grade = this.data.gr,
      wx.request({
        'url': getApp().globalData.server + '/public/index.php/index/change/changegrade',
        //发给服务器的数据
        data: {
          id: 666666,
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
              hiddenmodalput2: true,
              grade: '',
            })
            wx.showModal({
              title: '提示',
              content: '修改成功！',
              showCancel: false,
              success: res1 => {
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
        }
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
    hiddenmodalput3: true,
    gr3: '',
    de: '',
    gr: ''
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
  },
  //点击按钮弹窗指定的hiddenmodalput弹出框 
  modalinput3: function () {
    this.setData({
      config2: {
        tipsshow: "block"
      },
      hiddenmodalput3: !this.data3.hiddenmodalput3
    });
  },
  //取消按钮 
  cancel3: function () {
    this.setData({
      config2: {
        tipsshow: "none"
      },
      hiddenmodalput3: true,
      de: ''
    });
  },
  //确认 
  confirm3: function (e) {
    var that = this;
    getApp().globalData.department = this.data.gr,
      wx.request({
        'url': getApp().globalData.server + '/public/index.php/index/change/changeDepartment',
        //发给服务器的数据
        data: {
          id: 666666,
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
              hiddenmodalput3: true,
              department: '',
            })
            wx.showModal({
              title: '提示',
              content: '修改成功！',
              showCancel: false,
              success: res1 => {
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
        }
      })

  },
  getInput3: function (e) {
    getApp().globalData.de = this.data.gr3
    const that = this;
    that.setData({
      gr: e.detail.value
    })
  },
})