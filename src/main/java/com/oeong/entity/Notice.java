package com.oeong.entity;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.Data;

@Data
public class Notice {
    @JsonProperty("notice_id")
    private Integer noticeId;
    @JsonProperty("instructor_id")
    private Integer InstructorId;
    @JsonProperty("start_time")
    private String startTime;
    @JsonProperty("end_time")
    private String endTime;
    @JsonProperty("send_time")
    private String sendTime;
}
