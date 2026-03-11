<template>
  <Head title="Validación" />

  <AuthenticatedLayout>
    <template #header>
      CONTRASEÑA
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs space-y-4">
      
      <div class="max-w-md">
        <form @submit.prevent="submit" class="space-y-3">
          <label class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
          <input
            v-model="password"
            type="password"
            class="w-full border rounded px-3 py-2"
            placeholder="Ingrese su contraseña"
            :disabled="loading"
          />
          <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>

          <div class="flex items-center gap-2">
            <button type="button" @click="clear" class="px-3 py-2 border rounded" :disabled="loading">Limpiar</button>
            <button type="submit" class="bg-sky-700 text-white px-3 py-2 rounded" :disabled="loading">
              <span v-if="!loading">Enviar</span>
              <span v-else>Procesando...</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const password = ref('');
const error = ref(null);
const loading = ref(false);

function clear() {
  password.value = '';
  error.value = null;
}

async function submit() {
  if (loading.value) return;
  error.value = null;
  loading.value = true;

  try {
    // Usamos axios global configurado en resources/js/bootstrap.js
    await window.axios.post('/consolidado/verify', { password: password.value });
    // Si todo OK, redirigimos al consolidado
    localStorage.setItem('validacion', JSON.stringify(true));
    window.location.href = '/consolidado';
  } catch (e) {
    if (e.response && e.response.status === 422 && e.response.data && e.response.data.password) {
      error.value = e.response.data.password;
    } else {
      error.value = 'Ocurrió un error. Intente nuevamente.';
    }
  } finally {
    loading.value = false;
  }
}
</script>
