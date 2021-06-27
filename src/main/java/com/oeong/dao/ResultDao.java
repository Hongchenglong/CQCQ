package com.oeong.dao;

import com.oeong.entity.Result;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface ResultDao {
    public Integer insertResult(Integer studentId, Integer recordId);
}
