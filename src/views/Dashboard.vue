<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <h1 class="float-start ml-3">Dashboard</h1>
      </div>
      <div class="col">
        <button
          class="btn btn-primary ml-3 float-end"
          @click.prevent="Logout()"
        >
          Log Out
        </button>
      </div>
    </div>
  </div>

  <h4 class="alert alert-primary" v-if="login_number">
    Your Login Number: {{ login_number }}
  </h4>
  <div class="alert alert-danger" role="alert" v-if="errorMsg">
    {{ errorMsg }}
  </div>
  <div class="alert alert-success" role="alert" v-if="succesMsg">
    {{ succesMsg }}
  </div>
  <div class="alert alert-warning" role="alert" v-if="warMsg">
    {{ warMsg }}
  </div>
  <form @submit.prevent="storeAppointment" method="POST">
    <div class="form-group">
      <label for="subject">Subject</label>
      <input
        type="text"
        class="form-control"
        id="subject"
        aria-describedby="subject"
        placeholder="Your Subject"
        v-model="subject"
      />
    </div>
    <div class="form-group">
      <label for="date">Date</label>
      <input
        type="date"
        name="setTodaysDate"
        class="form-control"
        id="dt"
        placeholder="date"
        v-model="appointment.date"
        @change="getTime"
      />
    </div>
    <div class="form-group">
      <label for="exampleFormControlSelect1">Available</label>
      <select
        class="form-control"
        id="exampleFormControlSelect1"
        v-model="appointment.hour"
      >
        <option v-for="time in times" :key="time.message" v-bind:value="time">
          {{ time }}
        </option>
      </select>
    </div>

    <button class="btn btn-primary m-3">Save</button>
  </form>
  <hr class="bg-info" />
  <table class="table" v-if="tshow">
    <thead>
      <tr>
        <th scope="col">Date RDV</th>
        <th scope="col">Subject</th>
        <th scope="col">Delete</th>
        <th scope="col">Edit</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="r in rdv" :key="r.id">
        <th scope="row">{{ r.times }}</th>
        <td>{{ r.subject }}</td>
        <td colspan="2">
          <button class="btn btn-danger m-2" @click="del(r.id)">Delete</button>
          <button
            class="btn btn-warning m-2"
            @click="
              showing = true;
              selectapp(r);
            "
          >
            Update
          </button>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- supprimer -->
  <div class="overlay" v-if="drop">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Suppression</h5>
        </div>
        <div class="modal-body">
          <p>Succes</p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            @click="
              drop = false;
              created();
            "
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="overlay" v-if="showing">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        </div>
        <form @submit.prevent="UpadteAppointment" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="subject">Subject</label>
              <input
                type="text"
                class="form-control"
                id="subject"
                aria-describedby="subject"
                v-model="crdv.subject"
              />
            </div>
            <div class="form-group">
              <label for="date">Date</label>
              <input
                type="date"
                name="setTodaysDate"
                v-model="crdv.times"
                class="form-control"
                id="dt"
                placeholder="date"
                @change="getTimeupdate"
              />
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Available</label>

              <select class="form-control" id="exampleFormControlSelect1">
                <option
                  v-for="time in times"
                  :key="time.message"
                  v-bind:value="time"
                >
                  {{ time }}
                </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              @click="showing = false"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
  name: "Dashboard",
  data() {
    return {
      appointmaj: [],
      login_number: null,
      rdv: {},
      crdv: {},
      appointment: {},
      times: {},
      appointments: {},
      subject: null,
      errorMsg: "",
      warMsg: "",
      succesMsg: "",
      showing: false,
      drop: false,
      tshow: true,
    };
  },
  mounted: function () {
    this.created();
    this.getTime();
    var today = new Date().toISOString().split("T")[0];
    document.getElementsByName("setTodaysDate")[0].setAttribute("min", today);
  },

  methods: {
    moment: function (date) {
      return moment(date).format("YYYY-MM-DD");
    },
    thr(date) {
      return moment(date).format("HH:mm");
    },
    Logout() {
      localStorage.clear();
      window.location.href = "/Login";
      // location.reload();
    },
    async created() {
      this.login_number = localStorage.getItem("login_number");
      const response = await axios.post(
        "http://localhost/ol/src/Api/ReadRdv.php",
        {
          login_number: this.login_number,
        }
      );
      this.rdv = response.data;
      // console.log(this.rdv);
      if (response.data.message) {
        this.warMsg = response.data.message;
        this.tshow = false;
      }
    },
    async storeAppointment() {
      this.login_number = localStorage.getItem("login_number");
      const response = await axios.post(
        "http://localhost/ol/src/Api/appointments.php",
        {
          login_number: this.login_number,
          subject: this.subject,
          times: this.appointment.date + " " + this.appointment.hour,
        }
      );
      this.succesMsg = response.data.message;
      this.created();
      this.getTime();
    },
    async getTime() {
      const response = await axios.post(
        "http://localhost/ol/src/Api/getime.php",
        {
          times: this.appointment.date,
        }
      );
      this.times = response.data;
    },
    async getTimeupdate() {
      const response = await axios.post(
        "http://localhost/ol/src/Api/getime.php",
        {
          times: this.crdv.times,
        }
      );
      this.times = response.data;
    },
    del(d) {
      this.drop = true;
      const response = axios.post("http://localhost/ol/src/Api/del.php", {
        id_del: d,
      });
      this.id_del = response.data;
      // this.succesMsg = response.data.message;
    },
    async selectapp(rdva) {
      this.crdv = rdva;
      // console.log(this.crdv);
    },
    async UpadteAppointment() {
      console.log(this.times);
      // const response = await axios.post(
      //   "http://localhost/ol/src/Api/updateappointments.php",
      //   {
      //     crdv: "this.crdv",
      //   }
      // );
      // this.succesMsg = response.data.message;
      // this.created();
    },
  },
};
</script>

<style scoped>
.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.6);
}
</style>
>
