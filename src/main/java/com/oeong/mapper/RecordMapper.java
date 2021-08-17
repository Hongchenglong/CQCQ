package com.oeong.mapper;

import com.baomidou.mybatisplus.core.mapper.BaseMapper;
import com.oeong.entity.Dorm;
import com.oeong.entity.Record;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

import java.util.List;

@Mapper
@Repository
public interface RecordMapper extends BaseMapper<Record> {
    Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime);
    Integer getLastId();
    Record selectMaxTime(Integer dormGrade, String dormDep);
    List<Dorm> selectDormAndNumber(Integer dormGrade, String dormDep, String startTime, String endTime);
}
