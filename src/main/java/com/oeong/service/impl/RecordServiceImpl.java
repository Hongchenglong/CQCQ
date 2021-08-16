package com.oeong.service.impl;


import com.oeong.mapper.RecordMapper;
import com.oeong.entity.Record;
import com.oeong.service.RecordService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class RecordServiceImpl implements RecordService {

    @Autowired
    private RecordMapper recordMapper;

    @Override
    public Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime) {
        return recordMapper.insertRecord(dormId, randNum, startTime, endTime);
    }

    @Override
    public Integer getLastId() {
        return recordMapper.getLastId();
    }

    @Override
    public Record selectMaxTime(Integer dormGrade, String dormDep) {
        return recordMapper.selectMaxTime(dormGrade, dormDep);
    }


}
