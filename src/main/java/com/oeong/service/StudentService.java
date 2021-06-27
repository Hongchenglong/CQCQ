package com.oeong.service;

import com.oeong.entity.Student;

import java.util.List;

public interface StudentService {
    Student findById(Integer id);
    List<Student> findByDorm(String dormNum, Integer grade, String department);
}
