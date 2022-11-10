package edu.iims.mcs.assignmnet;
import java.util.Scanner;
import edu.iims.mcs.assignmnet.Payment;
import edu.iims.mcs.assignmnet.PaymentDao;
import edu.iims.mcs.assignmnet.PaymentDaoImpl;
public class Main {
    public double calculateSubCharge(String paymentType,double amount){
        if(paymentType.equalsIgnoreCase("masterCard") || paymentType.equalsIgnoreCase("visacard")){
            return amount *0.015 ;
        }
        else if(paymentType.equalsIgnoreCase("amexCard")){
            return amount * 0.03;
        }
        else if(paymentType.equalsIgnoreCase("giftcard")){
            return 0.0;
        }
        return 0;
    }
    public double calculateDeliveryCharge(double amount){
        
        if(amount>100){
            return 0;
        }
        else if(amount>50 && amount<100){
            return 5;
        }
        else if(amount<50){
            return 10;
        }
        return 0;
    }


    public static void main(String[] args) {
        PaymentDao paymentDao = new PaymentDaoImpl();
        Main m=new Main();
        Scanner scanner=new Scanner(System.in);
        Long idd=1L;
        Double add=0.0;
        Double subCharge= 0.0;
        int exit = 1;
        String oder;        
        while(exit== 1){            
            System.out.println("Enter the total amount");
            Double net= scanner.nextDouble();            
            System.out.println("please select 1 for take away, and 2 for delivary");
            int odtype= scanner.nextInt();
            if(odtype==2){
                oder="delivery";
            add= m.calculateDeliveryCharge(net);}
            else if(odtype == 1){
                oder="takeaway";
            }
            else{
                 oder="null";
            }


            System.out.println("Enter the payment type: cash, mastercard,  visacard,  amexcard, giftcard");
            String payType=scanner.next();
            if(!payType.equalsIgnoreCase("cash")){
                subCharge=m.calculateSubCharge(payType,net);
            }
            if (oder != "null" ) {
                Payment pay = new Payment(idd, net, oder, subCharge, add);
                paymentDao.save(pay);

                System.out.println(paymentDao.findOne(idd));
            }
            else {
                System.out.println("error in input data");
            }
            System.out.println("please enter 1 to proceed next transcation");
            exit= scanner.nextInt();            
            idd= idd + 1;
            
        }        

        System.out.println(paymentDao.findAll());
    }
}
