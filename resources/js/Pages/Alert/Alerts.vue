

<script>
import Swal from 'sweetalert2';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import axios from 'axios';
import {Head} from '@inertiajs/vue3';

export default {
  mounted() {
    this.showAlert();
  },
  data() {
    return {
      showMessage: false,
      message: ''
    };
  },
  methods: {

    

    showAlert() {
      

        

        const timeoutId = setTimeout(() => {
          axios.post("/alert/givepenalty")
            .then(() => {
              Swal.close();
              clearTimeout(timeoutId);
              // window.close();
              this.showMessage = true;
              this.message = 'Hey there! Sorry to inform you but a penalty was given to you! Please stay active next time during working hours for maximum productivity.';
            })
            .catch(error => {
              console.error('Failed to give penalty:', error);
            });
        }, 60000); // 60000 milliseconds = 1 minute


        const alert = Swal.fire({
          title: 'Hello, Employee!',
          text: 'This is a reminder to stay active during working hours. Failing to do so may result in penalties. Press OK if you are still working.',
          showConfirmButton: true,
          confirmButtonText: 'OK',
          allowOutsideClick: false
        })
        .then((result) => {
          console.log(result);
            if (result.isConfirmed) {
              clearTimeout(timeoutId);
              this.showMessage = true;
              this.message = 'Thank you for confirming, you may now close this browser page';
            }
        });
          
        

      
    },
  },
};
</script>


<template>
  <GuestLayout>
    <Head title="Alert" />
    <div>
      <a href="/">Home</a>
      <div v-if="showMessage">{{ message }}</div>
    </div>
  </GuestLayout>
</template>