Page({
  goto1: function () {
    wx.showToast({
      title: '加载中...',
      mask: true,
      icon: 'loading'
    })
    getApp().globalData.imgSrc = ''
    wx.navigateTo({
      url: '/pages/uploadphoto/uploadphoto',
    })
  },

  goto2: function () {
    wx.showToast({
      title: '加载中...',
      mask: true,
      icon: 'loading'
    })
    wx.navigateTo({
      url: '/pages/student_check/student_check',
    })
  }
})