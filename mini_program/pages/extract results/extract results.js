var time_1=null
var time_2=null
var now_date = null 
//获取当天日期
function getCurrentMonthFirst() {
  var date = new Date();
  var todate = date.getFullYear() + "年" + ((date.getMonth() + 1) < 10 ? ("0" + (date.getMonth() + 1)) : date.getMonth()+1) + "月" + (date.getDate() < 10 ? ("0" + date.getDate()) : date.getDate()+ "日");
  now_date = todate
  return todate;
}
var time_1=null
var time_2=null
Page({
  /**
   * 页面的初始数据
   */

  data: {
    date_1:getCurrentMonthFirst(),
    weekday: '',
    week: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
    time1:'22:30',
    time2:'22:45',
    listData: [
      { "hostel": "中二#117", "no": "5"},
      { "hostel": "东二#413", "no": "6"},
      { "hostel": "中二#201", "no": "7"},
      { "hostel": "中二#222", "no": "8"},
      { "hostel": "东二#416", "no": "9"},
      { "hostel": "中二#303", "no": "10"}
    ]
    },
  //设置开始时间
  bindTimeChange1: function(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    time_1=e.detail.value
    this.setData({
      time1: e.detail.value
    })
  },
  //设置截止时间
  bindTimeChange2: function(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    time_2=e.detail.value
    this.setData({
      time2: e.detail.value
    })
  },

  onShow: function () {
    //获取星期并转为中文
    var today=new Date().getDay(); 
    console.log("today:"+today);
   switch (today){
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
  }
})