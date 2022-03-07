<template>
    <div class="container mx-auto py-10">
        <div class="flex flex-row">
            <div class="basis-3/4">
                <h1 class="font-medium leading-tight text-5xl mt-0 mb-2 text-blue-600">
                    Developer Screening
                </h1>
            </div>
            <div class="basis-1/4 text-right">

                <button
                    type="button"
                    class="inline-block px-6 py-2.5 mt-4 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                    @click="showModal"
                >
                    Add New
                </button>
            </div>
        </div>


        <div class="p-10">
            <p class="text-green-500 text-center" v-if="successMessage">{{ successMessage }}</p>
        </div>


        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Developers Candidate
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Stats
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Admin
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="border-b" v-for="developer in developers" :key="developer.id">
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <p class="font-bold">{{ developer.name}}</p>
                                    <br>
                                    {{ developer.company }} | <a :href="developer.url">{{ developer.username}}</a>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="rounded-full bg-red-500 text-red-50 py-1 px-2 text-xs font-bold ml-1"
                                        v-for="(repositories, name) in developer.repositories"
                                        :key="name"
                                        v-if="name"
                                    >
                                        {{ name }}
<!--                                        {{ repositories.length }}-->

                                    </span>
                                    <span
                                        class="rounded-full bg-red-500 text-red-50 py-1 px-2 text-xs font-bold ml-1"
                                    >
                                        {{ developer.repositories_count }}
                                    </span>

                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <button
                                        type="button"
                                        :disabled="updating"
                                        class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                                        @click="updateUser(developer)"
                                    >
                                        <span v-if="updating">
                                            <svg class="animate-spin h-5 w-5 mr-3 ..." viewBox="0 0 24 24">
                                            </svg>
                                            Updating
                                        </span>
                                        <span v-else>
                                            Update
                                        </span>
                                    </button>

                                    <button
                                        type="button"
                                        class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                        @click="deleteUser(developer)"
                                    >
                                        x
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <Modal v-show="isModalVisible" @close="closeModal">
            <!-- header -->
            <template v-slot:header>
                <h1 class="font-bold text-xl">Add User</h1>
            </template>

            <!-- body -->
            <template v-slot:body>
                <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Github username"
                    class="rounded-2xl w-full p-3 my-1 shadow-md outline-none"
                    v-model="username"
                />
                <span class="text-red-600" v-if="errorMessage">{{ errorMessage}}</span>

                <button
                    type="button"
                    class="rounded-2xl bg-blue-500 shadow-md p-3 my-1 w-full text-white"
                    :disabled="loading"
                    @click="addUser"
                >
                    <span v-if="loading">Adding User....</span>
                    <span v-else>Add User</span>
                </button>
                <button
                    type="button"
                    class="rounded-2xl bg-red-500 shadow-md p-3 my-1 w-full text-white"
                    @click="closeModal"
                >
                    Cancel
                </button>
            </template>
        </Modal>

    </div>
</template>

<script>

import Modal from "../components/Modal";

export default {
    name: "Home",
    components: {
        Modal
    },
    mounted() {
        this.fetchAllDevelopers();
    },
    data() {
        return {
            isModalVisible: false,
            developers:[],
            username: '',
            loading: false,
            updating: false,
            errorMessage: '',
            successMessage: '',
            selectedDeveloper: {},
        }
    },
    methods: {
        fetchAllDevelopers() {
            axios.get('api/developers').then(response => {
                this.developers = response.data.data;
            });
        },
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
        addUser() {
            this.loading = true;
            this.errorMessage = '';
            this.successMessage = '';

            axios.post('api/developers', {
                'username': this.username
            }).then(response => {
                this.loading = false;
                this.successMessage = "Developer Added successfully"
                this.username = '';
                this.closeModal();
                this.fetchAllDevelopers();
            }).catch(error => {
                console.log('this.error', error.response);
                let errorResponse = error.response;
                if (errorResponse.status === 422) {
                    this.errorMessage = errorResponse.data.errors.username[0];
                } else {
                    this.errorMessage = errorResponse.data.message;
                }
                this.loading = false;
            })
        },
        updateUser(developer) {
            this.updating = true;
            this.successMessage = '';
            this.selectedDeveloper = developer;

            axios.put('api/developers/' + developer.id).then(response => {
                console.log('response', response);
                this.updating = false;
                this.successMessage = "Developer details updated successfully";
                this.fetchAllDevelopers();
            }).catch(error => {
                console.log('this.error', error);


                this.updating = false;
            })
        },
        deleteUser(developer) {
            axios.delete('api/developers/' + developer.id).then(response => {
                console.log('response', response);
                this.loading = false;
                this.successMessage = "Developer details deleted successfully";
                this.fetchAllDevelopers();
            }).catch(error => {
                console.log('this.error', error);

                // this.errorMessage = errorResponse.data.message;

                this.loading = false;
            })
        }
    }

}
</script>

<style scoped>

</style>
