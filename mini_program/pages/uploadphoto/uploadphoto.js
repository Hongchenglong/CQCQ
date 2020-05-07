Page({

  /** 页面的初始数据*/
  data: {

    pics: [],
    isShow: true
  },

  /**上传图片 */
  uploadImage: function () {
    var that = this;
    let pics = that.data.pics;
    wx.chooseImage({
      count: 1 - pics.length,
      sizeType: ['original', 'compressed'],
      sourceType: ['album', 'camera'],
      success: function (res) {
        var imgSrc = res.tempFilePaths;
         upload(that,  imgSrc); //连接接口 函数
        pics.push(imgSrc);
        if (pics.length >= 1) {
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
  deleteImg: function (e) {
    let that = this;
    let deleteImg = e.currentTarget.dataset.img;
    let pics = that.data.pics;
    let newPics = [];
    for (let i = 0; i < pics.length; i++) {
      //判断字符串是否相等
      if (pics[i]["0"] !== deleteImg["0"]) {
        newPics.push(pics[i])
      }
    }
    that.setData({
      pics: newPics,
      isShow: true
    })

  },

  /**提交 */
 
  //    globalData:{
  //  id:{},
  //     face_url:{},
  //   server:'https://oeong.xyz/cqcq',
  //   load:'false'
  // },   
})

function upload(page, path) {
  wx.showToast({
  icon: "loading",
  title: "正在上传"
  }),
  wx.uploadFile({
   url:'https://oeong.xyz/cqcq/public/index.php/index/Record/uploadPhoto',
   filePath: path[0], 
   name: 'file',
   header: { enctype:"multipart/form-data" },
   formData: {
   //和服务器约定的token, 一般也可以放在header中
   'session_token': wx.getStorageSync('session_token'),
   'id':'1835',
   'dorm_id':63,
   'file':path[0],
   },
   success: function (res) {
   console.log(res);
   console.log(res.data[14]);
   if (res.statusCode != 200) { 
    wx.showModal({
    title: '提示',
    content: '上传失败',
    showCancel: false
    })
    return;
   }else if(res.data[14] == 0){
    wx.showModal({
      title: '提示',
      content: '上传成功！',
      showCancel: false,
      success:function(res) {},
              complete: function(res){
              	wx.navigateTo({
                  url: '../student_picupload/student_picupload',
              	})
              }
      })
      return;
   }else if(res.data[14] == 2){
    wx.showModal({
      title: '提示',
      content: '不在查寝时间！',
      showCancel: false
      
      })
      return;

   }else{
    wx.showModal({
      title: '提示',
      content: '上传失败！',
      showCancel: false
      })
      return;
   }
   },
   fail: function (e) {
   console.log(e);
   wx.showModal({
    title: '提示',
    content: '上传失败',
    showCancel: false
   })
   },
   complete: function () {
    wx.hideToast(); //隐藏Toast
    }
   })
  }
