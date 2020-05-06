// pages/page2/page2.js
var now_date = null
//获取当天日期
function getCurrentMonthFirst() {
  var date = new Date();
  var todate = date.getFullYear() + "-"
    + ((date.getMonth() + 1) < 10 ? ("0" + (date.getMonth() + 1)) : date.getMonth() + 1) + "-"
    + (date.getDate() < 10 ? ("0" + date.getDate()) : date.getDate() + " ") + " "
    + date.getHours() + ":"
    + date.getMinutes() + ":"
    + date.getSeconds();
  now_date = todate
  return todate;
}
Page({
  /**
   * 页面的初始数据
   */

  data: {
    date_1: getCurrentMonthFirst(),
    weekday: '',
    week: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
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

})