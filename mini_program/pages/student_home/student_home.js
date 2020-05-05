// pages/student_home/student_home.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'homepage',
  },

  //跳转至查看抽取结果
  gotoextractresults: function () {
    wx.navigateTo({
      url: '../student_view_results/student_view_results',
    })
  },

  //跳转至拍照上传
  gotopicupload: function () {
    wx.navigateTo({
      url: '../student_picupload/student_picupload',
    })
  },

  handleChange({ detail }) {
    this.setData({
      current: detail.key
    });
    if (detail.key == 'mine') {
      wx.redirectTo({
        url: '../student_mine/student_mine',
      })
    }

    else {
      wx.redirectTo({
        url: '../student_home/student_home',
      })
    }
  },
})