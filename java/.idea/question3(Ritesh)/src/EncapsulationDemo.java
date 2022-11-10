public class EncapsulationDemo extends Student{
    public static void main(String[] args) {
        Student s = new Student();
        s.setName("ritesh");
        s.setId(9);
        s.setSalary(93.00);
        System.out.println(s.getName());
        System.out.println(s.getId());
        System.out.println(s.getSalary());
    }
}
