// pages/student_bottom/student_bottom.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    current: 'homepage'
  },

  handleChange({ detail }) {
    this.setData({
      current: detail.key
    });
  }

})