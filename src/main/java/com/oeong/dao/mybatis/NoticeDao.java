package com.oeong.dao.mybatis;

import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

import java.util.Date;

@Mapper
@Repository
public interface NoticeDao {
    Integer findByInstructorId(Integer instructorId, String startTime, String endTime);
    Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
