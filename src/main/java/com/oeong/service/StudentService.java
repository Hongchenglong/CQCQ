package com.oeong.service;

import com.oeong.entity.Student;

public interface StudentService {
    Student login(Student student);
    Student findById(Integer id);
}
