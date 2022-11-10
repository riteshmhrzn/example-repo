public class ExceptionDemo {
    void arrayerror() {
        String[] arr = {"Ritesh", "Bishwas", "Brishti", "Anuj"};
//Declaring 4 elements in the String array
        for (int i = 0; i <= arr.length; i++) {
            System.out.println(arr[i]);
//Here, no element is present at the iteration number arr.length, i.e 4
        }
    }
        void nullerror(){
            String ptr = null;
            // Checking if ptr.equals null or works fine.
            try
            {
                // This line of code throws NullPointerException
                // because ptr is null
                if (ptr.equals("gfg"))
                    System.out.print("Same");
                else
                    System.out.print("Not Same");
            }
            catch(NullPointerException e)
            {
                System.out.println("NullPointerException Caught");
            }
        }
        void atherror()
        {
            int a = 0, b = 10;
            try {int c = b/a;
            System.out.println("Value of c is : "+ c);
            }
            catch(ArithmeticException e)
            {
                System.out.println("ArithemeticException Caught");
            }
        }
    
    public static void main(String[] args) {

            ExceptionDemo e= new ExceptionDemo();
            e.nullerror();
            e.atherror();
            e.arrayerror();

        }

}
