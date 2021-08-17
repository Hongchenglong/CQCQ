package com.oeong.entity;

import com.baomidou.mybatisplus.annotation.TableName;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data // @Data : 注解在类上, 为类提供读写属性（提供get/set方法）, 此外还提供了 equals()、hashCode()、toString() 方法
@TableName("cq_instructor")
public class Instructor extends User {
//    private Integer id;
//    private String username;
//    private String password;
//    private String email;
//    private String phone;
//    private String grade;
//    private String department;
//    private String openid;
}
