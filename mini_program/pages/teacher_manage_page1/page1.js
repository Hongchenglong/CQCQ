// pages/teacher/manage/page1/page1.js
Page({

  data: {
    select: false,
    types_name: '--请选择--',
    types: [],
    listData: [],
    grades:'',
    dept:''

  },
  bindShowMsg() {
    var that = this
    var listblock = []
    // console.log(getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/getBlock')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/getBlock',
      data: {
        department: that.data.dept,
        grade: that.data.grades,
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
        } 
        else if (res.data.error_code == 0) { 
          for(var i=0;i<res.data.data.length;i++){
            listblock.push(res.data.data[i].block)
          }
          that.setData({
            types:listblock
          })
        }
      },
      fail: function () {
        console.log(res)
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {}
        })
      }
    })
    this.setData({
      select: !this.data.select
    })
  },
  mySelect(e) {
    var that = this
    console.log(e)
    var name = e.currentTarget.dataset.name
    this.setData({
      types_name: name,
      select: false
    })
    // console.log(getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/examine')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/examine',
      data: {
        department: that.data.dept,
        grade: that.data.grades,
        block: name,
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
            listData: res.data.data
          })
        }
      },
      fail: function () {
        console.log(res)
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
      grades : getApp().globalData.user.grade,
      dept : getApp().globalData.user.department
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