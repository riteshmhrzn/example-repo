class Chair implements Furniture {
    private final String FNAME;
    public Chair(){
        FNAME="furtinuretype chair";
    }
    public String getFurnitureName() {
        return FNAME;
    }
}
class Sofa implements Furniture {
    private final String FNAME;
    public Sofa(){
        FNAME="furtinuretype sofa";
    }
    public String getFurnitureName() {
        return FNAME;
    }
}
class Coffeetable implements Furniture {
    private final String FNAME;
    public Coffeetable(){
        FNAME="furtinuretype coffeetable";
    }
    public String getFurnitureName() {
        return FNAME;
    }
}