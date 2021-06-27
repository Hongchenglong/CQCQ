package com.oeong.service;


import com.oeong.entity.Record;

public interface RecordService {
    Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime);
    Integer getLastId();
    Record selectMaxTime(Integer dormGrade, String dormDep);
}
