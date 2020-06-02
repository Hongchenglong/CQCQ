Page({

  /** 页面的初始数据*/
  data: {
    pics: [],
    isShow: true,

  },

  Img: function () {
    var that = this;

    var imgSrc = getApp().globalData.imgSrc;

    if (imgSrc != '') {
      upload(that, imgSrc);
    } else {
      wx.showToast({
        title: '照片不能为空',
        icon: 'none',
        duration: 1000
      })
    }




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
        var imgSrc = '';
        var imgSrc = res.tempFilePaths;

        getApp().globalData.imgSrc = imgSrc;
        // upload(that, imgSrc); //连接接口 函数
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

      isShow: true,

    })
    getApp().globalData.imgSrc = ''
  },

  /**提交 */

})

function upload(page, path) {
  wx.showToast({
      icon: "loading",
      title: "正在上传"
    }),
    wx.uploadFile({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Record/uploadPhoto',
      filePath: path[0],
      name: 'file',
      header: {
        enctype: "multipart/form-data"
      },
      formData: {
        //和服务器约定的token, 一般也可以放在header中
        'session_token': wx.getStorageSync('session_token'),
        'grade': getApp().globalData.user.grade,
        'department': getApp().globalData.user.department,
        // 'dorm_id': getApp().globalData.userInfomation.roomInfo[0].id,
        'file': path[0],
        'dorm_num': getApp().globalData.dorm_num,
        'rand_num': getApp().globalData.rand_num,
        'end_time': getApp().globalData.end_time,
        'start_time': getApp().globalData.start_time
      },

      success: function (res) {
        console.log(res);
        console.log(getApp().globalData.rand_num)
        console.log(getApp().globalData.dorm_num)
        console.log(res.data[14]);
        if (res.statusCode != 200) {
          wx.showModal({
            title: '提示',
            content: '上传失败',
            showCancel: false
          })
          return;
        } else if (res.data[14] == 0) {
          wx.showModal({
            title: '提示',
            content: '上传成功！',
            showCancel: false,
            success: function (res) {
              if (res.confirm) {
                console.log('用户点击确定')
                // wx.navigateTo({
                //   url: '../student_details/student_details?time=' + getApp().globalData.start_time + "&&endtime=" + getApp().globalData.end_time
                // })
                wx.navigateBack({
                  delta: 1
                })
              }
            },
          })
          return;
        } else if (res.data[14] == 2) {
          console.log('res.data', res.data)
          wx.showModal({
            title: '提示',
            content: '现在不在查寝时间！',
            showCancel: false
          })
          return;
        } else if (res.data[14] == 3) {
          wx.showModal({
            title: '提示',
            content: '您不在查寝名单中！',
            showCancel: false
          })
          return;
        } else if (res.data[14] == 6) {
          wx.showModal({
            title: '提示',
            content: '文件格式错误！请上传照片。',
            showCancel: false
          })
          return;
        } else if (res.data[14] == 1) {
          wx.showModal({
            title: '提示',
            content: '请上传照片',
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