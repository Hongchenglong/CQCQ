// pages/student_index/student_index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    PageCur: '',
    PageCur1: ''
  },

  NavChange(e) {
    this.setData({
      PageCur1: e.currentTarget.dataset.cur
    })
    if (this.data.PageCur1 == 'student_mine' && getApp().globalData.load == false) {
      wx.navigateTo({
        url: '/pages/load/load',
      })
      /*this.setData({
        PageCur: 'load'
      })*/
    } else {
      this.setData({
        PageCur: e.currentTarget.dataset.cur
      })
    }
    //console.log(this.data.PageCur)
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      PageCur: getApp().globalData.PageCur,
    })
    if (this.data.PageCur == '') {
      this.setData({
        PageCur: 'student_home',
      })
    } else {
      getApp().globalData.PageCur = ''
    }
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
    wx.hideHomeButton()
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