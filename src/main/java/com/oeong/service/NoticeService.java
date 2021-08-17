package com.oeong.service;

import com.baomidou.mybatisplus.extension.service.IService;
import com.oeong.entity.Notice;

import java.util.Date;

public interface NoticeService extends IService<Notice> {
    Integer findByInstructorId(Integer instructorId, String startTime, String endTime);
    Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
