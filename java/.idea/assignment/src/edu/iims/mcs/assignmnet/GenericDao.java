package edu.iims.mcs.assignmnet;
import edu.iims.mcs.assignmnet.BaseModel;
import java.util.List;
public interface GenericDao<T extends BaseModel> {
    void save(T t);

    List<T> findAll();

    T findOne(Long id);
}
