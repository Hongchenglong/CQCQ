// pages/jiesu/jiesu.js
Page({

  /**
   * 页面的初始数据
   */
  data:{
    checkData:{},
    photoData:{},
    department:'',
    grade:''
  },

  //获取全部记录
  onLoad: function(options) {
    this.setData({
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
    })
    var that=this
    wx.showLoading({
      title: '加载中',
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/viewDetails',
      data: {
        department:that.data.department,
        grade:that.data.grade,
        start_time:options.time
      },
      method: "POST",
      header: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      success: function (res) {
        if (res.data.error_code == 1) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) { }
          })
        }
        else if (res.data.error_code == 2) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) { }
          })
        }
        else if (res.data.error_code != 0) {
          wx.showModal({
            title: '哎呀～',
            content: '出错了呢！' + res.data.msg,
            success: function (res) {
              if (res.confirm) {
                console.log('用户点击确定')
              } else if (res.cancel) {
                console.log('用户点击取消')
              }
            }
          })
        }
        else if (res.data.error_code == 0) {
          that.setData({
            checkData: res.data.data[0],
            photoData:res.data.data
          })
          console.log(that.data.photoData)
        }
      },
      fail: function (res) {
        wx.showModal({
          title: '哎呀～',
          content: '网络不在状态呢！',
          success: function (res) {
            if (res.confirm) {
              console.log('用户点击确定')
            } else if (res.cancel) {
              console.log('用户点击取消')
            }
          }
        })
      },
      complete:function(res){
        wx.hideLoading()
      }
    })
    setTimeout(function() {
      wx.hideLoading()
    },2000)
  },
})