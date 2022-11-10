public class Store {
    public static void main(String[] args) {
        Product p[] = new Product[5];
        for (int i = 0; i < 5; i++) {
            p[i] = new Product();
            p[i].entry();
        }
        for (int i = 0; i < 5; i++) {
            p[i].display();
        }
    }
}
