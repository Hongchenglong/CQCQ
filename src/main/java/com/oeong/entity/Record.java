package com.oeong.entity;

import lombok.Data;

@Data
public class Record {
    private String phone;
    private Integer dormId;
    private Integer randNum;
    private String startTime;
    private String uploadTime;
    private String endTime;
    private Integer deleted;
}
