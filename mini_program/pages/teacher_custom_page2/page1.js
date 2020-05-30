Page({
  data: {
    i: 0,
    select: false,
    hiddenName3: false,
    Block: '-楼号-', //区号输入框里的内容
    Room: '', //室号输入框的内容
    Apart: [], //区号列表
    dep: '',
    grade: '',
    listData: [], //区号+楼号
  },

  bindShowMsg() {
    this.setData({
      select: !this.data.select
    })
  },
  //改变楼号输入框里的内容
  mySelect(e) {
    console.log(e)
    var name = e.currentTarget.dataset.name
    this.setData({
      Block: name,
      select: false
    })
  },
  //改变室号输入框里的内容
  bindKeyInput: function (e) {
    this.setData({
      Room: e.detail.value
    })
  },

  //抽取宿舍
  buttonsubmit: function (e) {
    var that = this
    var List = that.data.listData
    var blockList = []
    var roomList = []
    for (var i = 0; i < List.length; i++) {
      blockList.push(List[i].block)
      roomList.push(List[i].room)
    }
    console.log(getApp().globalData.server + '/cqcq/public/index.php/index/Draw/customize')
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/Draw/customize',
      data: {
        department: that.data.dep,
        grade: that.data.grade,
        block: blockList,
        room: roomList,
      },
      method: "POST",
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success(res) {
        // console.log(res.data)
        if (res.data.error_code != 0) {
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {}
          })
        } else if (res.data.error_code == 0) {
          that.setData({
            listdata: res.data.data.dormSuc
          })
          wx.showModal({
            title: "提示：",
            content: res.data.msg,
            showCancel: false,
            success(res) {},
            complete: function (res) {
              wx.redirectTo({
                url: '/pages/teacher_extract_page2/page2?listData=' + JSON.stringify(that.data.listdata)
              })
            },
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
  },

  // 动态添加宿舍法
  buttonaddList1: function (e) {
    var that = this
    var apart = this.data.Block;
    var num = this.data.Room;
    let list = this.data.listData
    var n = 0; //判断重复标志
    if (apart != '-楼号-' && num != '') {
      for (var i = 0; i < list.length; i++) {
        if (list[i].block == apart && list[i].room == num) {
          n = 1
        }
      }
      if (n == 0) {
        //判断宿舍是否存在
        wx.request({
          url: getApp().globalData.server + '/cqcq/public/index.php/index/Draw/doesItExist',
          data: {
            department: that.data.dep,
            grade: that.data.grade,
            block:apart,
            room:num
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
            } 
            else if (res.data.error_code == 0) { 
              list.push({
                'block': apart,
                'room': num
              })
              that.setData({
                listData: list
              });
            }
          },
          fail: function () {
            wx.showModal({
              title: '哎呀～',
              showCancel: false,
              content: '网络不在状态呢！',
              success(res) {}
            })
          }
        })
      } else {
        wx.showToast({
          title: '提示：选择失败，表中已有该宿舍',
          icon: 'none',
          duration: 2000 //持续的时间
        })
      }
    } else {
      wx.showToast({
        title: '提示：请选择完整的宿舍信息',
        icon: 'none',
        duration: 2000 //持续的时间
      })
    }
  },

  // 动态删除宿舍
  buttonsubList: function (e) {
    var idx = e.currentTarget.dataset.idx;
    var list = this.data.listData;
    var filterRes = list.filter((ele, index) => {
      return index != idx
    })
    this.setData({
      listData: filterRes,
    })
  },

  //清空表
  buttonclearList: function (e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '确定要清空整个列表吗？',
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定')
          that.setData({
            listData: [],
            listblock: [],
            listroom: []
          })
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
    var that = this
    var List = JSON.parse(options.listdata); //抽取结果列表
    var listblock = [] //宿舍区列表
    var newList = []
    var Dorm = ''
    // console.log(List)
    //导入抽取确认界面的列表中的宿舍区号及室号
    for (var i = 0; i < List.length; i++) {
      Dorm = List[i].dorm_num.split("#")
      // console.log("print",Dorm[0],Dorm[1])
      newList.push({
        'block': Dorm[0],
        'room': Dorm[1]
      })
    }
    this.setData({
      listData: newList,
      grade: getApp().globalData.user.grade,
      dep: getApp().globalData.user.department
    })
    //console.log(this.data.grade)
    //console.log(this.data.dep)
    // console.log(getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/getBlock')
    
    // 传区号
    wx.request({
      url: getApp().globalData.server + '/cqcq/public/index.php/index/dormitory/getBlock',
      data: {
        department: that.data.dep,
        grade: that.data.grade,
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
            Apart: listblock
          })
        }
      },
      fail: function () {
        wx.showModal({
          title: '哎呀～',
          showCancel: false,
          content: '网络不在状态呢！',
          success(res) {}
        })
      }
    })
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

})