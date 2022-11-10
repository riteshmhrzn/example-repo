package edu.iims.mcs.assignmnet;

import java.security.PrivateKey;

public class Payment extends BaseModel{
    private Double netTotal;

    private Double subCharge;

    private Double delivaryCharge;
    private String oderType;

    public Payment() {
    }

    public Payment(Long id, Double netTotal,String oderType, Double subCharge, Double delivaryCharge){
        super(id);
        this.netTotal = netTotal;
        this.subCharge = subCharge;
        this.delivaryCharge = delivaryCharge;
        this.oderType =oderType;
    }

    public Double getNetTotal() {
        return netTotal;
    }

    public void setNetTotal(Double netTotal) {
        this.netTotal = netTotal;
    }
    public String getOdertype() {
        return oderType;
    }
    public void setOderType(String oderType) {
        this.oderType = oderType;
    }
    public Double getsubCharge() {
        return subCharge;
    }

    public void setsubCharge(Double subCharge) {
        this.subCharge = subCharge;
    }
    public Double getdelivaryCharge() {
        return delivaryCharge;
    }

    public void setdelivaryCharge(Double delivaryCharge) {
        this.delivaryCharge = delivaryCharge;
    }


    @Override
    public String toString() {
        return "Payment{" +
                "id='" + this.getId() + '\'' +
                "nettotal='" + netTotal + '\'' +
                ",ordertype='" + oderType + '\'' +
                ",sub charge='" + subCharge + '\'' +
                ",delivery charge='" + delivaryCharge +'\''+
                ", grand total='"+(netTotal+subCharge+delivaryCharge)+
                '}';
    }
}
