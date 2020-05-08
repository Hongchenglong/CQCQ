// pages/teacher/manage/page2/page2.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    grade: '',
    dep: '',
    no: '',
    sex: '男',
    block: '',
    room: '',
    listSex: ['男', '女'],
    listData: [],
    //选择的楼号范围
    listBlock: []
  },


  bindViewEvent: function (e) {
    console.log(e.detail.value)
    //app.process(this,e);    
  },

  bindKeyInput1: function (e) {
    this.setData({
      grade: e.detail.value
    })
  },
  bindKeyInput2: function (e) {
    this.setData({
      dep: e.detail.value
    })
  },
  bindKeyInput3: function (e) {
    this.setData({
      no: e.detail.detail.value
    })
    //console.log('no：',e.detail.detail.value)
  },

  //获取性别
  bindKeyInput4: function (e) {
    this.setData({
      sex: e.detail.value
    })
    //console.log('sex：',e.detail.value)
  },

  //获取宿舍楼
  bindKeyInput5: function (e) {
    var that = this
    this.setData({
      block: that.data.listBlock[e.detail.value]
    })
    //console.log('block：',that.data.block)
  },

  //获取宿舍号
  bindKeyInput6: function (e) {
    this.setData({
      room: e.detail.detail.value
    })
    //console.log('room',e.detail.value)
  },

  //点击添加
  buttonaddList: function (e) {
    var that = this;
    let list = this.data.listData;
    var Grade = this.data.grade;
    var Dep = this.data.dep;
    var No = this.data.no;
    var Sex = this.data.sex;
    var Block = this.data.block;
    var Room = this.data.room;
  //---------------------------------------------添加到数据库 -------------------------------------------
    console.log(getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/insert')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/insert',
      data: {
        grade: Grade,
        department: Dep,
        room: Room,
        block: Block,
        sex: Sex,
        studentId: No
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
          list.push({'grade': Grade, 'dep': Dep, 'no': No, 'sex': Sex, 'block': Block, 'room': Room})
          wx.showModal({
              title: "添加成功！",
              content: "账号密码默认为学号",
              showCancel: false,
              success(res) {},
            }),
            that.setData({
              listData: list
            });
        }
      },
      fail: function () {
        console.log(res)
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {},
        })
      }
    })
    //-------------------------------------------------------------------------
  },

  //删除
  buttondelete: function (e) {
    var that = this;
    var idx = e.currentTarget.dataset.idx;
    var list = that.data.listData;
    console.log("idx:",idx)
    console.log("list:",list[idx].no)
    wx.showModal({
      title: '提示',
      content: '确定要删除这个宿舍吗？',
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定')
          //---------------------------------------------从数据库删除 -------------------------------------------
          console.log(getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/delete')
          wx.request({
            url: getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/delete',
            data: {
              grade: list[idx].grade,
              department: list[idx].dep,
              room: list[idx].room,
              block: list[idx].block,
              sex: list[idx].sex,
              studentId: list[idx].no
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
                //----------从数据库中删除-------
                wx.showModal({
                  title: "提示：",
                  content: res.data.msg,
                  showCancel: false,
                  success(res) {},
                })
                var filterRes = list.filter((ele, index) => {
                  return index != idx
                })
                that.setData({
                  listData: filterRes
                })
              }
            },
            fail: function () {
              wx.showModal({
                title: '哎呀～',
                showCancel: false,
                content: '网络不在状态呢！',
                success(res) {},
              })
            }
          })
          //-------------------------------------------------------------------------
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //传系别，年级
    this.setData({
      grade: getApp().globalData.user.grade,
      dep: getApp().globalData.user.department
    })
    //传区号
    var that = this
    var listblock = []
    // console.log(getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/getBlock')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/getBlock',
      data: {
        department: this.data.dep, //需要传全局变量
        grade: this.data.grade,
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
          for (var i = 0; i < res.data.data.length; i++) {
            listblock.push(res.data.data[i].block)
          }
          that.setData({
            listBlock: listblock
          })
        }
      },
      fail: function () {
        console.log(res)
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {}
        })
      }
    })
    //列表自适应
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

  }
})