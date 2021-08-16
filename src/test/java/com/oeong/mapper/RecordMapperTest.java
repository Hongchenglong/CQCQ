package com.oeong.mapper;

import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

/**
 * @Author: Hongchenglong
 * @Date: 2021/6/28 17:31
 * @Description:
 */
@SpringBootTest
class RecordMapperTest {
    @Autowired
    private RecordMapper recordMapper;

    @Test
    public void selectDormAndNumber() {
        System.out.println("selectDormAndNumber==========");
        System.out.println(recordMapper.selectDormAndNumber(2017, "计算机工程系", "2021-06-27 22:30:00", "2021-06-27 22:45:00"));
    }
}