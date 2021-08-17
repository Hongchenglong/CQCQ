package com.oeong.service;

import com.baomidou.mybatisplus.extension.service.IService;
import com.oeong.entity.Instructor;

public interface InstructorService extends IService<Instructor> {
    Instructor findById(Integer id);
}
