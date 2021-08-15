package com.oeong.service.impl;

import com.oeong.service.RecordService;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

/**
 * @Author: Hongchenglong
 * @Date: 2021/6/27 10:49
 * @Description:
 */
@SpringBootTest
class RecordServiceImplTest {

    @Autowired
    private RecordService recordService;

    @Test
    public void maxTime() {
        System.out.println("recordService============");

        System.out.println(recordService.selectMaxTime(2017, "计算机工程系"));
    }

}