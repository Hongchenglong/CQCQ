// pages/student_check/student_check.js
var page = getApp().globalData.page; //页
var count = 0; //一次加载记录数量
var totalCount = 0; //总记录数
var flag = 0; //0开 1锁
var scrollHeight = 0; //记录块高度
var scrollTop = 0;
var oneScrollHeight = 0; //一个记录块高度
Page({
  /**
   * 页面的初始数据
   */
  data: {
    showData: [],
    dateValue: " - - ",
    grade: "",
    department: "",
    dorm: "",
    isShow: false,
    isScroll: true, //启用滚动
    isShowing: true, //搜索开启
    isShowLoadmore: false, //正在加载 
    isShowNoDatasTips: false, //暂无数据
  },

  datePickerBindchange: function (e) {
    this.setData({
      dateValue: e.detail.value
    })
  },

  //搜索记录
  onSearch: function (e) {
    var that = this
    that.setData({
      isScroll: true
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/Checkresults/specifiedDate',
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
            success: function (res) { }
          })
        } else if (res.data.error_code == 2) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) { }
          })
        } else if (res.data.error_code == 0) {
          that.setData({
            showData: res.data.data
          })
          that.getScrollHeight();
          count = that.data.showData.length
          console.log(count);
          if (count < 7) {
            if (count * oneScrollHeight < scrollHeight) { //记录块不超过页面高度
              console.log('count * oneScrollHeight', count * oneScrollHeight);
              console.log('scrollHeight', scrollHeight);
              that.setData({
                isScroll: false //禁用滚动
              })
            } else {
              that.setData({
                isScroll: true //允许滚动
              })
              flag = 1;
            }
          } else if (count >= 7) {
            that.setData({
              isScroll: true //允许滚动
            })
            flag = 1;
          }
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
      isScroll: true
    })
    getApp().globalData.page = 2
    this.onLoad();
  },

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
      dorm: getApp().globalData.user.dorm,
      isScroll: true
    })
    var that = this
    // wx.showLoading({
    //   title: '加载中',
    // })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/Checkresults/studentCheckRecords',
      data: {
        department: that.data.department,
        grade: that.data.grade,
        dorm: that.data.dorm,
        page: page
      },
      method: "POST",
      header: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      success: function (res) {
        that.setData({
          isShowLoadmore: true,
          isShowNoDatasTips: false,
        })
        if (res.data.error_code == 1) {
          wx.showModal({
            title: '提示！',
            showCancel: false,
            content: res.data.msg,
            success: function (res) { }
          })
        } else if (res.data.error_code == 2) {
          that.setData({
            isShowLoadmore: false, // 不显示正在加载
            isShowNoDatasTips: true, // 显示暂无数据
          })
          if (totalCount == 0) {
            that.setData({
              isShow: true, //显示图片
              isShowing: false,  //不显示搜索
              isShowNoDatasTips: false,
            })
          }
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
          getApp().globalData.page += 1;
          if (res.data.data.length > 0) {
            console.log(that.data.showData)
            that.setData({
              showData: that.data.showData.concat(res.data.data), //合并数据
              isShowLoadmore: false,
              isShowNoDatasTips: false,
            })
            count = res.data.data.length;
            totalCount += count;
          }
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

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //获取当前时间戳  
    totalCount = 0;
    var that = this
    getApp().globalData.page = 2
    page = getApp().globalData.page
    flag = 0;
    that.getList(1)
    page += 1
    setTimeout(function () {
      wx.hideLoading()
    }, 100)
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

  getScrollHeight: function () {
    // 页面高度
    wx.createSelectorQuery().select('.scbg').boundingClientRect((rect) => {
      scrollHeight = rect.height
    }).exec()

    // 设定一小块的高度
    wx.createSelectorQuery().select('.changeInfoName').boundingClientRect((rect) => {
      oneScrollHeight = rect.height / (80 / 240)
    }).exec()
  },

  //触底
  onScrollLower: function (e) {
    var that = this;
    if (count == 7) {
      if (flag == 1) {
        that.setData({
          isScroll: true
        })
      } else {
        flag = 0;
        console.log(page)
        that.setData({
          isShowLoadmore: true, // 显示正在加载
          isShowNoDatasTips: false,
        })
        that.getList(page)
        page = getApp().globalData.page + 1;
      }
    } else if (count < 7) {
      if (flag == 1) {
        that.setData({
          isScroll: true
        })
      } else {
        that.getList(page)
      }
    } else if (count > 7) {
      that.setData({
        isScroll: true
      })
    }
    setTimeout(function () {
      wx.hideLoading()
    }, 80)
  },

  //滚动时
  onPull() {
    var that = this;
    that.setData({
      isShowLoadmore: false, // 显示正在加载
      isShowNoDatasTips: false,
    })
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    // this.setData({
    //   grade: getApp().globalData.user.grade,
    //   department: getApp().globalData.user.department,
    //   dorm: getApp().globalData.user.dorm,
    // })
    // console.log(this.data.dorm)
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