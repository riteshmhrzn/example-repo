class Student {
    private String name;
    private int id;
    private double salary;

    //mutator methods for seting display
    public void setName(String n) {
        this.name = n;
    }

    public void setId(int i) {
        this.id = i;
    }

    public void setSalary(Double s) {
        this.salary = s;
    }

    //accessor method
    public String getName() {
        return name;
    }

    public int getId() {
        return id;
    }

    public double getSalary() {
        return salary;
    }
}

