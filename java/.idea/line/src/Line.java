import java.util.Scanner;

public class Line {
    public double m;
    public double c;
    Scanner sc = new Scanner(System.in);
    void coodrinate(){
        int n,i,x,y;
        double sumx=0;
        double sumy=0;
        double sumxsqu=0;
        double sumxy=0;
        System.out.println("enter no of codrinate you wnat to input");
        n=sc.nextInt();
        for(i=0;i<n;i++){
            System.out.println("enter x  codrinate ");
            x=sc.nextInt();
            sumx=sumx+x;
            sumxsqu=sumxsqu + (x*x);
            System.out.println("enter y codrinate ");
            y=sc.nextInt();
            sumy=sumy+y;
            sumxy=sumxy+(x*y);
            System.out.println(".............");
        }
        System.out.println(sumx);
        m=((n * sumxy)-(sumx*sumy))/((n*sumxsqu)- (sumy*sumy));
        System.out.println(m);
        c= (sumy-(m*sumx))/n;
        System.out.println(c);

    }
    void display()
    {
        System.out.println("y ="+m+"x"+"-"+c);
    }
}
