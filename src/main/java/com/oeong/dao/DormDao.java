package com.oeong.dao;

import com.oeong.entity.Dorm;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

@Mapper
@Repository
public interface DormDao {
    public Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
}
