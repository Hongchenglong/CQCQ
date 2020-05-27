// pages/teacher_dorm/teacher_dorm.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'group'
  },

  handleChange ({ detail }) {
    this.setData({
        current: detail.key
    });
    /*if(detail.key == 'group'){
      wx.redirectTo({
        url: '../teacher_dorm/teacher_dorm',
      })
    }
    else */if(detail.key == 'homepage'){
      wx.reLaunch({
        url: '../teacher_home/teacher_home',
      })
    }
    else if(detail.key == 'mine'){
      console.log(getApp().globalData.load)
      if(  getApp().globalData.load == false ){
        wx.reLaunch({
          url: '/pages/load/load'
        })
      } else {
        wx.reLaunch({
          url: '../teacher_mine/teacher_mine',
        })
      }
    }
  },


dormCheck:function(){
    wx.navigateTo({
      url: '/pages/teacher_manage_page1/page1',
  })
},

dormManage:function(){
  wx.navigateTo({
    url: '/pages/teacher_manage_page2/page2',
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
})