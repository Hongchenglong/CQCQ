package com.oeong.service.impl;

import com.baomidou.mybatisplus.extension.service.impl.ServiceImpl;
import com.oeong.mapper.InstructorMapper;
import com.oeong.entity.Instructor;
import com.oeong.service.InstructorService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class InstructorServiceImpl extends ServiceImpl<InstructorMapper, Instructor> implements InstructorService {

    @Autowired
    private InstructorMapper instructorMapper;

    @Override
    public Instructor findById(Integer id) {
        return instructorMapper.findById(id);
    }
}
