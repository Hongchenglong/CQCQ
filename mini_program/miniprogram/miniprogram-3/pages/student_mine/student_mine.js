// pages/student_mine/student_mine.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'mine',
    modalHidden: true,//是否隐藏对话框
    pics: '/images/camera.png'

  },

  handleChange({ detail }) {
    this.setData({
      current: detail.key
    });
    if (detail.key == 'mine') {
      wx.redirectTo({
        url: '../student_mine/student_mine',
      })
    
    }
    else {
      wx.redirectTo({
        url: '../student_home/student_home',
      })
    }
  },


  //跳转至修改昵称
  changeName: function () {
    wx.navigateTo({
      url: '../revise_information/revise_information',
    })
  },

  //退出登录
  turnLogin: function () {
    wx.redirectTo({
      url: '',
    })
  },

  //事件处理函数
  bindViewTap: function () {
    this.setData({
      modalHidden: !this.data.modalHidden
    })
  },

  //事件处理函数
  bindViewTap: function () {
    /*this.setData({
      modalHidden:!this.data.modalHidden
    })*/
    wx.showModal({
      title: '退出登录',
      content: '确认退出登录？',
      confirmColor: "red",
      success(res) {
        if (res.confirm) {
          //点击确认退出
          wx.redirectTo({
            url: '',
          })
        } else if (res.cancel) {
          //点击取消
          console.log('用户点击取消')
        } else {
          //异常
          wx.showLoading({
            title: '系统异常',
            fail
          })
          setTimeout(function () {
            wx.hideLoading()
          }, 2000)
        }

      }
    })
  },

  //上传头像
  uploadImage: function () {
    var that = this;
    let pics = that.data.pics;
    wx.chooseImage({
      count: 1 - pics.length,
      sizeType: ['original', 'compressed'],
      sourceType: ['album', 'camera'],
      success: function (res) {
        console.log(res.tempFilePaths)
        var imgSrc = res.tempFilePaths;
        upload(that, imgSrc[0]); //连接接口 函数
        pics = imgSrc[0]
        // pics.push(imgSrc);
        // if (pics.length >= 1) {
        //   that.setData({
        //     isShow: false
        //   })
        // }
        that.setData({
          pics: pics
        })
      },
    })

  },

  globalData: {
    id: {},
    face_url: {},
    server: 'https://oeong.xyz/cqcq',
    load: 'false'
  },
})
function upload(page, path) {
  wx.showToast({
    icon: "loading",
    title: "正在上传"
  }),
    wx.uploadFile({
      url: 'https://oeong.xyz/cqcq/public/index.php/index/Record/uploadfaceurl',
      filePath: path,
      name: 'file',
      header: { enctype: "multipart/form-data" },
      formData: {
        //和服务器约定的token, 一般也可以放在header中
        'session_token': wx.getStorageSync('session_token'),
        'id': 211706001,
        'file': path
      },
      success: function (res) {
        console.log(res);
        if (res.statusCode != 200) {
          wx.showModal({
            title: '提示',
            content: '上传失败',
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

