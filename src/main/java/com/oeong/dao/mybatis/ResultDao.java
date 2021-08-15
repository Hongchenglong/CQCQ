package com.oeong.dao.mybatis;

import com.oeong.entity.Result;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface ResultDao {
    Integer insertResult(Integer studentId, Integer recordId);
}
