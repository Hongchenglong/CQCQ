package com.oeong.service.impl;

import com.oeong.mapper.StudentMapper;
import com.oeong.entity.Student;
import com.oeong.service.StudentService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class StudentServiceImpl implements StudentService {

    @Autowired
    private StudentMapper studentMapper;

    @Override
    public Student findById(Integer id) {
        return studentMapper.findById(id);
    }

    @Override
    public List<Student> findByDorm(String dormNum, Integer grade, String department) {
        return studentMapper.findByDorm(dormNum, grade, department);
    }

    @Override
    public List<Student> findByGradeAndDepart(Integer grade, String department, Integer begin, Integer offset) {
        return studentMapper.findByGradeAndDepart(grade, department, begin, offset);
    }

    @Override
    public Integer countByGradeAndDepart(Integer grade, String department) {
        return studentMapper.countByGradeAndDepart(grade, department);
    }

    @Override
    public Integer insert(Integer id, String sex, String username, String password, String email, String phone, Integer grade, String department, String dorm) {
        return studentMapper.insert(id, sex, username, password, email, phone, grade, department, dorm);
    }
}
