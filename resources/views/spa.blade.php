<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!-- Подключаем Bootstrap, чтобы не работать над дизайном проекта -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    @verbatim
        <div id="app">
            <div class="container mt-5">
                <h1>Список книг нашей библиотеки</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Автор</th>
                            <th scope="col">Наличие</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in books">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ item . title }}</td>
                            <td>{{ item . author }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary"
                                    v-on:click="changeBookAvailability(item.id)">
                                    {{ item . availability ? 'Доступна' : 'Выдана' }}
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger" v-on:click="">
                                    Удалить
                                </button>
                            </td>
                        </tr>

                        <!-- Строка с полями для добавления новой книги -->
                        <tr>
                            <th scope="row">Добавить</th>
                            <td><input type="text" class="form-control" v-model="input.title"></td>
                            <td><input type="text" class="form-control" v-model="input.author"></td>
                            <td></td>
                            <td>
                                <button type="button" class="btn btn-outline-success" v-on:click="addBook()">
                                    Добавить
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endverbatim

    <!--Подключаем axios для выполнения запросов к api -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

    <!--Подключаем Vue.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

    <script>
        const API_ROOT = "http://localhost/api/book";

        let vm = new Vue({
            el: '#app',
            data: {
                books: [],
                input: {
                    author: "",
                    title: "",
                }
            },
            methods: {
                loadBookList() {
                    axios.get(API_ROOT + '/all')
                        .then((response) => {
                            this.books = response.data;
                        });
                },
                addBook() {
                    axios.post(API_ROOT + '/add/', {
                        author: this.input.author,
                        title: this.input.title
                    });
                    this.input.author = "";
                    this.input.title = "";
                },
                deleteBook(id) {

                },
                changeBookAvailability(id) {
                    axios.get(API_ROOT + '/change_availabilty/' + id);
                    for (let i = 0; i < this.books.length; i++) {
                        if (this.books[i].id == id) {
                            this.books[i].availability = (this.books[i].availability ? 0 : 1);
                        }
                    }
                }
            },
            mounted() {
                // Сразу после загрузки страницы подгружаем список книг и отображаем его
                this.loadBookList();
            }
        });

    </script>
</body>

</html>
