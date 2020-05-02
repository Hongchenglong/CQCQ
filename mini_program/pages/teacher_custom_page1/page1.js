// pages/teacher/custom/page1/page1.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    i: 0,
    select: false,
    hiddenName3: null,
    hiddenName4: null,
    Apart_name: '--',
    Num_name: '--',
    Apart: ['东二', '中二'],
    Num: ['411', '203'],
    listData: [],
  },

  bindShowMsg2() {
    this.setData({
      hiddenName3: false,
      hiddenName4: true,
      select: !this.data.select
    })
  },
  mySelect2(e) {
    console.log(e)
    var name = e.currentTarget.dataset.name
    this.setData({
      Apart_name: name,
      select: false
    })
  },
  bindShowMsg3() {
    this.setData({
      hiddenName3: true,
      hiddenName4: false,
      select: !this.data.select
    })
  },
  mySelect3(e) {
    console.log(e)
    var name = e.currentTarget.dataset.name
    this.setData({
      Num_name: name,
      select: false
    })
  },
  //抽取宿舍
  buttonList: function (e) {
    var that = this
    var List = that.data.listData
    var blockList = []
    var roomList = []
    for (var i = 0; i < List.length; i++) {
      blockList.push(List[i].block)
      roomList.push(List[i].room)
    }
    console.log(getApp().globalData.server + '/cqcq/public/index.php/index/Draw/customize')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Draw/customize',
      data: {
        department: '计算机工程系',
        grade: '2017',
        block: blockList,
        room: roomList,
      },
      method: "POST",
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success(res) {
        if (res.data.error_code != 0) {
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) { }
          })
        }
        else if (res.data.error_code == 0) {
          that.setData({
            Listdata: res.data.data
          })
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) { },
            complete: function (res) {
              wx.redirectTo({
                url: '/pages/teacher/teacher_extract_page2/page2'
              })
            },
          })
        }
      },
      fail: function () {
        console.log(res)
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) { }
        })
      }

    })

  },

  // 动态添加宿舍法
  buttonaddList1: function (e) {
    var apart = this.data.Apart_name;
    var num = this.data.Num_name;
    let list = this.data.listData
    var n = 0; //判断重复标志
    if (apart != '--' && num != '--') {
      for (var i = 0; i < list.length; i++) {
        if (list[i].block == apart && list[i].room == num) {
          n = 1
        }
      }
      if (n == 0) {
        list.push({
          'block': apart,
          'room': num
        })
      } else {
        wx.showToast({
          title: '提示：选择失败，表中已有该宿舍',
          icon: 'none',
          duration: 2000 //持续的时间
        })
      }
    } else {
      wx.showToast({
        title: '提示：请选择完整的宿舍信息',
        icon: 'none',
        duration: 2000 //持续的时间
      })
    }
    this.setData({
      listData: list
    });
  },

  // 动态删除宿舍
  buttonsubList: function (e) {
    var idx = e.currentTarget.dataset.idx;
    var list = this.data.listData;
    var filterRes = list.filter((ele, index) => {
      return index != idx
    })
    this.setData({
      listData: filterRes,
    })
  },

  //清空表
  buttonclearList: function (e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '确定要清空整个列表吗？',
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定')
          that.setData({
            listData: [],
            listblock: [],
            listroom: []
          })
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
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