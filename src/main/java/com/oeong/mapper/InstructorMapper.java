package com.oeong.mapper;

import com.baomidou.mybatisplus.core.mapper.BaseMapper;
import com.oeong.entity.Instructor;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface InstructorMapper extends BaseMapper<Instructor> {
    Instructor findById(Integer id);
}
