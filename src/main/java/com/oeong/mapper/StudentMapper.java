package com.oeong.mapper;

import com.oeong.entity.Student;
import org.apache.ibatis.annotations.Insert;
import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Select;
import org.springframework.stereotype.Repository;

import java.util.List;

@Mapper
// @mapper的作用是可以给mapper接口自动生成一个实现类，让spring对mapper接口的bean进行管理，并且可以省略去写复杂的xml文件
@Repository
public interface StudentMapper {
    Student findById(Integer id);
    List<Student> findByDorm(String dormNum, Integer grade, String department);
    @Select("select * from cq_student where grade=#{grade} and department=#{department} " +
            "limit #{begin}, #{offset};")
    List<Student> findByGradeAndDepart(Integer grade, String department, Integer begin, Integer offset);
    @Select("select count(id) from cq_student where grade=#{grade} and department=#{department};")
    Integer countByGradeAndDepart(Integer grade, String department);
    @Insert("insert into cq_student(id, sex, username, password, email, phone, grade, department, dorm) " +
            "value(#{id}, #{sex}, #{username}, #{password}, #{email}, #{phone}, #{grade}, #{department}, #{dorm});")
    Integer insert(Integer id, String sex, String username, String password,
                   String email, String phone, Integer grade, String department, String dorm);
}
