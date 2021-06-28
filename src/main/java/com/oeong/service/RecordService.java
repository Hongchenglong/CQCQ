package com.oeong.service;


import com.oeong.entity.Dorm;
import com.oeong.entity.Record;

import java.util.List;

public interface RecordService {
    Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime);
    Integer getLastId();
    Record selectMaxTime(Integer dormGrade, String dormDep);
}
