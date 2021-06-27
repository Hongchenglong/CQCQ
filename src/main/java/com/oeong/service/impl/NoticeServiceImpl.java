package com.oeong.service.impl;

import com.oeong.dao.NoticeDao;
import com.oeong.service.NoticeService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;

@Service
public class NoticeServiceImpl implements NoticeService {
    @Autowired
    private NoticeDao noticeDao;

    @Override
    public Integer findByInstructorId(Integer instructorId, String startTime, String endTime) {
        return noticeDao.findByInstructorId(instructorId, startTime, endTime);
    }

    @Override
    public Integer insertNotice(Integer instructorId, String startTime, String endTime) {
        return noticeDao.insertNotice(instructorId, startTime, endTime);
    }
}
