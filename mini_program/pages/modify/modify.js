var app = getApp() 
Page({
  //昵称：
  data: {
    hiddenmodalput: true,
   
    
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
},
//点击按钮痰喘指定的hiddenmodalput弹出框 
modalinput: function() {

    this.setData({
      config:{
         tipsshow:"block"
       }, 
      hiddenmodalput: !this.data.hiddenmodalput,
    })
},
//取消按钮 
cancel: function() {
    this.setData({
      config:{
        tipsshow:"none"
      },
        hiddenmodalput: true,
       
    });
},
//确认 
confirm: function() {
    this.setData({
      config:{
        tipsshow:"none"
      },
      hiddenmodalput: true,
    
    })
},
getInput:function(e){
  const that = this;
  let gr1;
 
  that.setData({
    gr1    :    e.detail.value,
   
  })
},
  // 年级
data2: {
    hiddenmodalput2:true,
    //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
},
//点击按钮痰喘指定的hiddenmodalput弹出框 
modalinput2: function() {
    this.setData({
      config1:{
        tipsshow:"block"
      },
        hiddenmodalput2: !this.data2.hiddenmodalput2
    });
},
//取消按钮 
cancel2: function() {
    this.setData({
      config1:{
        tipsshow:"none"
      },
        hiddenmodalput2: true
    });
},
//确认 
confirm2: function() {
    this.setData({
      config1:{
        tipsshow:"none"
      },
        hiddenmodalput2: true
    });
},
getInput2:function(e){
  const that = this;
  let gr2;
  that.setData({
    gr2    :    e.detail.value
  })
},
//系
data3: {
  hiddenmodalput3:true,
  
  //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
},
//点击按钮痰喘指定的hiddenmodalput弹出框 
modalinput3: function() {
  this.setData({
    config2:{
      tipsshow:"block"
    },
      hiddenmodalput3:! this.data3.hiddenmodalput3
  })
},
//取消按钮 
cancel3: function() {
  this.setData({
    config2:{
      tipsshow:"none"
    },
      hiddenmodalput3: true
  });
},
//确认 
confirm3: function() {
  this.setData({
    config2:{
      tipsshow:"none"
    },
      hiddenmodalput3: true
  })
},
getInput3:function(e){
const that = this;
let gr3;
that.setData({
  gr3   :    e.detail.value
})
},
//宿舍
data4: {
  hiddenmodalput4: true,
  
  //可以通过hidden是否掩藏弹出框的属性，来指定那个弹出框 
},
//点击按钮痰喘指定的hiddenmodalput弹出框 
modalinput4: function() {
  this.setData({
    config3:{
      tipsshow:"block"
    },
      hiddenmodalput4: !this.data4.hiddenmodalput4
  })
},
//取消按钮 
cancel4: function() {
  this.setData({
    config3:{
      tipsshow:"none"
    },
      hiddenmodalput4: true
  })
},
//确认 
confirm4: function() {
  
  this.setData({
    config3:{
      tipsshow:"none"
    },
      hiddenmodalput4: true
  })
},
getInput4:function(e){
const that = this;
let gr4;
that.setData({
  gr4   :    e.detail.value
})
}
 

   })
   

