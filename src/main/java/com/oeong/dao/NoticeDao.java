package com.oeong.dao;

import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface NoticeDao {
    public Integer findByInstructorId(String instructorId, String startTime, String endTime);
    public Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
