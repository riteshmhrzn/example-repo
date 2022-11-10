class Modern implements Design{
    private final String DNAME;
    public Modern(){
        DNAME="Design type Modern";
    }
    public String getDesignType() {
        return DNAME;
    }
}
class Victorian implements Design{
    private final String DNAME;
    public Victorian(){
        DNAME="Design type victorian";
    }
    public String getDesignType() {
        return DNAME;
    }
}
class Artdeco implements Design{
    private final String DNAME;
    public Artdeco(){
        DNAME="Design type Artdeco";
    }
    public String getDesignType() {
        return DNAME;
    }
}
