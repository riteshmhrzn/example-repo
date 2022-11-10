import java.util.Scanner;

public class Product {
    private String productcode;
    private String productcost;
    private String adnumberofitemavailable;

    Scanner sc = new Scanner(System.in);
    //method to open new account
    void entry() {
        System.out.print("Enter product code ");
        productcode = sc.next();
        System.out.print("Enter product cost: ");
        productcost = sc.next();
        System.out.print("Enter no of item available: ");
        adnumberofitemavailable = sc.next();
        System.out.println(".....................");
    }
    void display()
    {
        System.out.println("productcode="+productcode);
        System.out.println("productcost="+productcost);
        System.out.println("no of item available="+adnumberofitemavailable);
    }
}
