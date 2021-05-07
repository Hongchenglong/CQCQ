package com.oeong.service.impl;

import com.oeong.dao.DormDao;
import com.oeong.entity.Dorm;
import com.oeong.service.DormService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class DormServiceImpl implements DormService {

    @Autowired
    private DormDao dormDao;

    @Override
    public Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep) {
        return dormDao.findByDormNum(dormNum, dormGrade, dormDep);
    }

    @Override
    public Integer count(Integer dormGrade, String dormDep, String sex) {
        return dormDao.count(dormGrade, dormDep, sex);
    }

    @Override
    public Object findAll(Integer dormGrade, String dormDep, String sex) {
        return dormDao.findAll(dormGrade, dormDep, sex);
    }
}
