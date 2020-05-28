const app = getApp();
Page({
  data: {
    StatusBar: app.globalData.StatusBar,
    CustomBar: app.globalData.CustomBar,
    /*ColorList: app.globalData.ColorList,*/
    CustomBar: app.globalData.CustomBar ? app.globalData.StatusBar + 44 : app.globalData.CustomBar,
    height:''
  },
  onLoad: function () { },
  pageBack() {
    wx.navigateBack({
      delta: 1
    });
  },
  onShow:function(){
    this.setData({
      height : getApp().globalData.height
    })
  }
});