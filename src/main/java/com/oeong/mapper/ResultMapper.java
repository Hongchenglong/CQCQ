package com.oeong.mapper;

import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface ResultMapper {
    Integer insertResult(Integer studentId, Integer recordId);
}
