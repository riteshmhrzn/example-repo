abstract class Shapes {
    abstract void rectangleArea(double l, double b);
    abstract void squareArea(double s);
    abstract void circleArea(double r);
}
    class Area extends Shapes {
        void rectangleArea(double l, double b)
        {
            double area = l*b;
            System.out.println("Area of Rectangle: "+area);
        }
        void squareArea(double s)
        {
            double area = s*s;
            System.out.println("Area of Square: "+area);
        }

        void circleArea(double r)
        {
            double area = 3.14*r*r;
            System.out.println("Area of Circle: "+area);
        }


         public static void main(String args[])
        {
            Area a = new Area();
            a.rectangleArea(4.0, 5.0);
            a.squareArea(3.0);
            a.circleArea(2.0);
        }
    }
