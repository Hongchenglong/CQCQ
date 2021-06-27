package com.oeong.service.impl;

import com.oeong.entity.Dorm;
import com.oeong.service.DormService;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

import java.util.List;

import static org.junit.jupiter.api.Assertions.*;

@SpringBootTest
class DormServiceImplTest {

    @Autowired
    private DormService dormService;

    @Test
    void count() {
        List count = dormService.count(2017, "计算机工程系", "男");
        System.out.println("count: "+count.size());
    }

    @Test
    void cnt() {
        Integer cnt = dormService.cnt(2017, "计算机工程系", "男");
        System.out.println(cnt);
        int id = 0;
    }

    @Test
    void draw() {
        List list = dormService.randomDraw(2017, "计算机工程系", "男", 20);
        System.out.println(list);
    }
}