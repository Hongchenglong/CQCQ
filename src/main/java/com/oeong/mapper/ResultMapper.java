package com.oeong.mapper;

import com.baomidou.mybatisplus.core.mapper.BaseMapper;
import com.oeong.entity.Result;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface ResultMapper extends BaseMapper<Result> {
    Integer insertResult(Integer studentId, Integer recordId);
}
