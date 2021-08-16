package com.oeong.mapper;

import com.oeong.entity.Instructor;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface InstructorMapper {
    Instructor findById(Integer id);
}
