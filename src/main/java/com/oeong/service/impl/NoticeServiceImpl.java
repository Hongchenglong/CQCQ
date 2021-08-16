package com.oeong.service.impl;

import com.oeong.mapper.NoticeMapper;
import com.oeong.service.NoticeService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class NoticeServiceImpl implements NoticeService {
    @Autowired
    private NoticeMapper noticeMapper;

    @Override
    public Integer findByInstructorId(Integer instructorId, String startTime, String endTime) {
        return noticeMapper.findByInstructorId(instructorId, startTime, endTime);
    }

    @Override
    public Integer insertNotice(Integer instructorId, String startTime, String endTime) {
        return noticeMapper.insertNotice(instructorId, startTime, endTime);
    }
}
