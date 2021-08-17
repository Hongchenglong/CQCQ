package com.oeong.service;


import com.baomidou.mybatisplus.extension.service.IService;
import com.oeong.entity.Dorm;
import com.oeong.entity.Record;

import java.util.List;

public interface RecordService extends IService<Record> {
    Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime);
    Integer getLastId();
    Record selectMaxTime(Integer dormGrade, String dormDep);
}
