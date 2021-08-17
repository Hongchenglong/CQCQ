package com.oeong.service.impl;

import com.baomidou.mybatisplus.extension.service.impl.ServiceImpl;
import com.oeong.entity.Result;
import com.oeong.mapper.ResultMapper;
import com.oeong.service.ResultService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class ResultServiceImpl extends ServiceImpl<ResultMapper, Result> implements ResultService {
    @Autowired
    private ResultMapper resultMapper;

    @Override
    public Integer insertResult(Integer studentId, Integer recordId) {
        return resultMapper.insertResult(studentId, recordId);
    }
}
