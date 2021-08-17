package com.oeong.entity;

import com.baomidou.mybatisplus.annotation.TableName;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data // @Data : 注解在类上, 为类提供读写属性（提供get/set方法）, 此外还提供了 equals()、hashCode()、toString() 方法
@NoArgsConstructor
@AllArgsConstructor
@TableName("cq_student")
public class Student extends User {
    private String sex;
    private String dorm;
    private String face;
    private Dorm dormEntity;
}
