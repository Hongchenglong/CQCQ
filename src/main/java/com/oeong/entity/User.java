package com.oeong.entity;

import lombok.Data;

@Data
public class User {
    private Integer id;
    private String username;
    private String password;
    private String email;
    private String phone;
    private Integer grade;
    private String department;
    private String openid;
    private String user; // 区分是否学生、辅导员
}
