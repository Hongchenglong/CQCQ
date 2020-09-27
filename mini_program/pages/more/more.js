// pages/more/more.js
import * as echarts from '../../ec-canvas/echarts';

var app = getApp();
let chart = "";
const getPixelRatio = () => {
  let pixelRatio = 0
  wx.getSystemInfo({
    success: function (res) {
      pixelRatio = res.pixelRatio
    },
    fail: function () {
      pixelRatio = 0
    }
  })
  return pixelRatio
}
var dpr = getPixelRatio()
function initOne(chart, day7, dorm7, unsignDorm7) {
  var option = {
    color: ["#edafda", "#516b91"],
    legend: {
      left: 'center',
      z: 100,
      top: 10
    },
    grid: {
      containLabel: true
    },
    tooltip: {
      show: true,
      trigger: 'axis'
    },
    xAxis: {
      type: 'category',
      boundaryGap: false,
      data: day7,
      // axisLabel:{
      //   rotate:40,
      //   interval:0
      // }

    },
    yAxis: {
      x: 'center',
      type: 'value',
      splitLine: {
        lineStyle: {
          type: 'dashed'
        }
      }
    },
    series: [{
      name: '未签到的宿舍数量',
      type: 'line',
      smooth: true,
      data: unsignDorm7
    }, {
      name: '抽到的宿舍数量',
      type: 'line',
      smooth: true,
      data: dorm7
    }]
  };
  chart.setOption(option);
}

Page({
  /**
   * 页面的初始数据
   */
  data: {
    winWidth: 0,
    winHeight: 0,
    // tab切换  
    currentTab: "one",

    grade: '',
    department: '',
    numOfDorm: 0,
    day7: [],
    dorm7: [],
    unsignDorm7: [],
    day30: [],
    dorm30: [],
    unsignDorm30: [],
    unsignStu7: [],
    unsignStu30: [],
    countStu7: [],
    countStu30: [],
    isData: true,

    // 折线图
    ecOne: {
      lazyLoad: true
    },
    ecTwo: {
      lazyLoad: true
    }
  },

  /** 
   * 滑动切换tab 
   */
  // bindChange: function (e) {
  //   var that = this;
  //   that.setData({
  //     currentTab: e.detail.activeKey
  //   });
  //   that.lineInfo()

  // },
  /** 
   * 点击tab切换 
   */
  swichNav: function (e) {

    var that = this;
    that.setData({
      currentTab: e.detail.activeKey
    })
    that.lineInfo()

  },

  /**
   * 获取数据
   */
  lineInfo: function () {
    var that = this;
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/api/getinfo/lineInfo',
      //发给服务器的数据
      data: {
        grade: getApp().globalData.user.grade,
        department: getApp().globalData.user.department,
      },
      method: "POST",
      header: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        // console.log(res);
        if (res.data.error_code != 0) {
          that.setData({
            isData: false
          })
          // wx.showModal({
          //   title: '提示',
          //   content: res.data.msg,
          //   showCancel: false,
          //   success: function (res) { }
          // })
        } else if (res.data.error_code == 0) {
          console.log(res.data.data);
          that.setData({
            numOfDorm: res.data.data.numOfDorm,
            day7: res.data.data.day7,
            dorm7: res.data.data.dorm7,
            unsignDorm7: res.data.data.unsignDorm7,
            day30: res.data.data.day30,
            dorm30: res.data.data.dorm30,
            unsignDorm30: res.data.data.unsignDorm30,
            unsignStu7: res.data.data.unsignStu7,
            unsignStu30: res.data.data.unsignStu30,
            countStu7: res.data.data.countStu7,
            countStu30: res.data.data.countStu30,
          })
          console.log(that.data.currentTab)
          if (that.data.currentTab == "one") {
            that.init_one(that.data.day7, that.data.dorm7, that.data.unsignDorm7);
          } else {
            that.init_two(that.data.day30, that.data.dorm30, that.data.unsignDorm30);
          }
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
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    that.oneComponent = that.selectComponent('#mychart-one');
    that.twoComponent = that.selectComponent('#mychart-two');
    that.setData({
      grade: app.globalData.user.grade,
      department: app.globalData.user.department
    })

    /** 
     * 获取系统信息 
     */
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          winWidth: res.windowWidth,
          winHeight: res.windowHeight
        });
      }
    });
    that.lineInfo();
  },

  //初始化第一个图表
  init_one: function (day7, dorm7, unsignDorm7) {
    this.oneComponent.init((canvas,  width, height) => {
      chart = echarts.init(canvas, null, {
        width: width,
        height: height,
        devicePixelRatio:dpr
      });
      initOne(chart, day7, dorm7, unsignDorm7, "近七天查寝情况")
      this.chart = chart;
      return chart;
    });
  },

  init_two: function (day30, dorm30, unsignDorm30) {
    this.twoComponent.init((canvas, width, height) => {
      chart = echarts.init(canvas, null, {
        width: width,
        height: height,
        devicePixelRatio:dpr
      });
      initOne(chart, day30, dorm30, unsignDorm30, "近三十天查寝情况")
      this.chart = chart;
      return chart;
    });
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