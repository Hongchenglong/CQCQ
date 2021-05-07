package com.oeong.entity;

import lombok.Data;

import java.util.List;

@Data
public class Dorm {
    private Integer id;
    private String dorm_num;
    private Integer dorm_grade;
    private String dorm_dep;
    private String block;
    private String room;
    // 一间宿舍，多个学生
    private List<Student> studentList;
}
