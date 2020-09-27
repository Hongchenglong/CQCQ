// pages/situation/situation.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    yes: "12次", //这个月已经签到的次数
    no: "0次", //这个月未签到的次数
    redate: [], //记录的日期
    time: [], //记录的起止时间
    date: '',
    date2: '',
    times: '12', //应签到次数
    unsign_day: [],
    unsign_time:[],
    sign_day: [],
    sign_time: [],
    unsign_num: '', //这个月未签到的次数
    sign_num: '',  //这个月已经签到的次数
    record_num: '' //应签到次数
  },

  // 时间段选择  
  bindDateChange(e) {
    let that = this;
    console.log(e.detail.value)
    that.setData({
      date: e.detail.value,
    })
    this.getSignSituation(that.data.date);
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var timestamp = Date.parse(new Date());
    var date = new Date(timestamp);
    //获取年份  
    var Y = date.getFullYear();
    //获取月份  
    var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1);
    this.setData({
      date: Y + '-' + M,
      date2: Y + '-' + M
    })
    this.getSignSituation(this.data.date);

  },

  getSignSituation:function(date){
    var that = this;
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/Resultsday/stuSignSituation',
      //发给服务器的数据
      data: {
        id: getApp().globalData.user.id,
        time: date
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
            unsign_day: res.data.data.unsign_day,
            sign_day: res.data.data.sign_day,
            unsign_num: res.data.data.unsign_num,
            sign_num: res.data.data.sign_num,
            record_num: res.data.data.record_num,
          })
          console.log(res.data.data);
          console.log()
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