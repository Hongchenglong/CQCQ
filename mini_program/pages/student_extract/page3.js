// pages/teacher/extract/page3/page3.js
Page({
  data: {
    // targetTime: 0,
    clearTimer: false,
    status: '进行中...',
    date_1: null,
    weekday: null,
    time1: '22:30',
    time2: '22:45',
    Listdata: [],
    dep: '',
    grade: '',
    dorm: ''
  },
  myLinsterner(e) {
    this.setData({
      status: '结束'
    });
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {


  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that = this
    // console.log(getApp().globalData.userInfomation.roomInfo[0].dorm_num)
    this.setData({
      dorm: getApp().globalData.userInfomation.roomInfo[0].dorm_num,
      grade: getApp().globalData.user.grade,
      dep: getApp().globalData.user.department
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/draw/displayRecentResults',
      data: {
        department: that.data.dep,
        grade: that.data.grade,
      },
      method: "POST",
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success(res) {
        // console.log(res.data)
        if (res.data.error_code != 0) {
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {}
          })
        } else if (res.data.error_code == 0) {
          // var List = res.data.data
          var l = res.data.data.length - 1
          // for (var i = 0; i < List.length; i++) {
          //   if (List[i].dorm_num == Dorm) {
          //     that.setData({
          //       sign:'1'
          //     })
          //   }
          // }
          that.setData({
            Listdata: res.data.data,
            time1: res.data.data[l].start_time,
            time2: res.data.data[l].end_time
          })
        }
      },
      fail: function () {
        console.log(res)
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {}
        })
      }
    })


  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
    this.setData({
      clearTimer: true
    });
    /*wx.reLaunch({
      url: '/pages/teacher_home/teacher_home',
    })*/
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})