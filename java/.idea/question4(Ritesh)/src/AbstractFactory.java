public abstract class AbstractFactory {
    public abstract Furniture getFurniture(String furniture);
    public abstract Design getDesign(String design);
}
class FurnitureFactory extends AbstractFactory{
    public Furniture getFurniture(String furniture){
        if(furniture == null){
            return null;
        }
        if(furniture.equalsIgnoreCase("Chair")){
            return new Chair();
        } else if(furniture.equalsIgnoreCase("Sofa")){
            return new Sofa();
        } else if(furniture.equalsIgnoreCase("Coffeetable")){
            return new Coffeetable();
        }
        return null;
    }
    public Design getDesign(String design) {
        return null;
    }
}
class DesignFactory extends AbstractFactory{
    public Furniture getFurniture(String furniture){
        return null;
    }

    public Design getDesign(String design){
        if(design == null){
            return null;
        }
        if(design.equalsIgnoreCase("Modern")){
            return new Modern();
        } else if(design.equalsIgnoreCase("Victorian")){
            return new Victorian();
        } else if(design.equalsIgnoreCase("Artdeco")){
            return new Artdeco();
        }
        return null;
    }

}