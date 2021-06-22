<template>
  <div class="row">
    <div class="col-sm5 m-auto">
      <div class="text-center mb-4">
        <h1>Authentification</h1>
      </div>
      <form action="" @submit.prevent="hansleSubmit">
        <div class="row">
          <div class="col-sm-12 form-group">
            <label for="login_number">login_number :</label>
            <input
              type="text"
              name="login_number"
              id="login_number"
              class="form-control form-control-lg"
              v-model="login_number"
            />
          </div>

          <div class="pt-4 col-sm-12 form-group">
            <button class="btn btn-primary btn-lg col-sm-4 mx-1">
              S'authentifier
            </button>
          </div>
          <div class="pt-4 col-sm-12 form-group mt-5">
            <p>
              Créer un compte ? <router-link to="/Signup">Signup</router-link>
            </p>
            <a class="center"> login_number Oublie ?</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Login",
  data() {
    return {
      login_number: "",
    };
  },
  methods: {
    async hansleSubmit() {
      const response = await axios.post(
        "http://localhost/ol/src/Api/SignIn.php",
        {
          login_number: this.login_number,
        }
      );
      localStorage.setItem("login_number", response.data.login_number);
      if (response.data.login_number) {
        this.$router.push("/Dashboard");
      } else {
        alert("login_number incorrect !!");
      }
    },
  },
};
</script>

<style></style>
