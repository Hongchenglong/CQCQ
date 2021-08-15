package com.oeong.service.impl;

import com.oeong.dao.mybatis.ResultDao;
import com.oeong.service.ResultService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class ResultServiceImpl implements ResultService {
    @Autowired
    private ResultDao resultDao;

    @Override
    public Integer insertResult(Integer studentId, Integer recordId) {
        return resultDao.insertResult(studentId, recordId);
    }
}
