package com.oeong.dao;

import com.oeong.entity.Student;
import org.apache.ibatis.annotations.Mapper;
import org.springframework.stereotype.Repository;

import java.util.List;

@Mapper
// @mapper的作用是可以给mapper接口自动生成一个实现类，让spring对mapper接口的bean进行管理，并且可以省略去写复杂的xml文件
@Repository
public interface StudentDao {
    public Student findById(Integer id);
    public List<Student> findByDorm(String dormNum, Integer grade, String department);
}
