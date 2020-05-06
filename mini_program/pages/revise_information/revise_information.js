var app = getApp();
Page({
  //弹窗
  popSuccessTest: function () {
    wx.showToast({
      title: '不可修改',
      image: '/images/error.png',
      duration: 1000, //停留时间
    })
  },
  //昵称：接口
  onShow: function (options) {
    var _this = this;
    wx.request({
      data: {
        id: getApp().globalData.user.id
      },
      'url': getApp().globalData.server + '/cqcq/public/index.php/index/getinfo/getHomeInfo',
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        getApp().globalData.userInfomation = res.data.data;
        console.log(getApp().globalData.userInfomation);
        _this.setData({
          gr1: getApp().globalData.userInfomation.stuInfo[0].username,
          gr2: getApp().globalData.userInfomation.stuInfo[0].grade,
          gr3: getApp().globalData.userInfomation.stuInfo[0].department,
          gr5: getApp().globalData.userInfomation.stuInfo[0].sex,
          block: getApp().globalData.userInfomation.roomInfo[0].block,
          room: getApp().globalData.userInfomation.roomInfo[0].room,
        })
        getApp().globalData.multiIndex[0] = getApp().globalData.multiArray[0].indexOf(_this.data.block);
        getApp().globalData.multiIndex[1] = getApp().globalData.multiArray[1].indexOf(_this.data.room[0]);
        getApp().globalData.multiIndex[2] = getApp().globalData.multiArray[2].indexOf(_this.data.room.slice(1, 3));
        console.log(getApp().globalData.multiIndex);
        _this.setData({
          multiIndex: getApp().globalData.multiIndex,
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
    flag:'',
    multiArray: [
      ['中一', '中二', '东一' ,'东二'],
      ['1', '2', '3', '4', '5','6','7'],
      ['01', '02', '03', '04','05','06','07','08','09','10',
      '11', '12', '13', '14','15','16','17','18','19','20',
      '21', '22', '23', '24','25','26','27','28','29','30',]
    ],
    multiIndex: [0, 0, 0],
  },
  bindMultiPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    var that = this;
    var block = getApp().globalData.multiArray[0][e.detail.value[0]];
    var room = getApp().globalData.multiArray[1][e.detail.value[1]]+getApp().globalData.multiArray[2][e.detail.value[2]];
    wx.request({
      'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/changeDormNumber',
      //发给服务器的数据
      data: {
        student_id: getApp().globalData.user.id,
        block: block,
        room: room,
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
            success: res1 => {
              console.log(res);
              that.setData({
                multiIndex: e.detail.value
              })
            }
          })
        }
      }
    })

    
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
    getApp().globalData.name = this.data.gr,
    getApp().globalData.user.username = this.data.gr
    var that = this;
      wx.request({
        'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/changeusername',
        //发给服务器的数据
        data: {
          id:getApp().globalData.user.id,
          username: getApp().globalData.name,
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
            that.setData({
              config: {
                tipsshow: "none"
              },
              hiddenmodalput: true,
              name: ''
            })
            wx.showModal({
              title: '恭喜！',
              content: '修改成功！',
              showCancel: false,
              success: res1 => {
                console.log(res);
                that.setData({
                  data: {
                    name: res.data.username,
                  },
                  gr1: getApp().globalData.user.username,
                })
              }
            })
          }
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
    getApp().globalData.grade = this.data.gr,
      this.setData({
        config1: {
          tipsshow: "none"
        },
        hiddenmodalput2: true,
        grade: '',
        gr2: getApp().globalData.grade,
      });
  },
  getInput2: function (e) {
    getApp().globalData.grade = this.data.gr2
    const that = this;
    that.setData({
      gr: e.detail.value
    })
  },
})