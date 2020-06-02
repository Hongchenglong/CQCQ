// pages/student_check/student_check.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    showData: {},
    dateValue: " - - ",
    grade: "",
    department: "",
    student_id: "",
    isShow: false,
  },

  datePickerBindchange: function (e) {
    this.setData({
      dateValue: e.detail.value
    })
  },

  //搜索记录
  onSearch: function (e) {
    console.log(this.data.grade)
    console.log(this.data.department)
    console.log(this.data.student_id)
    var that = this
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/specifiedDate',
      data: {
        grade: that.data.grade,
        department: that.data.department,
        date: that.data.dateValue
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
            success: function (res) {}
          })
        } else if (res.data.error_code == 2) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) {}
          })
        } else if (res.data.error_code != 0) {
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
        } else if (res.data.error_code == 0) {
          that.setData({
            showData: res.data.data
          })
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
      complete: function (res) {
        wx.hideLoading()
      }
    })
  },

  //全部记录
  onAll: function (e) {
    var that = this
    that.onLoad()
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //获取当前时间戳  
    var timestamp = Date.parse(new Date());
    timestamp = timestamp / 1000;
    //获取当前时间  
    var n = timestamp * 1000;
    var date = new Date(n);
    //年  
    var Y = date.getFullYear();
    //月  
    var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1);
    //日  
    var D = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
    //时  
    var h = date.getHours();
    if (h < 10) {
      h = '0' + h
    }
    //分  
    var m = date.getMinutes();
    if (m < 10) {
      m = '0' + m
    }
    //秒  
    var s = date.getSeconds();
    if (s < 10) {
      s = '0' + s
    }
    console.log("当前时间：" + Y + "-" + M + "-" + D + " " + h + ":" + m + ":" + s);
    var time = Y + "-" + M + "-" + D + " " + h + ":" + m + ":" + s;
    this.setData({
      time: time
    })
    this.setData({
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department,
      student_id: getApp().globalData.user.id,
    })
    var that = this
    wx.showLoading({
      title: '加载中',
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/studentCheckRecords',
      data: {
        department: that.data.department,
        grade: that.data.grade,
        student_id: that.data.student_id
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
            success: function (res) {}
          })
        } else if (res.data.error_code == 2) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) {
              that.setData({
                isShow: true,
              })
            }
          })
        } else if (res.data.error_code != 0) {
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
        } else if (res.data.error_code == 0) {
          that.setData({
            showData: res.data.data,
          })
          console.log(that.data.showData)
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
      complete: function (res) {
        wx.hideLoading()
      }
    })
    setTimeout(function () {
      wx.hideLoading()
    }, 2000)
  },

  //查看跳转
  onClick: function (e) {
    wx.navigateTo({
      url: "../student_details/student_details?time=" + e.target.dataset.times + "&&endtime=" + e.target.dataset.endtime
    })
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
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department,
      student_id: getApp().globalData.user.id,
    })
    console.log(this.data.student_id)
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