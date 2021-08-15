package com.oeong.dao.mybatis;

import com.oeong.entity.Dorm;
import com.oeong.entity.Record;
import com.oeong.entity.Result;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

import java.util.List;

@Mapper
@Repository
public interface RecordDao {
    Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime);
    Integer getLastId();
    Record selectMaxTime(Integer dormGrade, String dormDep);
    List<Dorm> selectDormAndNumber(Integer dormGrade, String dormDep, String startTime, String endTime);
}
