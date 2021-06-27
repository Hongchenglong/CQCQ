package com.oeong.dao;

import com.oeong.entity.Record;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface RecordDao {
    public Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime);
    public Integer getLastId();
}
