package com.oeong.entity;

import lombok.Data;

@Data
public class Dorm {
    private Integer id;
    private String dorm_num;
    private Integer dorm_grade;
    private String dorm_dep;
    private String block;
    private String room;
}
