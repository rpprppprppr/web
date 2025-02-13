class Pizza {
  constructor(type, size) {
    this.types = {
      "Маргарита": { price: 500, calories: 300 },
      "Пепперони": { price: 800, calories: 400 },
      "Баварская": { price: 700, calories: 450 }
    };

    this.sizes = {
      "Большая": { price: 200, calories: 200 },
      "Маленькая": { price: 100, calories: 100 }
    };

    if (!this.types[type] || !this.sizes[size]) {
      throw new Error("Неверный тип или размер пиццы");
    }

    this.type = type;
    this.size = size;
    this.toppings = [];
  }

  addTopping(topping) {
    const toppingsList = {
      "Сливочная моцарелла": { name: "Сливочная моцарелла", price: 50, calories: 20 },
      "Сырный борт": { name: "Сырный борт", price: (this.size === 'Маленькая' ? 150 : 300), calories: (this.size === 'Маленькая' ? 50 : 100) },
      "Чедер и пармезан": { name: "Чедер и пармезан", price: (this.size === 'Маленькая' ? 150 : 300), calories: (this.size === 'Маленькая' ? 50 : 100) }
    };

    if (!toppingsList[topping]) {
      throw new Error("Такой добавки не существует");
    }

    this.toppings.push(toppingsList[topping]);
  }

  removeTopping(topping) {
    this.toppings = this.toppings.filter(t => t.name !== topping);
  }

  getToppings() {
    return this.toppings.map(t => t.name);
  }

  getSize() {
    return this.size;
  }

  getType() {
    return this.type;
  }

  calculatePrice() {
    let total = this.types[this.type].price + this.sizes[this.size].price;
    this.toppings.forEach(t => total += t.price);
    return total;
  }

  calculateCalories() {
    let total = this.types[this.type].calories + this.sizes[this.size].calories;
    this.toppings.forEach(t => total += t.calories);
    return total;
  }
}

// пример использования:

let pizza1 = new Pizza("Пепперони", "Большая");
pizza1.addTopping("Сливочная моцарелла");
pizza1.addTopping("Чедер и пармезан");

console.log(`Тип пиццы: ${pizza1.getType()}`);
console.log(`Размер пиццы: ${pizza1.getSize()}`);
console.log(`Добавки: ${pizza1.getToppings().join(", ")}`);
console.log(`Цена пиццы: ${pizza1.calculatePrice()} рублей`);
console.log(`Калории пиццы: ${pizza1.calculateCalories()} Ккал\n`);

let pizza2 = new Pizza("Маргарита", "Маленькая");
pizza2.addTopping("Сырный борт");

console.log(`Тип пиццы: ${pizza2.getType()}`);
console.log(`Размер пиццы: ${pizza2.getSize()}`);
console.log(`Добавки: ${pizza2.getToppings().join(", ")}`);
console.log(`Цена пиццы: ${pizza2.calculatePrice()} рублей`);
console.log(`Калории пиццы: ${pizza2.calculateCalories()} Ккал\n`);

// пример использования (с ошибкой в типе пиццы):
let wrong_pizza = new Pizza("Сырная", "Маленькая");
wrong_pizza.addTopping("Сырный борт");
wrong_pizza.addTopping("Чедер и пармезан");

console.log(`Тип пиццы: ${wrong_pizza.getType()}`);
console.log(`Размер пиццы: ${wrong_pizza.getSize()}`);
console.log(`Добавки: ${wrong_pizza.getToppings().join(", ")}`);
console.log(`Цена пиццы: ${wrong_pizza.calculatePrice()} рублей`);
console.log(`Калории пиццы: ${wrong_pizza.calculateCalories()} Ккал`);
