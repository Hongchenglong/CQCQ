package com.oeong.service.impl;

import com.oeong.dao.mybatis.InstructorDao;
import com.oeong.entity.Instructor;
import com.oeong.service.InstructorService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class InstructorServiceImpl implements InstructorService {

    @Autowired
    private InstructorDao instructorDao;

    @Override
    public Instructor findById(Integer id) {
        return instructorDao.findById(id);
    }
}
