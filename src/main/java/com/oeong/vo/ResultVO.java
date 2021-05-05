package com.oeong.vo;

import lombok.Data;

@Data
public class ResultVO<T> {
    // 泛型是一种不确定的类型，只有在使用这个类的时候才能确定
    private Integer code;
    private String msg;
    private T data;
}
