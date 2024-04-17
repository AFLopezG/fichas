<template>
  <div class="q-pa-xs">
    <q-layout  class="shadow-2 rounded-borders">
      <q-header elevated>
        <q-toolbar>
            <img src="img/gamo.png" width="100px">

          <q-toolbar-title>FICHA DE ATENCION</q-toolbar-title>

          <q-btn flat round dense icon="whatshot" />
        </q-toolbar>
      </q-header>

      <q-footer elevated>
        <q-toolbar>
          <q-toolbar-title>&copy; {{ new Date().getFullYear() }}</q-toolbar-title>
        </q-toolbar>
      </q-footer>

      <q-page-container>
        <q-page class="q-pa-md">
            <div class="row" align="center" justify="center" >
                <div v-for="(item, i) in units" :key="i" style="padding:10px;">
                    <q-card :style="'padding:10px; height:250px; width:350px; background-color: '+item.color"  @click="ticket(item)">
                        <div class="my-card" flat bordered>
                            <q-card-section horizontal>
                                <q-card-section>
                                    <span style="font-size: 32px; font-weight: bold;">{{ item.abreviatura }}</span>
                                    <br> <span style="font-size: 24px; font-weight: bold;">{{ item.nombre }}</span>
                                </q-card-section>

                                <q-img
                                class="col-5"
                                :src="'img/'+item.id+'.jpg'"
                                style="height: 220px;width: 160px;"
                                />
                            </q-card-section>
                        </div>
                    </q-card>
                </div>
            </div>
        </q-page>
      </q-page-container>
    </q-layout>
  </div>
</template>
<style scoped>
.imagen {
    width:100%;
}
</style>

<script>
import moment from 'moment'
import { QSpinnerGears } from 'quasar'
    export default {
        name: 'ClientePage',
        data: () => ({
            drawer: null,
            units:[],
            items: [
                {
                    color: '#1F7087',
                    src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
                    title: 'Supermodel',
                    artist: 'Foster the People',
                },
                {
                    color: '#952175',
                    src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
                    title: 'Halcyon Days',
                    artist: 'Ellie Goulding',
                },
            ],
        }),
        mounted() {
            // console.log('Component mounted.')
            this.getUnit()
        },
        methods:{
            getUnit(){
                this.$api.get('/unit').then(res=>{this.units=res.data})
            },
            ticket(item){
                // console.log('aaa');
                moment.locale('es');
                this.$api.post('/registrar',{unit_id:item.id}).then(async res=>{
                    console.log(res.data);
                    this.$q.notify({
                        spinner: QSpinnerGears,
                        message: 'Imprimiendo...',
                        position: 'top',
                        timeout: 2000
                        })
                    let myWindow = await window.open('', 'myWindow', 'width=200,height=100');
                    myWindow.document.write('<style>*{padding:0px;border:0px;margin:0px;}</style><div style="text-align:center;padding-left: 25px;padding-right: 25px;">' +
                        '<div style="border: 1px solid black">' +
                            '<img width="120" src="img/gamo.png" alt="">' +
                            '<p>'+item.nombre+'</p>' +
                            '<h4>'+res.data.numero+'</h4>' +
                            '<p>Tome asiento y espere su turno</p>' +
                            '<p>'+moment().format('D MMMM YYYY, h:mm:ss a')+'</p>' +
                            '</div>' +
                        '</div>');
                    myWindow.focus();
                    myWindow.print();
                    myWindow.close();
                    // setTimeout(function(){

                    // },250);

                })
            }
        },
        props: {
            source: String,
        },

    }
</script>
