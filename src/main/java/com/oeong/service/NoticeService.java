package com.oeong.service;

import java.util.Date;

public interface NoticeService {
    Integer findByInstructorId(Integer instructorId, String startTime, String endTime);
    Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
