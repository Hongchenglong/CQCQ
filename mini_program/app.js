//app.js
App({
  onLaunch: function () {
    wx.getSystemInfo({
      success: e => {
        this.globalData.StatusBar = e.statusBarHeight;
        let capsule = wx.getMenuButtonBoundingClientRect();
        if (capsule) {
          this.globalData.Custom = capsule;
          this.globalData.CustomBar = capsule.bottom + capsule.top - e.statusBarHeight;
        } else {
          this.globalData.CustomBar = e.statusBarHeight + 50;
        }
      }
    })

    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)



    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
      }
    })
    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框

          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo

              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })
  },
  globalData: {
    user: {}, //后台返回用户全部信息
    userInfo: {}, //微信获取用户信息
    // server: 'http://localhost:8080', //域名
    server: 'http://localhost:8080', //域名

    height: '', //手机屏幕高度
    width: '',
    load: false, //判断用户是否授权
    PageCur: '',
    flag: '',
    userInfomation: '',
    name: '',
    grade: '',
    dorm: '',
    block: '',
    room: '',
    department: '',
    de: '',
    imgSrc: '',
    page: 2,
    pagetwo: 2,
    all: {},
    userInfo: null,
    multiArray: [
      ['中一', '中二', '东一', '东二'],
      ['1', '2', '3', '4', '5', '6', '7'],
      ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
        '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
        '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
      ]
    ],
    multiIndex: [0, 0, 0],
    Flag: 1 // 1开 0锁  disable
  }
})