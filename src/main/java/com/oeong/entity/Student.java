package com.oeong.entity;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data // @Data : 注解在类上, 为类提供读写属性（提供get/set方法）, 此外还提供了 equals()、hashCode()、toString() 方法
@NoArgsConstructor
@AllArgsConstructor
public class Student extends User{
    private String sex;
    private String dorm;
    private String face;
    //    private Integer id;
    //    private String username;
    //    private String password;
    //    private String email;
    //    private String phone;
    //    private String grade;
    //    private String department;
    //    private String openid;
}
