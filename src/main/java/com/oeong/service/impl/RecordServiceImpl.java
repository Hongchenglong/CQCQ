package com.oeong.service.impl;


import com.oeong.dao.RecordDao;
import com.oeong.entity.Dorm;
import com.oeong.entity.Record;
import com.oeong.entity.Result;
import com.oeong.service.RecordService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class RecordServiceImpl implements RecordService {

    @Autowired
    private RecordDao recordDao;

    @Override
    public Integer insertRecord(Integer dormId, Integer randNum, String startTime, String endTime) {
        return recordDao.insertRecord(dormId, randNum, startTime, endTime);
    }

    @Override
    public Integer getLastId() {
        return recordDao.getLastId();
    }

    @Override
    public Record selectMaxTime(Integer dormGrade, String dormDep) {
        return recordDao.selectMaxTime(dormGrade, dormDep);
    }


}
