package com.oeong.dao;

import com.oeong.entity.Instructor;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface InstructorDao {
    public Instructor findById(Integer id);
}
