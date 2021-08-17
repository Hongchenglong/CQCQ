package com.oeong.entity;

import com.baomidou.mybatisplus.annotation.TableName;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.Data;

import java.util.List;

@Data
@TableName("cq_dorm")
public class Dorm {
    private Integer id;
    @JsonProperty("dorm_grade")
    private Integer dormGrade;
    @JsonProperty("dorm_num")
    private String dormNum;
    @JsonProperty("dorm_dep")
    private String dormDep;
    private String block;
    private String room;
    // 一间宿舍，多个学生
    private List<Student> studentList;
    // 随机数
    @JsonProperty("rand_num")
    private Integer randNum;
    private Record record;
    private List<Record> recordList;
}
