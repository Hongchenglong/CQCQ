package com.oeong.service;

import com.baomidou.mybatisplus.extension.service.IService;
import com.oeong.entity.Result;

public interface ResultService extends IService<Result> {
    Integer insertResult(Integer studentId, Integer recordId);
}
