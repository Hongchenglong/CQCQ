package com.oeong.service.impl;

import com.oeong.service.DormService;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

import static org.junit.jupiter.api.Assertions.*;

@SpringBootTest
class DormServiceImplTest {

    @Autowired
    private DormService dormService;

    @Test
    void count() {
        Integer count = dormService.count(2017, "计算机工程系", "男");
        System.out.println(count);
    }


    @Test
    void findAll() {
        Object o = dormService.findAll(2017, "计算机工程系", "男");
        System.out.println(o);
        int id = 0;
    }
}