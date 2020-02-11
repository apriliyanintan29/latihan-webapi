<template>
    <div class="container">
        <div class="card">
            <div class="card-header">Data Siswa</div>
            {{ error }}
            <div class="card-body">
                
                <button
                    class="btn btn-warning"
                    @click="resetData">
                    Reset
                </button>

                <input
                    v-model="katakunci"
                    type="search"
                    placeholder="Masukkan kata kunci dan tekan enter"
                    @change="jalankanPencarian" />

                <hr />

                <table
                    v-if="!loading"
                    class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Dibuat Pada</th>
                    </tr>

                    <tr
                        v-for="item in laravelData.data"
                        :key="item.id">
                        <td>{{ item.nama }}</td>
                        <td>{{ item.jk }}</td>
                        <td>{{ item.created_at }}</td>
                    </tr>
                </table>

                <pagination
                    :data="laravelData"
                    @pagination-change-page="aksesApi">
                </pagination>

                    <div v-if="loading">
                        Loading ..... .
                    </div>
            </div>
        </div>

        <vue-progress-bar></vue-progress-bar>

        <notifications group="foo" />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: {},
                loading: true,
                error: '',
                laravelData: {},
                katakunci: ''
            }
        },

        mounted() {
            this.aksesApi();
        },

        methods: {
            aksesApi(page = 1, katakunci) {
                this.$Progress.start()
                this.loading = true

                const params = {
                    page: page
                }

                if (katakunci) {
                    params.katakunci = katakunci
                }

                axios.get('/testapi', {
                    params
                })
                .then(response => {
                    this.laravelData = response.data
                    this.loading = false
                    this.$Progress.finish()
                    this.$notify({
                        type: 'bg-success',
                        group: 'foo',
                        title: 'Sukses',
                        text: 'Data berhasil ditampilkan',
                        duration: 10000
                    });
                }).catch(error => {
                    this.loading = false
                    this.$Progress.fail()
                    this.$notify({
                        type: 'bg-danger',
                        group: 'foo',
                        title: 'Error',
                        text: error,
                        duration: 10000
                    });
                })
            },

            jalankanPencarian() {
                //
                this.aksesApi(1, this.katakunci)
            },

            resetData() {
                this.katakunci = ''
                this.aksesApi()
            }
        }
    }
</script>
