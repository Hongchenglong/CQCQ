// pages/student_details/student_details.js
Page({
  /**
   * 页面的初始数据
   */
  data: {
    checkData: {},
    photoData: {},
    grade: "",
    department: "",
    dorm: "",
    triggered: false, //下拉刷新状态 关闭
    _options: null,
    list: []
  },

  //点击图片预览
  clickImg: function (e) {
    var imgUrl = e.target.dataset.photo;
    console.log('e:', e)
    console.log('imgUrl:', imgUrl)
    wx.previewImage({
      urls: [imgUrl], //需要预览的图片http链接列表，注意是数组
      current: imgUrl, // 当前显示图片的http链接，默认是第一个
      success: function (res) {},
      fail: function (res) {},
      complete: function (res) {},
    })
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department,
      dorm: getApp().globalData.user.dorm,
      _options: options,
      photoData: {},
    })
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
    var that = this
    wx.showLoading({
      title: '加载中',
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/Checkresults/studentViewDetails',
      data: {
        grade: this.data.grade,
        department: this.data.department,
        start_time: options.time,
        dorm: this.data.dorm,
        end_time: options.endtime,
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
            checkData: res.data.data[0],
            photoData: res.data.data
          })
          getApp().globalData.dorm_num = res.data.data[0].dorm_num
          getApp().globalData.rand_num = res.data.data[0].rand_num
          getApp().globalData.start_time = res.data.data[0].start_time
          getApp().globalData.end_time = res.data.data[0].end_time
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

    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/Statistics/face_search',
      //发给服务器的数据
      data: {
        grade: this.data.grade,
        department: this.data.department,
        start_time: options.time,
        dorm: this.data.dorm,
        end_time: options.endtime,
      },
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.error_code == 1) {
          wx.showModal({
            title: '提示',
            content: res.data.msg,
            showCancel: false,
            success: function (res) {}
          })
          console.log(res);
        } else if (res.data.error_code == 2) {
          that.setData({
            list: res.data.unsign_stu
          })
          console.log(that.data.list);
        } else if (res.data.error_code == 0) {
          that.setData({
            list: res.data.unsign_stu
          })
          console.log(that.data.list);
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
      }
    })
  },

  /**
   * 上传照片
   */
  onSend: function (e) {
    getApp().globalData.imgSrc = ''
    // wx.navigateTo({  // 保留当前页面，跳转到应用内的某个页面。
    wx.redirectTo({ // 关闭当前页面，跳转到应用内的某个页面。
      url: "../uploadphoto/uploadphoto?time=" + e.target.dataset.times + "&&endtime=" + e.target.dataset.endtime
    })
  },
  //跳转
  // onUnload: function () {
  //   wx.switchTab({
  //     url: '../student_check/student_check'
  //   })
  //   setTimeout(function () {
  //     wx.hideLoading()
  //   }, 2000)
  // },
  // 刷新
  onRefresh() {
    var that = this;
    var _options = that.data._options

    setTimeout(function () {
      wx.hideLoading()
    }, 100)
    if (that._freshing) return
    that._freshing = true
    setTimeout(() => {
      that.onLoad(_options); // 再次加载
      that.setData({
        triggered: false,
      })
      that._freshing = false
    }, 2000)
  },

  // 下拉刷新复位
  onRestore(e) {
    console.log('onRestore:', e)
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    this.setData({
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department,
      dorm: getApp().globalData.user.dorm,
    })
    //console.log(this.data.dorm)
  },
})