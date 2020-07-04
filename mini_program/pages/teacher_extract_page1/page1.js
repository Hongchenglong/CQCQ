// pages/teacher/extract/page1/page1.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    /*select: false,
    hiddenName1:null,
    hiddenName2:null,*/
    dep: '',
    grade: '',
    Boys_name: 4,
    Girls_name: 2,
    Listdata: [],
    Boys_max: '',
    Girls_max: '',
  },

  handleChange1({
    detail
  }) {
    this.setData({
      Girls_name: detail.value
    })
  },
  handleChange2({
    detail
  }) {
    this.setData({
      Boys_name: detail.value,
    })
  },

  //跳转页面
  buttonListener: function (e) {
    wx.navigateTo({
      url: '/pages/teacher_custom_page1/page1'
    })
  },

  buttonList: function (e) {
    var that = this
    // console.log(getApp().globalData.server + '/cqcq/public/index.php/api/Draw/draw')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/Draw/draw',
      data: {
        numOfBoys: that.data.Boys_name,
        numOfGirls: that.data.Girls_name,
        department: that.data.dep,
        grade: that.data.grade
      },
      method: "POST",
      header: {
        'content-type': 'application/x-www-form-urlencoded'
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
          that.setData({
            Listdata: res.data.data.dorm
          })
          wx.navigateTo({
            url: '/pages/teacher_extract_page2/page2?listData=' + JSON.stringify(that.data.Listdata)
          })
          // console.log(that.data.Listdata)
          // wx.showModal({
          //   title: "提示：",
          //   content: '抽取成功！',
          //   showCancel: false,
          //   success(res) {},
          //   complete: function (res) {
          //     wx.navigateTo({
          //       url: '/pages/teacher_extract_page2/page2?listData=' + JSON.stringify(that.data.Listdata)
          //     })
          //   },
          // })
        }
      },
      fail: function () {
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {}
        })
      }
    })

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      grade: getApp().globalData.user.grade,
      dep: getApp().globalData.user.department
    })
    //传最大宿舍号
    var that = this
    console.log(getApp().globalData.server + '/cqcq/public/index.php/api/draw/getNumber')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/draw/getNumber',
      data: {
        numOfBoys: that.data.Boys_name,
        numOfGirls: that.data.Girls_name,
        department: that.data.dep,
        grade: that.data.grade
      },
      method: "POST",
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success(res) {
        if (res.data.error_code == 2) {
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {},
            complete: function (res) {
              wx.navigateBack({
                delta: 1
                })
              /*wx.reLaunch({
                url: '/pages/teacher_home/teacher_home',
              })*/
            }
          })
          that.setData({
            Boys_max: 0,
            Girls_max: 0,
            Boys_name: 0,
            Girls_name: 0,
          })
        } else if (res.data.error_code != 0) {
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {}
          })
        } else if (res.data.error_code == 0) {
          // console.log(res.data.data.girls)
          that.setData({
            Boys_max: res.data.data.boys,
            Girls_max: res.data.data.girls
          })
          if (res.data.data.girls == 0) {
            that.setData({
              Girls_name: 0,
            })
          } else if (res.data.data.boys == 0) {
            that.setData({
              Boys_name: 0,
            })
          }
          if (res.data.data.boys < that.data.Boys_name) {
            that.setData({
              Boys_name: res.data.data.boys,
            })
          }
          if (res.data.data.girls < that.data.Girls_name) {
            that.setData({
              Girls_name: res.data.data.girls,
            })
          }
        }
      },
      fail: function () {
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {}
        })
      }
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