package com.oeong.service.impl;

import com.oeong.dao.InstructorDao;
import com.oeong.dao.StudentDao;
import com.oeong.entity.Instructor;
import com.oeong.entity.Student;
import com.oeong.service.InstructorService;
import com.oeong.service.StudentService;
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
