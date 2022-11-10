package edu.iims.mcs.assignmnet;
import edu.iims.mcs.assignmnet.PaymentDao;
import edu.iims.mcs.assignmnet.Payment;
import java.util.ArrayList;

public class PaymentDaoImpl extends GenericDaoImpl<Payment> implements PaymentDao{
    public PaymentDaoImpl() {
        super(new ArrayList<>());
    }

}
