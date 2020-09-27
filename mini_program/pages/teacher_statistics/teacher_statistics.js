// pages/teacher_statistics/teacher_statistics.js
Page({

    /**
     * 页面的初始数据
     */
    data: {

    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {

    },

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function () {},

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {},

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

Component({
    //初始默认为当前日期
    properties: {
        defaultValue: {
            type: String,
            value: ''
        },
        //星期数组
        weekText: {
            type: Array,
            value: ['日', '一', '二', '三', '四', '五', '六']
        },
        lastMonth: {
            type: String,
            value: '◀'
        },
        nextMonth: {
            type: String,
            value: '▶'
        }
    },

    // 组件的初始数据
    data: {
        //当月格子
        thisMonthDays: [],
        //上月格子
        empytGridsBefore: [],
        //下月格子
        empytGridsAfter: [],
        //显示日期
        title: '',
        //格式化日期
        format: '',

        year: 0,
        month: 0,
        date: 0,
        date2: 0,
        toggleType: 'large',
        scrollLeft: 0,
        //常量 用于匹配是否为当天
        YEAR: 0,
        MONTH: 0,
        DATE: 0,
        dates: '',

        // 签到情况
        listData: [],
        sign_num: 0,
        unsign_num: 0,
        days: [],
        unsign_percent: 0,
        sign_percent: 0,

        // 记录
        recordDay: [],
        flag: '',
        isShow: false,
        sign: false
    },

    ready: function () {
        this.today();
    },

    //页面初次加载时的数据加载
    attached() {
        console.log("attached")
        // 页面被展示时刷新
        var that = this;
        wx.request({
            url: getApp().globalData.server + '/cqcq/public/index.php/api/Resultsday/getDay',
            //发给服务器的数据
            data: {
                grade: 2017,
                department: '计算机工程系'
            },
            method: "POST",
            header: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            success: function (res) {
                if (res.data.error_code != 0) {
                    wx.showModal({
                        title: '提示',
                        content: res.data.msg,
                        showCancel: false,
                        success: function (res) {}
                    })
                    // console.log(res);
                } else {
                    that.setData({
                        days: res.data.data.day
                    })
                    // console.log(that.data.days);
                }
                that.data.flag = that.data.year + '-' + that.zero(that.data.month) + '-' + that.zero(that.data.date)
                // console.log("ready", that.data.flag)
                that.exists(that.data.flag, that.data.year, that.data.month, that.data.date)
                // console.log(that.data.isShow)
            },
        })
        // this.data.flag = year + '-' + this.zero(month) + '-' + this.zero(date)
        // console.log(this.data.flag)
        // this.exists(this.data.flag, this.data.year, this.data.month, this.data.date)
    },

    methods: {
        //切换展示
        toggleType() {
            console.log(this.data.toggleType)
            this.setData({
                toggleType: this.data.toggleType == 'mini' ? 'large' : 'mini'
            })
            console.log("监听")
            //初始化日历组件UI
            this.display(this.data.year, this.data.month, this.data.date);
        },
        //滚动模式
        //当年当月当天 滚动到指定日期 否则滚动到当月1日
        scrollCalendar(year, month, date) {
            this.data.flag = year + '-' + this.zero(month) + '-' + this.zero(date)
            // if(this.data.flag=="2020-07-06"){
            //     console.log(this.data.flag)
            // }else{
            //     console.log("no")
            // }
            this.setData({
                sign_num: 0,
                unsign_num: 0,
                sign_percent: 0,
                unsign_percent: 0,
                listData: []
            })
            this.exists(this.data.flag, this.data.year, this.data.month, this.data.date)
            var that = this,
                scrollLeft = 0;
            wx.getSystemInfo({
                success(res) {
                    //切换月份时 date为0
                    if (date == 0) {
                        scrollLeft = 0;
                        //切换到当年当月 滚动到当日
                        if (year == that.data.YEAR && month == that.data.MONTH) {
                            scrollLeft = that.data.DATE * 45 - res.windowWidth / 2 - 22.5;
                        }
                    } else {
                        // 点选具体某一天 滚到到指定日期
                        scrollLeft = date * 45 - res.windowWidth / 2 - 22.5;
                    }
                    that.setData({
                        scrollLeft: scrollLeft
                    })
                }
            })
        },

        to_more: function () {
            wx.showToast({
                title: '加载中...',
                mask: true,
                icon: 'loading',
                duration: 400
            })
            wx.navigateTo({
                url: '../more/more',
            })
        },

        //初始化
        display: function (year, month, date) {
            this.setData({
                year,
                month,
                date,
                title: year + '年' + this.zero(month) + '月'
            })
            if (this.data.sign == true) {
                let select = this.data.year + '-' + this.zero(this.data.month) + '-' + this.zero(date);
                this.setData({
                    select: select,
                    sign: false
                })
            }
            this.createDays(year, month);
            this.createEmptyGrids(year, month);
            //滚动模糊 初始界面
            this.scrollCalendar(year, month, date, );
        },

        //默认选中当天 并初始化组件
        today: function () {
            let DATE = this.data.defaultValue ? new Date(this.data.defaultValue) : new Date(),
                year = DATE.getFullYear(),
                month = DATE.getMonth() + 1,
                date = DATE.getDate(),
                select = year + '-' + this.zero(month) + '-' + this.zero(date);

            this.setData({
                format: select,
                select: select,
                year: year,
                month: month,
                date: date,
                YEAR: year,
                MONTH: month,
                DATE: date,
            })

            //初始化日历组件UI
            this.display(year, month, date);

            //发送事件监听
            this.triggerEvent('select', select);
        },

        //选择 并格式化数据
        select: function (e) {
            let date = e.currentTarget.dataset.date,
                select = this.data.year + '-' + this.zero(this.data.month) + '-' + this.zero(date);
            this.setData({
                title: this.data.year + '年' + this.zero(this.data.month) + '月' + this.zero(date) + '日',
                select: select,
                year: this.data.year,
                month: this.data.month,
                date: date,
            });
            //发送事件监听
            this.triggerEvent('select', select);

            //滚动日历到选中日期
            this.scrollCalendar(this.data.year, this.data.month, date);
        },

        //上个月
        lastMonth: function () {
            let month = this.data.month == 1 ? 12 : this.data.month - 1;
            let year = this.data.month == 1 ? this.data.year - 1 : this.data.year;
            this.setData({
                sign: true
            })
            //初始化日历组件UI
            this.display(year, month, 1);
        },

        //下个月
        nextMonth: function () {
            let month = this.data.month == 12 ? 1 : this.data.month + 1;
            let year = this.data.month == 12 ? this.data.year + 1 : this.data.year;
            this.setData({
                sign: true
            })
            //初始化日历组件UI
            this.display(year, month, 1);
        },
        //获取当月天数
        getThisMonthDays: function (year, month) {
            return new Date(year, month, 0).getDate();
        },
        // 绘制当月天数占的格子
        createDays: function (year, month) {
            let thisMonthDays = [],
                days = this.getThisMonthDays(year, month);
            for (let i = 1; i <= days; i++) {
                thisMonthDays.push({
                    date: i,
                    dateFormat: this.zero(i),
                    monthFormat: this.zero(month),
                    week: this.data.weekText[new Date(Date.UTC(year, month - 1, i)).getDay()]
                });
            }
            this.setData({
                thisMonthDays
            })
        },
        //获取当月空出的天数
        createEmptyGrids: function (year, month) {
            let week = new Date(Date.UTC(year, month - 1, 1)).getDay(),
                empytGridsBefore = [],
                empytGridsAfter = [],
                emptyDays = (week == 0 ? 7 : week);
            //当月天数
            var thisMonthDays = this.getThisMonthDays(year, month);
            //上月天数
            var preMonthDays = month - 1 < 0 ?
                this.getThisMonthDays(year - 1, 12) :
                this.getThisMonthDays(year, month - 1);

            //空出日期
            for (let i = 1; i <= emptyDays; i++) {
                empytGridsBefore.push(preMonthDays - (emptyDays - i));
            }

            var after = (42 - thisMonthDays - emptyDays) - 7 >= 0 ?
                (42 - thisMonthDays - emptyDays) - 7 :
                (42 - thisMonthDays - emptyDays);
            for (let i = 1; i <= after; i++) {
                empytGridsAfter.push(i);
            }
            this.setData({
                empytGridsAfter,
                empytGridsBefore
            })
        },
        //补全0
        zero: function (i) {
            return i >= 10 ? i : '0' + i;
        },
        //  点击日期组件确定事件  
        bindDateChange: function (e) {
            this.setData({
                dates: e.detail.value,
                year: parseInt(e.detail.value.substring(0, 4)),
                month: parseInt(e.detail.value.substring(5, 7)),
                title: this.data.year + '年' + this.zero(this.data.month) + '月'
            })
            this.setData({
                sign: true
            })
            this.display(this.data.year, this.data.month, 1);
            // console.log(parseInt(this.data.year))
            // console.log(parseInt(this.data.month))
            // console.log(this.data.title)
            // console.log(this.data.dates.substring(5, 7))
            // console.log(this.data.date.substring(8, 10))
        },

        // 判断当天是否有查寝记录
        exists: function (flag, year, month, date) {
            for (var i = 0; this.data.days[i] != flag && i < this.data.days.length; i++) {}
            if (i == this.data.days.length) {
                this.setData({
                    isShow: false
                })
            } else {
                this.setData({
                    isShow: true
                })
                this.getRecordDay(year, month, date);
            }
            // console.log(this.data.isShow)
        },

        display_isShow: function () {
            for (var i = 0; i < this.data.recordDay.length; i++) {
                this.signSituation(this.data.recordDay[i]['start_time'], this.data.recordDay[i]['end_time'], i);
            }
        },

        // 获取当天的所有记录
        getRecordDay: function (year, month, date) {
            month = this.zero(month);
            date = this.zero(date);
            var that = this;
            wx.request({
                url: getApp().globalData.server + '/cqcq/public/index.php/api/Resultsday/getDayRecord',
                //发给服务器的数据
                data: {
                    grade: getApp().globalData.user.grade,
                    department: getApp().globalData.user.department,
                    time: year + '-' + month + '-' + date
                },
                method: "POST",
                header: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                success: function (res) {
                    if (res.data.error_code != 0) {
                        wx.showModal({
                            title: '提示',
                            content: res.data.msg,
                            showCancel: false,
                            success: function (res) {}
                        })
                        // console.log(res);
                    } else if (res.data.error_code == 0) {
                        that.setData({
                            recordDay: res.data.data.day
                        })
                        console.log("查询", that.data.recordDay, "的查寝记录");
                        that.display_isShow()
                    }
                },
                fail: function (res) {
                    wx.showModal({
                        title: '哎呀～',
                        content: '网络不在状态呢！',
                        success: function (res) {
                            if (res.confirm) {
                                console.log('用户点击确定')
                            } else if (res.cancel) {
                                console.log('用户点击取消')
                            }
                        }
                    })
                }
            })

        },

        // 进行统计
        signSituation: function (start_time, end_time, i) {
            var that = this;
            var num = Number(i);
            var listData = 'listData[' + num + ']';
            console.log(start_time);
            console.log(end_time);
            wx.request({
                url: getApp().globalData.server + '/cqcq/public/index.php/api/statistics/stu_statistics',
                //发给服务器的数据
                data: {
                    grade: getApp().globalData.user.grade,
                    department: getApp().globalData.user.department,
                    start_time: start_time,
                    end_time: end_time
                },
                method: "POST",
                header: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                success: function (res) {
                    // console.log(res);
                    if (res.data.error_code != 0) {
                        wx.showModal({
                            title: '提示',
                            content: res.data.msg,
                            showCancel: false,
                            success: function (res) {}
                        })
                    } else if (res.data.error_code == 0) {
                        // console.log(res.data);
                        that.setData({
                            [listData]: res.data.data.unsign_list,
                            sign_num: res.data.data.sign_num + that.data.sign_num,
                            unsign_num: res.data.data.unsign_num + that.data.unsign_num
                        })
                        var unsign_percent = (that.data.unsign_num / (that.data.unsign_num + that.data.sign_num)) * 100;
                        var sign_percent = (that.data.sign_num / (that.data.unsign_num + that.data.sign_num)) * 100;
                        that.setData({
                            unsign_percent: unsign_percent,
                            sign_percent: sign_percent
                        })
                        // console.log(that.data.listData);
                        // console.log('sign_num:' + that.data.sign_num);
                        // console.log('unsign_num:' + that.data.unsign_num);
                        // console.log('unsign_percent:' + that.data.unsign_percent);
                        // console.log('sign_percent:' + that.data.sign_percent);
                    }
                },
                fail: function (res) {
                    wx.showModal({
                        title: '哎呀～',
                        content: '网络不在状态呢！',
                        success: function (res) {
                            if (res.confirm) {
                                console.log('用户点击确定')
                            } else if (res.cancel) {
                                console.log('用户点击取消')
                            }
                        }
                    })
                }
            })
        }

    }
})