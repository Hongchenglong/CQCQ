package com.oeong.entity;

import lombok.Data;

import java.util.List;

@Data
public class Record {
    private Integer id;
    private String photo;
    private Integer dormId;
    private Integer randNum;
    private String startTime;
    private String uploadTime;
    private String endTime;
    private Integer deleted;
    private List<Dorm> dormList;
}
