package com.oeong.service.impl;

import com.oeong.dao.DormDao;
import com.oeong.service.RecordService;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

import static org.junit.jupiter.api.Assertions.*;

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
        System.out.println(recordService);
        System.out.println(recordService.getLastId());
        System.out.println(recordService.selectMaxTime(2017, "计算机工程系"));
    }

}