<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import {ref} from "vue";

const props = defineProps({
    todos: {
        type: Object,
        required: true,
    },
});

const todos = ref(props.todos);

const loadTodos = async (page = 1) => {
    let response = await fetch(`${route('todo.list')}?page=${page}`);

    todos.value = await response.json();
};

const toggleComplete = async (todo) => {
    const response = await axios.put(`${route('todo.update', todo.id)}`, {
        todo,
    });
}

const deleteTodo = async (todo) => {
    let todoId = todo.id;
    const response = await axios.delete(`${route('todo.destroy', todoId)}`);

    if(response.data.success){
        await loadTodos();
    }
}

</script>

<template>
    <AppLayout title="Todo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <template v-for="todo in todos.data" :key="todo.id">
                            <q-card class="q-card-bordered">
                                <q-card-section>
                                    <div :class="{ 'completed': todo.completed }">
                                        <div class="text-h6">{{ todo.title }}</div>
                                        <div class="text-body2">{{ todo.description }}</div>
                                        <div class="flex justify-between items-center mt-5">
                                        <q-toggle
                                            v-model="todo.status"
                                            label="Mark as complete"
                                            @click="toggleComplete(todo)"
                                        />
                                        <q-btn
                                            class="ms-auto"
                                            color="red"
                                            text-color="white"
                                            label="Delete"
                                            :size="'sm'"
                                            @click="deleteTodo(todo)"
                                        />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </template>
                    </div>

                    <div class="flex justify-center mt-4">
                        <TailwindPagination
                            :data="todos"
                            @pagination-change-page="loadTodos"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
