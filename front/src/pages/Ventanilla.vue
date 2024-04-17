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
           <div class="row">
            <div class="col-6"><q-btn @click="repetir()" color="yellow-7" size="xl" icon="restart_alt">Repetir</q-btn></div>
            <div class="col-6"><q-btn @click="atender()" color="green-7" size="xl" icon="navigate_next">Atender</q-btn></div>
           </div>
          <q-table
            title="Lista de fichas Atendidas"
            :rows="tickets"
            row-key="name"
          />
        </q-page>
     </q-page-container>
    </q-layout>
    </div>

</template>

<script>
import {globalStore} from '../stores/globalStore'
import { io } from 'socket.io-client'
const socket = io(import.meta.env.VITE_API_SOCKET)

export default {
    name: 'VentanillaPage',
    data: () => ({
        dialog: true,
        drawer: null,
        units:[],
        user:{},
        nombrecaja:'',
        tickets:[],
        // socket : io('http://192.168.154.130:3000'),
        socket : io('http://localhost:3000'),
        store:globalStore()

    }),

    mounted() {

      this.datosatender()
      if (this.$store.boolSocket !== true) {
        socket.on('connect', () => {
          console.log('conectado')
        })
        socket.on('disconnect', () => {
          console.log('desconectado')
        })
        // socket.on('atender', (data) => {
        //   console.log(data)
        // })
        this.$store.boolSocket = true
      }

        if (!this.store.isLoggedIn) {
            this.$router.push('/login')
        }
        // console.log('Component mounted.')
    },
    methods:{
        datosatender(){
          this.$api.post('datosatender',{nombrecaja:this.store.user.caja}).then(res=>{
              this.tickets=res.data;
          })
        },

        atender(){
            this.$api.post('/atender',{nombrecaja:this.store.user.caja,unit_id:this.store.user.unit_id})
                .then(res=>{
                    // this.tickets=res.data
                    console.log('atender',res.data)
                  //socket.emit('atender', res.data.numero+'->'+res.data.empleado);
                    this.datosatender()
                    this.$api.post('/ultificha',{unit_id:this.store.user.unit_id})
                        .then(res=>{
                            console.log(res);
                            this.socket.emit('atender', res.data.numero+'->'+res.data.empleado);
                            //socket.emit('atender', res.data.numero+'->'+res.data.empleado);
                            //socket.on('disconnect', () => {
                           ///     console.log('desconectado')
                           // })
                        });

                }).catch(()=>{
                    alert('Todos los clientes fueron atendidos')

                });
        },
        repetir(){
          this.$api.post('/ultificha',{unit_id:this.store.user.unit_id})
                        .then(res=>{
                            console.log(res);
                            this.socket.emit('atender', res.data.numero+'->'+res.data.empleado);
                        });
        }
    },

}
</script>
