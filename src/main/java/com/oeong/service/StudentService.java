package com.oeong.service;

import com.oeong.entity.Student;

import java.util.List;

public interface StudentService {
    Student findById(Integer id);
    List<Student> findByDorm(String dormNum, Integer grade, String department);
    List<Student> findByGradeAndDepart(Integer grade, String department, Integer begin, Integer offset);
    Integer countByGradeAndDepart(Integer grade, String department);
    Integer insert(Integer id, String sex, String username, String password,
                   String email, String phone, Integer grade, String department, String dorm);
}
