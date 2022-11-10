import java.io.*;
class AbstractFactoryPatternExample {
    public static void main(String args[])throws IOException {

        BufferedReader br=new BufferedReader(new InputStreamReader(System.in));

        System.out.print("Enter the name of Furniture:(chair,sofa,coffeetable)");
        String furnitureName=br.readLine();

        System.out.print("\n");
        System.out.print("Enter the type of furniture(modern,victorian, Artdeco ): ");

        String designName=br.readLine();
        AbstractFactory furnitureFactory = FactoryCreator.getFactory("Furniture");
        Furniture b=furnitureFactory.getFurniture(furnitureName);

        System.out.println(b.getFurnitureName());
        AbstractFactory designFactory = FactoryCreator.getFactory("Design");
        Design i= designFactory.getDesign(designName);
        System.out.println(i.getDesignType());


    }
}
