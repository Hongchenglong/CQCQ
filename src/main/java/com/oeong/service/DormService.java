package com.oeong.service;

import com.oeong.entity.Dorm;
import org.springframework.stereotype.Service;

import java.util.List;

public interface DormService {
    Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
    Dorm findByDormId(Integer dormId, Integer dormGrade, String dormDep);
    List<Integer> count(Integer dormGrade, String dormDep, String sex);
    Integer cnt(Integer dormGrade, String dormDep, String sex);
    List<Dorm> randomDraw(Integer grade, String dep, String sex, Integer limit);
}
