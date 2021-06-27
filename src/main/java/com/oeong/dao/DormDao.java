package com.oeong.dao;

import com.oeong.entity.Dorm;
import com.oeong.entity.Student;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

import java.util.List;

@Mapper
@Repository
public interface DormDao {
    // 查找某间宿舍
    public Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
    public Dorm findByDormId(Integer dormId, Integer dormGrade, String dormDep);
    // 查询宿舍数量
    public List<Integer> count(Integer dormGrade, String dormDep, String sex);
    public Integer cnt(Integer dormGrade, String dormDep, String sex);
    // 随机抽取宿舍
    public List<Dorm> randomDraw(Integer grade, String dep, String sex, Integer limit);
}
