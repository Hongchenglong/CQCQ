package com.oeong.mapper;

import com.oeong.entity.Dorm;
import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Select;
import org.springframework.stereotype.Repository;

import java.util.List;

@Mapper
@Repository
public interface DormMapper {
    // 查找某间宿舍
    Dorm findByDormNum(String dormNum, Integer dormGrade, String dormDep);
    Dorm findByDormId(Integer dormId, Integer dormGrade, String dormDep);
    // 查询宿舍数量
    List<Integer> count(Integer dormGrade, String dormDep, String sex);
    Integer cnt(Integer dormGrade, String dormDep, String sex);
    // 随机抽取宿舍
    List<Dorm> randomDraw(Integer grade, String dep, String sex, Integer limit);
    // 查询宿舍和随机号
    List<Dorm> selectDormAndNumber(Integer dormGrade, String dormDep, String startTime, String endTime);
    // 获取区号
    @Select("select distinct block from cq_dorm where dorm_grade=#{grade} and dorm_dep=#{dep};")
    List<String> getBlock(Integer grade, String dep);
    @Select("select * from cq_dorm where dorm_grade=#{grade} and dorm_dep=#{dep} and dorm_num='${block}#${room}';")
    Integer doesItExist(Integer grade, String dep, String block, Integer room);
}
