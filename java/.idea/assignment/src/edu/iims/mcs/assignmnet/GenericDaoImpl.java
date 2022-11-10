package edu.iims.mcs.assignmnet;
 import edu.iims.mcs.assignmnet.GenericDao;
 import edu.iims.mcs.assignmnet.BaseModel;
 import edu.iims.mcs.assignmnet.NotFoundException;

import java.util.List;

public class GenericDaoImpl<T extends BaseModel> implements GenericDao<T> {
    private final List<T> list;

    public GenericDaoImpl(List<T> list) {
        this.list = list;
    }

    @Override
    public void save(T t) {
        list.add(t);
    }

    @Override
    public List<T> findAll() {
        return list;
    }

    @Override
    public T findOne(Long id) {
        for (T t : list) {
            if (t.getId().equals(id)) {
                return t;
            }
        }
        throw new NotFoundException("The given id not found");
    }

}
