// pages/num/num.js
Page({

  /**
   * 页面的初始数据
   */
  
  data: {
    num: "",
  },
  
  inputNum: function () {
    var that = this
    if (that.data.num == '') {
      wx.showModal({
        title: '提示',
        content: '请输入验证码',
        showCancel: false
      })
    }
    else{
      wx.navigateTo({
        url: "/pages/shezhimima/shezhimima"
      })
    }
},

  numInput: function (e) {
    this.data.num = e.detail.value
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