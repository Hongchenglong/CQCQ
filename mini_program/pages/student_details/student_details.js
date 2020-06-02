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
    student_id: "",
    triggered: false, //下拉刷新状态 关闭
        _options: null,
  },

  //点击图片预览
  clickImg: function (e) {
    var imgUrl = e.target.dataset.photo;
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
      student_id: getApp().globalData.user.id,
      _options: options,
            photoData: {},
    })
    var that = this
    wx.showLoading({
      title: '加载中',
    })
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Checkresults/studentViewDetails',
      data: {
        grade: this.data.grade,
        department: this.data.department,
        start_time: options.time,
        student_id: this.data.student_id,
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
         
          console.log(res.data.data)
          console.log(res.data.data[0].dorm_num)
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
  //上传
  onSend: function (e) {
    getApp().globalData.imgSrc = ''
    wx.navigateTo({
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
      student_id: getApp().globalData.user.id,
    })
    //console.log(this.data.student_id)
  },


})