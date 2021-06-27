package com.oeong.service.impl;

import com.oeong.service.NoticeService;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

import javax.xml.ws.soap.Addressing;

import java.text.SimpleDateFormat;
import java.util.Date;

import static org.junit.jupiter.api.Assertions.*;

@SpringBootTest
class NoticeServiceImplTest {

    @Autowired
    private NoticeService noticeService;

    @Test
    void verify() {
        System.out.println(noticeService.findByInstructorId(12344,"2021-02-04 22:30:00","2021-02-04 23:59:00"));
    }
}