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
  popSuccessTest2: function () {
    wx.showToast({
      title: '此处无法修改！请返回信息主页修改！',
      icon: 'none',
      duration: 2000, //停留时间
    })
  },

  onShow: function (options) {
    var _this = this;
    if (getApp().globalData.user.phone == null) {
      getApp().globalData.user.phone = "无";
    }
    if (getApp().globalData.user.email == null) {
      getApp().globalData.user.email = "无";
    }
    _this.setData({
      gr1: getApp().globalData.user.username,
      gr2: getApp().globalData.user.grade,
      gr3: getApp().globalData.user.department,
      gr5: getApp().globalData.user.sex,
      block: getApp().globalData.userInfomation.roomInfo[0].block,
      room: getApp().globalData.userInfomation.roomInfo[0].room,
      gr6: getApp().globalData.user.phone,
      gr7: getApp().globalData.user.email,
      id: getApp().globalData.user.id
    })
    // getApp().globalData.multiIndex[0] = getApp().globalData.multiArray[0].indexOf(_this.data.block);
    // getApp().globalData.multiIndex[1] = getApp().globalData.multiArray[1].indexOf(_this.data.room[0]);
    // getApp().globalData.multiIndex[2] = getApp().globalData.multiArray[2].indexOf(_this.data.room.slice(1, 3));
    // console.log(getApp().globalData.multiIndex);
    // _this.setData({
    //   multiIndex: getApp().globalData.multiIndex,
    // })
  },
  // data: {
  //   //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
  //   hiddenmodalput: true,
  //   gr1: '',
  //   name: '',
  //   gr: '',
  //   flag: '',
  //   multiArray: [
  //     ['中一', '中二', '东一', '东二'],
  //     ['1', '2', '3', '4', '5', '6', '7'],
  //     ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
  //       '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
  //       '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
  //     ]
  //   ],
  //   multiIndex: [0, 0, 0],
  // },
  // bindMultiPickerChange: function (e) {
  //   console.log('picker发送选择改变，携带值为', e.detail.value)
  //   var that = this;
  //   var block = getApp().globalData.multiArray[0][e.detail.value[0]];
  //   var room = getApp().globalData.multiArray[1][e.detail.value[1]] + getApp().globalData.multiArray[2][e.detail.value[2]];
  //   wx.request({
  //     'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/changeDormNumber',
  //     //发给服务器的数据
  //     data: {
  //       student_id: getApp().globalData.user.id,
  //       block: block,
  //       room: room,
  //     },
  //     method: "POST",
  //     header: {
  //       'Content-Type': 'application/x-www-form-urlencoded'
  //     },
  //     success: function (res) {
  //       if (res.data.error_code != 0) {
  //         wx.showModal({
  //           title: '提示！',
  //           content: res.data.msg,
  //           showCancel: false,
  //           success: function (res) {}
  //         })
  //       } else if (res.data.error_code == 0) {
  //         wx.showModal({
  //           title: '恭喜！',
  //           content: '修改成功！',
  //           showCancel: false,
  //           success: res1 => {
  //             console.log(res);
  //             that.setData({
  //               multiIndex: e.detail.value
  //             })
  //             getApp().globalData.userInfomation.roomInfo[0].block = block;
  //             getApp().globalData.userInfomation.roomInfo[0].room = room;
  //             getApp().globalData.userInfomation.roomInfo[0].dorm_num = block + "#" + room;
  //           }
  //         })
  //       }
  //     },
  //     fail: function (res) {
  //       wx.showModal({
  //         title: '哎呀～',
  //         content: '网络不在状态呢！',
  //         success: function (res) {
  //           if (res.confirm) {
  //             console.log('用户点击确定')
  //           } else if (res.cancel) {
  //             console.log('用户点击取消')
  //           }
  //         }
  //       })
  //     },
  //   })


  // },
  //昵称：接口
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
    getApp().globalData.name = that.data.gr;
    wx.request({
      'url': getApp().globalData.server + '/cqcq/public/index.php/index/change/changeusername',
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
              getApp().globalData.user.username = that.data.gr;
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
  getInput: function (e) {
    getApp().globalData.name = this.data.gr1
    const that = this;
    //let gr1; 
    that.setData({
      gr: e.detail.value,
    })
  },


})