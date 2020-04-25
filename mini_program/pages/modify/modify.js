var app = getApp() 
Page({
  //跳转页面到昵称修改
  goToMypage:function(){
    wx.navigateTo({
      url:"../modify/nicheng/nicheng"
    })
  },
  data: {
    hiddenmodalput: true,
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
},
//点击按钮痰喘指定的hiddenmodalput弹出框 
modalinput: function() {
    this.setData({
        hiddenmodalput: !this.data.hiddenmodalput
    })
},
//取消按钮 
cancel: function() {
    this.setData({
        hiddenmodalput: true
    });
},
//确认 
confirm: function() {
    this.setData({
        hiddenmodalput: true
    })
},
getInput:function(e){
  const that = this;
  let gr1;
  that.setData({
    gr1    :    e.detail.value.gre
  })
}
   })
   

