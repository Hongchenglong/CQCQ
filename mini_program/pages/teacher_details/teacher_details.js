// pages/jiesu/jiesu.js
Page({

  /**
   * 页面的初始数据
   */
  data:{
    checkData:{},
    photoData:{},
    department:'',
    grade:'',
  },

  //获取全部记录
  onLoad: function(options) {
    this.setData({
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
    })
    getApp().globalData.start_time = options.time;
    getApp().globalData.end_time = options.endtime;
    var that=this
    wx.showLoading({
      title: '加载中',
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/viewDetails',
      data: {
        department:that.data.department,
        grade:that.data.grade,
        start_time:options.time,
        end_time:options.endtime
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

  
  // 一键提醒
  onSend: function (options) {
    console.log(getApp().globalData.start_time);
    console.log(getApp().globalData.end_time);
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Remind/remind',
      data: {
        department:getApp().globalData.user.department,
        grade:getApp().globalData.user.grade,
        start_time:getApp().globalData.start_time,
        end_time:getApp().globalData.end_time,
      },
      method: "POST",
      header: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      success(res) {
        if (res.data.error_code != 0) {
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {}
          })
        } else if (res.data.error_code == 0) {
          wx.showModal({
              title: "提示：",
              content: res.data.msg,
              showCancel: false,
              success(res) {},
            })
        }
      },
      fail: function () {
        console.log(res)
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {},
        })
      }
    })
    
  }
})