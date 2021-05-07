package com.oeong.service;

public interface NoticeService {
    Integer findByInstructorId(String instructorId, String startTime, String endTime);
    Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
