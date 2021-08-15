package com.oeong.dao.mybatis;

import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

import java.util.Date;

@Mapper
@Repository
public interface NoticeDao {
    public Integer findByInstructorId(Integer instructorId, String startTime, String endTime);
    public Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
