//класс и методы
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

// обработка на сайте
document.addEventListener("DOMContentLoaded", () => {
  let selectedPizza = "Пепперони";
  let selectedSize = "Маленькая";
  let selectedToppings = [];

  const defaultSize = document.querySelector(".pizza__size");
  if (defaultSize) {
      defaultSize.classList.add("pizza__size-active");
  }

  const defaultPizza = [...document.querySelectorAll(".pizza__card")].find(card => 
      card.querySelector(".pizza__name").textContent === "Пепперони"
  );
  if (defaultPizza) {
      defaultPizza.classList.add("pizza__card-active");
  }

  const button = document.querySelector(".order__button");

  function updateButton() {
      if (!selectedPizza) return;
      const pizza = new Pizza(selectedPizza, selectedSize);
      selectedToppings.forEach(topping => pizza.addTopping(topping));
      button.textContent = `Добавить в корзину за ${pizza.calculatePrice()}₽ (${pizza.calculateCalories()} ккал)`;
  }

  function updateToppingPrices() {
      document.querySelectorAll(".topping__card").forEach(topping => {
          const toppingName = topping.querySelector(".topping__name").textContent.trim();
          const priceElement = topping.querySelector(".topping__сost");
          
          const toppingPrices = {
              "Сливочная моцарелла": 50,
              "Сырный борт": (selectedSize === 'Маленькая' ? 150 : 300),
              "Чедер и пармезан": (selectedSize === 'Маленькая' ? 150 : 300)
          };

          if (priceElement && toppingPrices[toppingName] !== undefined) {
              priceElement.textContent = `${toppingPrices[toppingName]}₽`;
          }
      });
  }

  document.querySelectorAll(".pizza__card").forEach(card => {
      card.addEventListener("click", () => {
          document.querySelectorAll(".pizza__card").forEach(c => c.classList.remove("pizza__card-active"));
          card.classList.add("pizza__card-active");
          selectedPizza = card.querySelector(".pizza__name").textContent;
          updateButton();
      });
  });

  document.querySelectorAll(".pizza__size").forEach(size => {
      size.addEventListener("click", () => {
          document.querySelectorAll(".pizza__size").forEach(s => s.classList.remove("pizza__size-active"));
          size.classList.add("pizza__size-active");
          selectedSize = size.textContent;
          updateToppingPrices();
          updateButton();
      });
  });

  document.querySelectorAll(".topping__card").forEach(topping => {
      topping.addEventListener("click", () => {
          const toppingName = topping.querySelector(".topping__name").textContent.trim();
          
          if (selectedToppings.includes(toppingName)) {
              selectedToppings = selectedToppings.filter(t => t !== toppingName);
              topping.classList.remove("topping__card-active");
          } else {
              selectedToppings.push(toppingName);
              topping.classList.add("topping__card-active");
          }
          
          updateButton();
      });
  });

  updateToppingPrices();
  updateButton();
});