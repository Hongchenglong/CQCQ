package com.oeong.dao.mybatis;

import com.oeong.entity.Instructor;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface InstructorDao {
    Instructor findById(Integer id);
}
