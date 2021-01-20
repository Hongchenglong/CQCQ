// pages/safe/safe.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

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

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})

Component({

  pageLifetimes: {
    show: function () {
      // 页面被展示时刷新
      this.setData({
        username: getApp().globalData.user.username,
        grade: getApp().globalData.user.grade,
        department: getApp().globalData.user.department
      })
      console.log("show")
      wx.hideLoading()
    },
  },

  data: {
    current: 'mine',
    modalHidden: true, //是否隐藏对话框
    username: '',
    grade: '',
    department: ''
  },
  attached() {
    this.setData({
      username: getApp().globalData.user.username,
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
    })
  },

  methods: {
    coutNum(e) {
      if (e > 1000 && e < 10000) {
        e = (e / 1000).toFixed(1) + 'k'
      }
      if (e > 10000) {
        e = (e / 10000).toFixed(1) + 'W'
      }
      return e
    },

    showModal(e) {
      this.setData({
        modalName: e.currentTarget.dataset.target
      })
    },
    hideModal(e) {
      this.setData({
        modalName: null
      })
    },
    methods: {
      /// 显示 actionsheet
      show: function () {
        console.log(456)
      },
    },
    // 绑定微信
    to_weixin: function () {
      var that = this
      wx.login({
        success: function (res) {
          console.log("code: ", res.code)
          wx.request({
            url: getApp().globalData.server + '/cqcq/public/index.php/api/user/wxbinding',
            data: {
              code: res.code,
              id: getApp().globalData.user.id,
              user: getApp().globalData.user.user,
            },
            method: "POST",
            header: {
              "Content-Type": "application/x-www-form-urlencoded"
            },
            success: function (res) {
              if (res.data.error_code != 0) {
                wx.showModal({
                  title: '提示！',
                  content: res.data.msg,
                  confirmColor: '#7EC4F8',
                  showCancel: false,
                  success(res) {}
                })
              } else if (res.data.error_code == 0) {
                wx.showModal({
                  title: '提示！',
                  content: res.data.msg,
                  confirmColor: '#7EC4F8',
                  showCancel: false,
                  success(res) {}
                })
              }
            },
          })
        }
      })
    },

    to_pass: function () {
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url: "../revise_password/revise_password"
      })
      wx.hideLoading()
    },

    to_mail: function () {
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url: "../revise_email/revise_email"
      })
      wx.hideLoading()
    },

    to_phone: function () {
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url: "../revise_phone/revise_phone"
      })
      wx.hideLoading()
    },

    //点击加载样式
    click: function () {
      //加载中的样式
      wx.showLoading({
        title: '加载中',
        mask: true,
        duration: 5000
      })
    },

    //事件处理函数
    bindViewTap: function () {
      this.setData({
        modalHidden: !this.data.modalHidden
      })
    },

  }
})