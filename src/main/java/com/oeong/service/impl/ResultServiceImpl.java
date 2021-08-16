package com.oeong.service.impl;

import com.oeong.mapper.ResultMapper;
import com.oeong.service.ResultService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class ResultServiceImpl implements ResultService {
    @Autowired
    private ResultMapper resultMapper;

    @Override
    public Integer insertResult(Integer studentId, Integer recordId) {
        return resultMapper.insertResult(studentId, recordId);
    }
}
