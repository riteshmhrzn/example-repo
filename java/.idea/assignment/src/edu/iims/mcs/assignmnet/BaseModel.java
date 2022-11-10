package edu.iims.mcs.assignmnet;

public class BaseModel {
    private Long id;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public BaseModel() {
    }
    public BaseModel(Long id) {
        this.id = id;
    }

}
