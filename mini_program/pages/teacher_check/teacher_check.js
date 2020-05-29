// pages/chakan/chakan.js
var page = getApp().globalData.page;//页

Page({
  /**
   * 页面的初始数据
   */
  data: {
    showData: [],
    dateValue: " - - ",
    department: '',
    grade: '',
    loadMoreText: '加载更多',
  },


  datePickerBindchange: function (e) {
    this.setData({
      dateValue: e.detail.value
    })
  },

  //搜索记录
  onSearch: function (e) {
    var that = this
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/specifiedDate',
      data: {
        department: that.data.department,
        grade: that.data.grade,
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
        } else if (res.data.error_code == 0) {
          that.setData({
            showData: res.data.data
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
  },
  //全部记录
  onAll: function (options) {
    this.setData({
      showData: [],
    })
    getApp().globalData.page = 2
    this.onLoad();
  },

  //获取全部记录
  getList: function (page) {
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
    //分  
    var m = date.getMinutes();
    //秒  
    var s = date.getSeconds();
    console.log("当前时间：" + Y + "-" + M + "-" + D + " " + h + ":" + m + ":" + s);
    var time = Y + "-" + M + "-" + D + " " + h + ":" + m + ":" + s;
    this.setData({
      time: time
    })
    console.log(this.data.time)
    this.setData({
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
    })
    var that = this
    wx.showLoading({
      title: '加载中',
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/checkRecords',
      data: {
        department: that.data.department,
        grade: that.data.grade,
        page: page
      },
      method: "POST",
      header: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      success: function (res) {
        console.log(res.data)
        if (res.data.error_code == 1) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) {}
          })
        } else if (res.data.error_code == 2) {
          // wx.showModal({
          //   title: '提示！',
          //   showCancel: false,
          //   content: res.data.msg,
          //   success: function (res) {}
          // })

        } else  if (res.data.error_code != 0) {
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
          //懒加载
          getApp().globalData.page += 1
          if (res.data.data.length > 0) {
            that.setData({
              showData: that.data.showData.concat(res.data.data) //合并数据
            })
          } else {
            that.setData({
              loadMoreText: '没有数据了'
            })
          }
          console.log(that.data.showData)
          console.log(res)
          console.log(res.data.data)
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
      // complete: function (res) {
      //    wx.hideLoading()
      // }
    })
    setTimeout(function () {
      wx.hideLoading()
    }, 2000)
  },

  //删除记录
  onLike: function (e) {
    var that = this
    wx.showModal({
      title: '提示',
      content: '您确认将此记录放入回收站？',
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定')
          wx.request({
            url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/deleteRecord',
            data: {
              department: that.data.department,
              grade: that.data.grade,
              start_time: e.target.dataset.time,
              end_time: e.target.dataset.end_time,
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
                wx.showModal({
                  success: function (res) {
                    if (res.confirm) {
                      console.log('用户点击确定')
                      //that.onLoad()
                      that.onAll()
                    } else if (res.cancel) {
                      console.log('用户点击取消')
                    }
                  },
                  title: '恭喜！',
                  showCancel: false,
                  content: '删除成功',
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
            complete: function (res) {}
          })
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },

  //查看跳转
  onClick: function (e) {
    wx.navigateTo({
      url: "../teacher_details/teacher_details?time=" + e.target.dataset.times + "&&endtime=" + e.target.dataset.endtime
    })
  },
  //显示
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数

    var that = this
    that.getList(1)
  },
  //触底
  onScrollLower: function () {
    var that = this
    page = getApp().globalData.page + 1;
    console.log(page)
    that.getList(page)
  },
})