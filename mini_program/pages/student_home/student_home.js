// pages/student_home/student_home.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'homepage',
    /*height:''*/
    elements: [{
        title: '查看抽取结果',
        name: 'Extraction',
        color: 'newColor2',
        icon: 'formfill',
        page: 'student_extract',
        page_tow: 'page3'
      },
      {
        title: '拍照上传',
        name: 'View',
        color: 'newColor3',
        icon: 'newsfill',
        page: 'student_check',
        page_tow: 'student_check'
      }
    ],
  },

  handleChange({
    detail
  }) {
    this.setData({
      current: detail.key
    });
    if (detail.key == 'mine') {
      console.log(getApp().globalData.load)
      if (getApp().globalData.load == false) {
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

  //点击
  click: function () {
    //加载中的样式
    wx.showToast({
      title: '加载中...',
      mask: true,
      icon: 'loading',
      duration: 400
    })
  },

  //跳转至查看抽取结果
  gotoextractresults: function () {
    wx.showToast({
      title: '加载中',
      mask: true,
      duration: 400,
    })
    wx.navigateTo({
      url: '../student_extract/page3',
    })
  },

  //跳转至拍照上传
  gotopicupload: function () {
    wx.showToast({
      title: '加载中',
      mask: true,
      duration: 400,
    })
    wx.navigateTo({
      url: '../student_picupload/student_picupload',
    })

    //加载中的样式
    /*wx.showLoading({
      title: '加载中',
      mask: true,
    })
    wx.navigateTo({
      url: '../student_picupload/student_picupload',
    })
    wx.hideLoading()*/
  },

  onShow: function () {
    wx.hideHomeButton()
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    /*this.data.height = getApp().globalData.height
    console.log(this.data.height)*/
  },
})