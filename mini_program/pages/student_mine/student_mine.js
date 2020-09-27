// pages/student_mine/student_mine.js
const app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    current: 'mine',
    modalHidden: true, //是否隐藏对话框
    grade: '',
    department: '',
  },

  handleChange({
    detail
  }) {
    this.setData({
      current: detail.key
    });
    if (detail.key == 'mine') {
      wx.redirectTo({
        url: '../student_mine/student_mine',
      })
    } else {
      wx.redirectTo({
        url: '../student_home/student_home',
      })
    }
  },

  //退出登录
  turnLogin: function () {
    wx.redirectTo({
      url: '',
    })
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
    this.setData({
      username: getApp().globalData.user.username,
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
    })
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

Component({

  pageLifetimes: {
    show: function () {
      // 页面被展示时刷新
      this.setData({
        username: getApp().globalData.user.username,
        grade: getApp().globalData.user.grade,
        department: getApp().globalData.user.department
      })
      //console.log("show")
      wx.hideLoading()
      wx.hideHomeButton()
    },
  },

  data: {
    current: 'mine',
    modalHidden: true, //是否隐藏对话框
    username: '',
    grade: '',
    department: '',
  },
  attached() {
    this.setData({
      username: getApp().globalData.user.username,
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department,
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
    CopyLink(e) {
      wx.setClipboardData({
        data: e.currentTarget.dataset.link,
        success: res => {
          wx.showToast({
            title: '已复制',
            duration: 1000,
          })
        }
      })
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
    showQrcode() {
      wx.previewImage({
        urls: ['https://image.weilanwl.com/color2.0/zanCode.jpg'],
        current: 'https://image.weilanwl.com/color2.0/zanCode.jpg' // 当前显示图片的http链接      
      })
    },
    methods: {
      /// 显示 actionsheet
      show: function () {
        console.log(456)
      },
    },
    
    to_situation:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../situation/situation"
      })
      wx.hideLoading()
    },

    to_info:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url: '../revise_information/revise_information',
      })
    },

    to_safe:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../safe/safe"
      })
      wx.hideLoading()
    },

    to_about:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url: '../revise_about/revise_about',
      })
    },

    //点击加载样式
    click: function () {
      //加载中的样式
      wx.showLoading({
        title: '加载中',
        mask: true,
        duration: 5000
      })
      /*wx.showToast({
        title: '加载中...',
        mask: true,
        icon: 'loading',
        duration: 500
      })*/
    },
    //事件处理函数
    bindViewTap: function () {
      this.setData({
        modalHidden: !this.data.modalHidden
      })
    },

    //事件处理函数
    bindViewTap: function () {
      /*this.setData({
        modalHidden:!this.data.modalHidden
      })*/
      wx.showModal({
        title: '退出登录',
        content: '确认退出登录？',
        confirmColor: "#FF0000",
        success(res) {
          if (res.confirm) {
            //点击确认退出
            wx.reLaunch({
              url: '../login/login',
            })
          } else if (res.cancel) {
            //点击取消
            console.log('用户点击取消')
          } else {
            //异常
            wx.showLoading({
              title: '系统异常',
              fail
            })
            setTimeout(function () {
              wx.hideLoading()
            }, 2000)
          }

        }
      })
    },
  }
})