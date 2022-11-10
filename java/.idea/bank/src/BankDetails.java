import java.util.Scanner;
public class BankDetails {
    private String accno;
    private String name;
    private String acc_type;
    public long balance;
    Scanner sc = new Scanner(System.in);
    //method to open new account
     void openAccount() {
        System.out.print("Enter Account No: ");
        accno = sc.next();
        System.out.print("Enter Account type: ");
        acc_type = sc.next();
        System.out.print("Enter Name: ");
        name = sc.next();
        balance = 0;
    }
    //method to display account details
    public void showAccount() {
        System.out.println("Name of account holder: " + name);
        System.out.println("Account no.: " + accno);
        System.out.println("Account type: " + acc_type);
        System.out.println("Balance: " + balance);
    }
    //method to deposit money
    public void deposit() {
        long amt;
        System.out.println("Enter the amount you want to deposit: ");
        amt = sc.nextLong();
        balance = balance + amt;
    }
    public void withdrawal() {
        long amt;
        System.out.println("Enter the amount you want to withdraw: ");
        amt = sc.nextLong();
        if (balance >= amt) {
            balance = balance - amt;
            System.out.println("Balance after withdrawal: " + balance);
        } else {
            System.out.println("Your balance is less than " + amt + "\tTransaction failed...!!" );
        }
    }
}
class CurrentAcc extends BankDetails {
   
   void check(){
    if (balance<1000){
        balance=balance-100;
        System.out.println("penalty charge 100 deducted, total balance is"+balance);
    }
       System.out.println("print balance="+ balance);
   }
}

class SavingsAcc extends BankDetails{
    Scanner sc = new Scanner(System.in);
    public void intrest(){
        long time;
        double rate=5.0;
        double amount;
        System.out.println("Enter the time period: ");
        time = sc.nextLong();
        amount = balance*time*rate/100 ;
        System.out.println("intrest:"+amount);
}
    public class BankingApp {
        public static void main(String arg[]) {
            SavingsAcc c= new SavingsAcc();
            c.openAccount();
            c.deposit();
            c.showAccount();
            c.withdrawal();
            System.out.println("net line");
            c.intrest();
            CurrentAcc b= new CurrentAcc();
            b.openAccount();
            b.deposit();
            b.check();
        }
        }
    }