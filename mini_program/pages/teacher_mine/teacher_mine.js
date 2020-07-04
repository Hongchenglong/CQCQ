// pages/teacher_mine/teacher_mine.js
//const { $Message } = require('../../dist/base/index');

Page({
    /**
   * 页面的初始数据
   */
  data: {
    current: 'mine',
    modalHidden:true,//是否隐藏对话框
    username: '',
    grade: '',
    department: ''
  },

  handleChange ({ detail }) {
    this.setData({
        current: detail.key
    });
    /*if(detail.key == 'mine'){
      console.log(getApp().globalData.load)
      if(  getApp().globalData.load == false ){
        wx.navigateTo({
          url: '/pages/load/load'
        })
      } else {
        wx.redirectTo({
          url: '../teacher_mine/teacher_mine',
        })
      }
    }else*/ if(detail.key == 'group'){
      wx.reLaunch({
        url: '../teacher_dorm/teacher_dorm',
      })
    }
    else if(detail.key == 'homepage'){
      wx.reLaunch({
        url: '../teacher_home/teacher_home',
      })
    }
},

/*changeImage:function(){
  wx.navigateTo({
    url: '../image/image',
  })
},
changeName:function(){
  wx.navigateTo({
    url: '../name/name',
  })
},
turnLogin:function(){
  wx.redirectTo({
    url: '../login/login',
  })
},*/

  

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
    getApp().globalData.pagetwo=2
    this.setData({
      username: getApp().globalData.user.username,
      grade: getApp().globalData.user.grade,
      department: getApp().globalData.user.department
    })
    console.log("onShow")
    //wx.hideHomeButton()
    //console.log("mine")
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
    show: function() {
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
    modalHidden:true,//是否隐藏对话框
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
    methods: {
      /// 显示 actionsheet
      show: function() {
        console.log(456)
      },
    },

    to_info:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../teacher_information/teacher_information" 
      })
      wx.hideLoading()
    },

    to_pass:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../revise_password/revise_password"
      })
      wx.hideLoading()
    },

    to_mail:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../revise_email/revise_email"
      })
      wx.hideLoading()
    },

    to_phone:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../revise_phone/revise_phone"
      })
      wx.hideLoading()
    },

    to_re:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../recycle/recycle"
      })
      wx.hideLoading()
    },

    to_about:function(){
      wx.showLoading({
        title: '加载中',
        mask: true,
      })
      wx.navigateTo({
        url:"../revise_about/revise_about"
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
    bindViewTap: function() {
      this.setData({
        modalHidden:!this.data.modalHidden
      })
    },
        
    //事件处理函数
    bindViewTap: function() {
      /*this.setData({
        modalHidden:!this.data.modalHidden
      })*/
      wx.showModal({
        title: '退出登录',
        content: '确认退出登录？',
        confirmColor:"#FF0000",
        success (res) {
          if (res.confirm) {
            //点击确认退出
            wx.reLaunch({
              url: '../login/login',
            })
          } else if (res.cancel) {
            //点击取消
            console.log('用户点击取消')
          }else {
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
