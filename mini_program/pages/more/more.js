// pages/more/more.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    winWidth: 0,
    winHeight: 0,
    // tab切换  
    currentTab: 0,
    unsign_percent: 0,
    sign_percent: 0,
  },

  /** 
   * 滑动切换tab 
   */
  bindChange: function (e) {

    var that = this;
    that.setData({
      currentTab: e.detail.current
    });

  },
  /** 
   * 点击tab切换 
   */
  swichNav: function (e) {

    var that = this;

    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
      })
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    /** 
     * 获取系统信息 
     */
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          winWidth: res.windowWidth,
          winHeight: res.windowHeight
        });
      }
    });

    var that = this;
        wx.request({
                url: getApp().globalData.server + '/cqcq/public/index.php/api/Resultsday/getDay',
                //发给服务器的数据
                data: {
                    grade: 2017,
                    department: '计算机工程系'
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
                        console.log(res);
                    } else {
                        that.setData({
                            days: res.data.data.day
                        })
                        console.log(that.data.days);
                    }
                },
            }),
            wx.request({
                url: getApp().globalData.server + '/cqcq/public/index.php/api/statistics/statistics',
                //发给服务器的数据
                data: {
                    grade: 2017,
                    department: '计算机工程系',
                    start_time: '2020-06-17 22:30:00',
                    end_time: '2020-06-17 22:45:00'
                },
                method: "POST",
                header: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                success: function (res) {
                    // console.log(res);
                    if (res.data.error_code != 0) {
                        wx.showModal({
                            title: '提示',
                            content: res.data.msg,
                            showCancel: false,
                            success: function (res) {}
                        })
                    } else {
                        // console.log(res.data);
                        that.setData({
                            listData: res.data.data.unsign_list,
                            sign_num: res.data.data.sign_num,
                            unsign_num: res.data.data.unsign_num,
                            unsign_percent: (res.data.data.unsign_num / (res.data.data.unsign_num + res.data.data.sign_num)) * 100,
                            sign_percent: (res.data.data.sign_num / (res.data.data.unsign_num + res.data.data.sign_num)) * 100
                        })
                        console.log(that.data.listData);
                        console.log('sign_num:' + that.data.sign_num);
                        console.log('unsign_num:' + that.data.unsign_num);
                    }
                },
            })
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