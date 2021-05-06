package com.oeong.service;

import com.oeong.entity.Dorm;

public interface DormService {
    Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
}
