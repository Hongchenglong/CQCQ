Page({
 
  /** 页面的初始数据*/
  data: {
   
    pics:[],
    isShow: true
  },
 
  /**上传图片 */
  uploadImage:function(){
    let that=this;
    let pics = that.data.pics;
    wx.chooseImage({
      count:1 - pics.length,
      sizeType: ['original', 'compressed'], 
      sourceType: ['album', 'camera'], 
      success: function(res) {
        let imgSrc = res.tempFilePaths;
         pics.push(imgSrc);
        if (pics.length >= 1){
          that.setData({
            isShow: false
          }) 
        }
       that.setData({
          pics: pics
        })
      },
    })
 
  },
 
  /**删除图片 */
  deleteImg:function(e){
    let that=this;
    let deleteImg=e.currentTarget.dataset.img;
    let pics = that.data.pics;
    let newPics=[];
    for (let i = 0;i<pics.length; i++){
     //判断字符串是否相等
      if (pics[i]["0"] !== deleteImg["0"]){
        newPics.push(pics[i])
      }
    }
    that.setData({
      pics: newPics,
      isShow: true
    })
    
  },
 
  /**提交 */
  submitAdvice:function(){
    let that=this;
   
    
  },
  onLaunch: function () {
    wx.showToast({
      title: '提交成功！',
      icon: 'success',
      duration: 2000//持续的时间
    })
  }
})