package com.oeong.entity;

import com.baomidou.mybatisplus.annotation.TableName;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.Data;

import java.util.List;

@Data
@TableName("cq_record")
public class Record {
    private Integer id;
    private String photo;
    private Integer dormId;
    private Integer randNum;
    private String startTime;
    private String uploadTime;
    private String endTime;
    private Integer deleted;
    private Dorm dorm;
    private List<Dorm> dormList;
    private String dormNum;
}
