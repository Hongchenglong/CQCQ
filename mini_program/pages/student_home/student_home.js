// pages/student_home/student_home.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'homepage',
    /*height:''*/
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
    //加载中的样式
    wx.showToast({
      title: '加载中...',
      mask: true,
      icon: 'loading'
      }),
    wx.navigateTo({
      url: '../student_picupload/student_picupload',
    })
  },

  onShow:function(){
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

 