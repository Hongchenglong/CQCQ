// pages/login/login.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    is_disabled: false,
    name: "",
    pass: ""
  },

  username: function username(e) {
    this.setData({ name: e.detail.value });
   },

   password: function password(e) {
    this.setData({ pass: e.detail.value });
   },

  login:function(){
    var that = this
    var userReg = /^\d{9}$/
    var passReg = /^\d{9}$/
    if ( that.data.name == ''){
      wx.showModal({
        title: '提示信息',
        showCancel: false,
        content: '亲，用户名不能为空哟~'
      })
    }else if ( that.data.pass == ''){
      wx.showModal({
        title: '提示信息',
        showCancel: false,
        content: '亲，密码不能为空哟~',
      })
    }else if ( !userReg.test(that.data.name) ) {
      wx.showModal({
        title: '提示信息',
        showCancel: false,
        content: '亲，您输入的用户名格式有问题~'
      })
    }else if ( !passReg.test(that.data.pass) ) {
      wx.showModal({
        title: '提示信息',
        showCancel: false,
        content: '亲，您输入的密码格式有问题~'
      })
    }else{
      wx.redirectTo({
        url: '../teacher_home/teacher_home',
    })
    }
  },

  nameInput:function(e){
    this.data.name = e.detail.value
  },

  passInput:function(e){
    this.data.pass = e.detail.value
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