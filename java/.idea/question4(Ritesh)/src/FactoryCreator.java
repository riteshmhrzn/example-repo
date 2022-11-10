public class FactoryCreator {
    public static AbstractFactory getFactory(String choice){
        if(choice.equalsIgnoreCase("Furniture")){
            return new FurnitureFactory();
        } else if(choice.equalsIgnoreCase("Design")){
            return new DesignFactory();
        }
        return null;
    }
}
