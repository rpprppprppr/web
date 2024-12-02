function targetSum(numbers, target) {
    const map = new Map();

    for (let i = 0; i < numbers.length; i++) {
        const complement = target - numbers[i];
        if (map.has(complement)) {
            return [map.get(complement), i];
        }
        map.set(numbers[i], i);
    }

    return [];
}

const numbers = [2, 7, 11, 15];
const target1 = 9;
const target2 = 11;
const result1 = targetSum(numbers, target1);
const result2 = targetSum(numbers, target2);
console.log(result1); // [0, 1]
console.log(result2); // []