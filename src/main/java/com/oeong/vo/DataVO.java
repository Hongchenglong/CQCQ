package com.oeong.vo;

import com.oeong.entity.Dorm;
import com.oeong.entity.Student;
import com.oeong.vo.info.roomInfoVO;
import com.oeong.vo.info.stuInfoVO;
import lombok.Data;

import java.util.List;

@Data
public class DataVO {
    private Student stuInfo;
    private Dorm roomInfo;
}
