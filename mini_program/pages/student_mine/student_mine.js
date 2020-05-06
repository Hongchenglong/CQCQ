// pages/student_mine/student_mine.js
Page({
  /**
   * 页面的初始数据
   */
  data: {
    current: 'mine',
    modalHidden:true,//是否隐藏对话框
    grade : '',
    department : ''
  },

  handleChange ({ detail }) {
    this.setData({
        current: detail.key
    });
    if(detail.key == 'mine'){
      wx.redirectTo({
        url: '../student_mine/student_mine',
      })
    }
    else{
      wx.redirectTo({
        url: '../student_home/student_home',
      })
  }
},

//跳转至修改图片
changeImage:function(){
  wx.navigateTo({
    url: '',
  })
},

//跳转至修改昵称
changeName:function(){
  wx.navigateTo({
    url: '',
  })
},

//退出登录
turnLogin:function(){
  wx.redirectTo({
    url: '',
  })
},

  //事件处理函数
  bindViewTap: function() {
    this.setData({
      modalHidden:!this.data.modalHidden
    })
  },
      
  //事件处理函数
  bindViewTap: function() {
    /*this.setData({
      modalHidden:!this.data.modalHidden
    })*/
    wx.showModal({
      title: '退出登录',
      content: '确认退出登录？',
      confirmColor:"red",
      success (res) {
        if (res.confirm) {
          //点击确认退出
          wx.redirectTo({
            url: '../login/login',
          })
        } else if (res.cancel) {
          //点击取消
          console.log('用户点击取消')
        }else {
          //异常
          wx.showLoading({
           title: '系统异常',
           fail
          })
          setTimeout(function () {
           wx.hideLoading()
          }, 2000)
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
    this.setData({
      username: getApp().globalData.user.username,
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
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