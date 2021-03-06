<div id="app2" data-script="../../controlador/js/catalogos/catalogo_sesion.js">
  <v-app>
    <v-container fluid>

      <v-row>
        <v-col md="10">
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field :counter="10" label="Name" required></v-text-field>

            <v-text-field label="E-mail" required></v-text-field>

            <v-select :rules="[v => !!v || 'Item is required']" label="Item" required></v-select>

            <v-checkbox :rules="[v => !!v || 'You must agree to continue!']" label="Do you agree?" required></v-checkbox>

            <v-btn :disabled="!valid" color="success" class="mr-4">
              Validate
            </v-btn>

            <v-btn color="error" class="mr-4">
              Reset Form
            </v-btn>

            <v-btn color="warning">
              Reset Validation
            </v-btn>
          </v-form>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</div>