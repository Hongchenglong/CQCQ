// pages/teacher/extract/page2/page2.js
var time_1 = null
var time_2 = null
var now_date = null
//获取当天日期
function getCurrentMonthFirst() {
  var date = new Date();
  var todate = date.getFullYear() + "-" + ((date.getMonth() + 1) < 10 ? ("0" + (date.getMonth() + 1)) : date.getMonth() + 1) + "-" + (date.getDate() < 10 ? ("0" + date.getDate()) : date.getDate());
  now_date = todate
  return todate;
}
var time_1 = null
var time_2 = null
Page({
  /**
   * 页面的初始数据
   */
  data: {
    dep: '',
    grade: '',
    date_1: getCurrentMonthFirst(),
    weekday: '',
    week: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
    time1: '22:30',
    time2: '22:45',
    listData: [],
    idList:[],
    blockList:[],
    randList:[],
  },
  //设置开始时间
  bindTimeChange1: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    time_1 = e.detail.value
    this.setData({
      time1: e.detail.value
    })
  },
  //设置截止时间
  bindTimeChange2: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    time_2 = e.detail.value
    this.setData({
      time2: e.detail.value
    })
  },
  //跳转页面
  buttonchange: function (e) {
    wx.reLaunch({
      url: '/pages/teacher_custom_page1/page1'
    })
  },
  //确认
  buttonListener: function (e) {
    var that = this
    if (time_1 == null) {
      time_1 = '22:30'
    }
    if (time_2 == null) {
      time_2 = '22:45'
    }
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/draw/verifyResults',
      data: {
        department: that.data.dep,
        grade: that.data.grade,
        start_time: that.data.date_1 + " " + that.data.time1,
        end_time: that.data.date_1 + " " + that.data.time2,
        dorm_id:that.data.idList,
        rand_num:that.data.randList
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
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {},
            complete: function (res) {
              wx.reLaunch({
                url: '/pages/teacher_extract_page3/page3?dateData=' + now_date + '&weekData=' + that.data.weekday + '&time1Data=' + that.data.time1 + '&time2Data=' + that.data.time2
              })
            }
          })
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
    var List = JSON.parse(options.listData);
    var newList = []
    var IdList = []
    var BlockList = []
    var RandList = []
    // console.log("List:",this.data.listData)
    for (var i = 0; i < List.length; i++) {
      IdList.push(List[i].id)
      BlockList.push(List[i].dorm_num)
      RandList.push(List[i].rand_num)
      newList.push({'dorm_num': List[i].dorm_num, 'rand_num': List[i].rand_num})
    } 
    this.setData({
      listData: newList,
      idList:IdList,
      blockList:BlockList,
      randList:RandList,
      grade : getApp().globalData.user.grade,
      dep : getApp().globalData.user.department
    })
     console.log("listData:",newList)
     console.log("IdList:",this.data.idList)
     console.log("BlockList:",this.data.blockList)
     console.log("RoomList:",this.data.randList)
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
    //获取星期并转为中文
    var today = new Date().getDay();
    console.log("today:" + today);
    switch (today) {
      case 0:
        this.setData({
          weekday: this.data.week[0]
        })
        break;
      case 1:
      case 2:
      case 3:
      case 4:
      case 5:
      case 6:
        this.setData({
          weekday: this.data.week[today]
        })
        break;
    }
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

  },

})