package com.oeong.service.impl;

import com.oeong.dao.NoticeDao;
import com.oeong.service.NoticeService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class NoticeServiceImpl implements NoticeService {
    @Autowired
    private NoticeService noticeService;

    @Override
    public Integer findByInstructorId(String instructorId, String startTime, String endTime) {
        return noticeService.findByInstructorId(instructorId, startTime, endTime);
    }

    @Override
    public Integer insertNotice(Integer instructorId, String startTime, String endTime) {
        return noticeService.insertNotice(instructorId, startTime, endTime);
    }
}
