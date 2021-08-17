package com.oeong.entity;

import com.baomidou.mybatisplus.annotation.TableName;
import lombok.Data;

@Data
@TableName("cq_result")
public class Result {
    private Integer id;
    private Integer studentId;
    private Integer recordId;
    private Integer sign;
}
