// pages/teacher/custom/page/page.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    hiddenName1:null,
    hiddenName2:null,
    hiddenName3:null,
    hiddenName4:null,
    select: false,
    Boys_name: '--',
    Girls_name: '--',
    Apart_name: '--',
    Num_name: '--',
    Boys: [0,1,2,3,4,5,6],
    Girls:[0,1,2,3,4],
    Apart:['东二','中一','中一'],
    Num:['101','102']
  },
  bindShowMsg() {
    this.setData({
      hiddenName1:false,
      hiddenName2:true,
      hiddenName3:true,
      hiddenName4:true,
      select: !this.data.select
    })
  },
  mySelect(e) {
    console.log(e)
    var name = e.currentTarget.dataset.name
    this.setData({
      Boys_name: name,
      select: false
    })
  },
  bindShowMsg1() {
    this.setData({
      hiddenName1:true,
      hiddenName2:false,
      hiddenName3:true,
      hiddenName4:true,
      select: !this.data.select
    })
  },
  mySelect1(e) {
    console.log(e)
    var name = e.currentTarget.dataset.name
    this.setData({
      Girls_name: name,
      select: false
    })
  },
  bindShowMsg2() {
    this.setData({
      hiddenName1:true,
      hiddenName2:true,
      hiddenName3:false,
      hiddenName4:true,
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
      hiddenName1:true,
      hiddenName2:true,
      hiddenName3:true,
      hiddenName4:false,
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