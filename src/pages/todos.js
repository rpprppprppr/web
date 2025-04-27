import Auth from "../services/auth.js";
import location from "../services/location.js";
import loading from "../services/loading.js";
import Todo from "../services/todo.js";

const init = async () => {
    loading.start()
    const { ok: isLogged } = await Auth.me()

    if (!isLogged) {
        return location.login()
    }

    const response = await Todo.getAll()
    const todos = response.data || response

    renderTodos(todos)
    loading.stop()
}

function renderTodos(todos) {
    const container = document.getElementById('todos-container')
    const todoList = document.getElementById('todo-list')
    todoList.innerHTML = ''

    if (!todos.length) {
        todoList.innerHTML = '<h3>Нет задач</h3>'
        return
    }

    todos.forEach(todo => {
        const card = createTodoCard(todo)
        todoList.appendChild(card)
    })
}

function createTodoCard(todo) {
    const card = document.createElement('div')
    card.classList.add('todo-card')

    const title = document.createElement('h3')
    title.classList.add('todo-title')
    title.innerText = `ID: ${todo.id} - ${todo.description}`

    const statusIcon = document.createElement('span')
    statusIcon.classList.add('status-icon')
    if (todo.completed) {
        statusIcon.innerText = '✔️'
        statusIcon.classList.add('completed')
    }

    const deleteButton = document.createElement('button')
    deleteButton.classList.add('delete-btn')
    deleteButton.innerText = 'Удалить'
    deleteButton.onclick = () => deleteTodo(todo.id)

    card.appendChild(title)
    card.appendChild(statusIcon)
    card.appendChild(deleteButton)

    if (!todo.completed) {
        const updateButton = document.createElement('button')
        updateButton.classList.add('update-btn')
        updateButton.innerText = 'Отметить выполненным'
        updateButton.onclick = () => updateTodo(todo.id)

        card.appendChild(updateButton)
    }

    return card
}

async function deleteTodo(id) {
    await Todo.delete(id)
    init()
}

async function updateTodo(id) {
    await Todo.update(id)
    init()
}

async function addTodo(event) {
    event.preventDefault()

    const description = document.getElementById('new-todo-description').value
    if (description) {
        loading.start()

        await Todo.create(description)
        init()

        document.getElementById('new-todo-description').value = '' 

        loading.stop()
    } else {
        alert('Описание задачи не может быть пустым.')
    }
}

function createAddTodoForm() {
    const form = document.createElement('form')
    form.classList.add('todo-form')

    const input = document.createElement('input')
    input.id = 'new-todo-description'
    input.type = 'text'
    input.placeholder = 'Описание задачи'
    input.classList.add('todo-input')

    const submitButton = document.createElement('button')
    submitButton.type = 'submit'
    submitButton.classList.add('todo-submit-btn')
    submitButton.innerText = 'Добавить задачу'

    form.appendChild(input)
    form.appendChild(submitButton)

    form.addEventListener('submit', addTodo)

    return form
}

if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", init)
} else {
    init()
}

const form = createAddTodoForm()
document.getElementById('todos-container').appendChild(form)