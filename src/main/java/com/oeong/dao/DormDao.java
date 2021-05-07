package com.oeong.dao;

import com.oeong.entity.Dorm;
import com.oeong.entity.Student;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface DormDao {
    // 查找某间宿舍
    public Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
    // 查询宿舍数量
    public Integer count(Integer dormGrade, String dormDep, String sex);
    public Object findAll(Integer dormGrade, String dormDep, String sex);

}
