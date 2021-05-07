package com.oeong.service;

import com.oeong.entity.Dorm;

public interface DormService {
    Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
    Integer count(Integer dormGrade, String dormDep, String sex);
    Object findAll(Integer dormGrade, String dormDep, String sex);
}
