package com.oeong.mapper;

import com.baomidou.mybatisplus.core.mapper.BaseMapper;
import com.oeong.entity.Notice;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface NoticeMapper extends BaseMapper<Notice> {
    Integer findByInstructorId(Integer instructorId, String startTime, String endTime);
    Integer insertNotice(Integer instructorId, String startTime, String endTime);
}
