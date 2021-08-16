package com.oeong.mapper;

import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface NoticeMapper {
    Integer findByInstructorId(Integer instructorId, String startTime, String endTime);
    Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
