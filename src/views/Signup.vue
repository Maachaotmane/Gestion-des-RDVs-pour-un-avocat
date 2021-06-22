<template>
  <div class="row">
    <div class="col-sm5 m-auto">
      <div class="text-center mb-4">
        <h1>Creation du compte Client</h1>
      </div>
      <form action="" id="login-form" @submit.prevent="handleSubmit">
        <div class="row">
          <div class="col-sm-12 form-group">
            <label for="name">name :</label>
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Votre name"
              v-model="name"
            />
          </div>
          <div class="col-sm-12 form-group">
            <label for="Prenom">Prenom :</label>
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Votre prenom"
              v-model="prenom"
            />
          </div>
          <div class="col-sm-12 form-group">
            <label for="job">job :</label>
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Votre job"
              v-model="job"
            />
          </div>
          <div class="col-sm-12 form-group">
            <label for="email">email :</label>
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Votre emaile"
              v-model="email"
            />
          </div>
          <div class="pt-4 col-sm-12 form-group">
            <button class="btn btn-primary btn-lg col-sm-4 mx-1">
              S'enregistrer
            </button>
          </div>
          <div class="pt-4 col-sm-12 form-group mt-5">
            <p>
              Vous-avez deja un compte ?
              <router-link to="/Login">Login</router-link>
            </p>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Signup",
  data() {
    return {
      name: "",
      prenom: "",
      job: "",
      email: "",
    };
  },
  methods: {
    async handleSubmit() {
      const response = await axios.post(
        "http://localhost/ol/src/Api/Signup.php",
        {
          name: this.name,
          prenom: this.prenom,
          job: this.job,
          email: this.email,
        }
      );
      console.log(response);
      if (response.data.login_number) {
        localStorage.setItem("login_number", response.data.login_number);
        this.$router.push("/Dashboard");
      } else {
        alert(response.data.message);
      }
    },
  },
};
</script>

<style></style>
