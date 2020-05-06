// pages/student_home/student_home.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'homepage',
  },

  handleChange ({ detail }) {
    this.setData({
        current: detail.key
    });
   if(detail.key == 'mine'){
      console.log(getApp().globalData.load)
      if(  getApp().globalData.load == false ){
        console.log(getApp().globalData.load)
        wx.reLaunch({
          url: '../student_load/student_load'
        })
      } else {
        wx.reLaunch({
          url: '../student_mine/student_mine',
        })
      }
    }
  },

  //跳转至查看抽取结果
  gotoextractresults: function () {
    wx.navigateTo({
      url: '../student_extract/page3',
    })
  },

  //跳转至拍照上传
  gotopicupload: function () {
    wx.navigateTo({
      url: '../student_picupload/student_picupload',
    })
  },
})

 