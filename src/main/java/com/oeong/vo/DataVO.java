package com.oeong.vo;

import com.oeong.entity.Dorm;
import com.oeong.entity.Student;
import lombok.Data;

import java.util.List;
import java.util.Map;

@Data
public class DataVO {
    private Student stuInfo;
    private Dorm roomInfo;

    private Integer boys;
    private Integer girls;

    private List<Dorm> dorm;
    private List<Map<String, String>> dormSuc;
}
