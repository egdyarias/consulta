<template>

  <Head title="Movimientos del día" />

  <AuthenticatedLayout>
    <template #header>
      <div class="text-center mb-4">
        Movimientos del día: {{ fecha }}
        <DarkButton @click="buscarFecha()" class="ml-4">Buscar</DarkButton>
      </div>

      <div class="flex justify-center mb-8">
        <div class="max-w-[30vh]">
          <InputLabel class="text-center font-bold" for="fecha" value="Ingresar Fecha" />
          <InputGroup class="font-bold" id="fecha" :text="'Pendiente'" v-model="form.fecha" :type="'date'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
            </svg>
          </InputGroup>
          <InputError class="mt-1" :message="form.errors.fecha">
          </InputError>
        </div>
      </div>

      <div class="flex justify-center items-center gap-8 mb-2">
        <div>
          <DarkButton @click="movimiento(1)" class="ml-4">-</DarkButton>
        </div>
        <div class="flex justify-center items-center p-4 bg-white rounded-lg shadow-xs dark:bg-sky-700">
          <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
            </svg>

          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-white">
              Acumulado en BS
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              {{ props.consolidado + ' REF' }}
            </p>
          </div>
        </div>
        <div>
          <DarkButton @click="movimiento(2)" class="ml-4">+</DarkButton>
        </div>
      </div>
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">

      <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-white uppercase bg-sky-700 border-b">
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Movimiento</th>
                <th class="px-4 py-3">Concepto</th>
                <th class="px-4 py-3">Monto</th>
                <th class="px-4 py-3 flex justify-center">Opciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="movimiento, i in props.movimientos" :key="movimiento.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ i + 1 }}
                </td>
                <td class="px-4 py-3 text-sm font-semibold">
                  {{ movimiento.tipo_movimiento }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ movimiento.concepto }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ movimiento.monto + ' REF' }}
                </td>
                <td class="px-4 py-3 text-sm flex justify-center gap-2">
                  <DangerButton v-if="movimiento.concepto !== 'Suma de Consultas del Día'" @click="openModalDel(movimiento)">
                    <svg 
                      xmlns="http://www.w3.org/2000/svg" 
                      fill="none" 
                      viewBox="0 0 24 24" 
                      stroke-width="1.5" 
                      stroke="currentColor" 
                      class="size-6">
                        <path 
                          stroke-linecap="round" 
                          stroke-linejoin="round" 
                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" 
                        />
                    </svg>
                  </DangerButton>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <Modal :show="showModalForm" @close="closeModalForm">
      <div class="" p-6>
        <h2 class="m-6 flex justify-center text-lg font-medium text-gray-900">{{ title }}</h2>
        <div class="m-6 flex justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
        </div>

        <div class="ml-12 m-6 mb-6 space-y-6 max-w-xl">
          <div class="grid gap-3 mb-8 md:grid-cols-2 xl:grid-cols-2">
            <div>
              <InputGroup :text="'Concepto'" :maxlength="30" :required="'required'" v-model="form2.concepto"
                :type="'text'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>

              </InputGroup>
              <InputError class="mt-1" :message="form2.errors.concepto">
              </InputError>
            </div>
            <div>
              <InputGroup :text="'Monto'" :maxlength="30" :required="'required'" v-model="form2.monto" :type="'number'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-4">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

              </InputGroup>
              <InputError class="mt-1" :message="form2.errors.monto">
              </InputError>
            </div>
          </div>
          <div class="flex justify-center">
            <PrimaryButton @click="save">
              Guardar
            </PrimaryButton>
          </div>
        </div>
      </div>
      <div class="m-6 flex justify-center">
        <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
      </div>
    </Modal>

    <Modal :show="showModalDel" @close="closeModalDel">
      <div class="flex justify-center p-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
        </svg>
      </div>
      <div class="text-center flex justify-center p-6">
        <p class="text-2xl text-gray-600"> ¿Estás seguro de eliminar este movimiento?
        </p>
        <br>
      </div>
      <div class="m-6 flex justify-center">
        <PrimaryButton @click="deleteMovimiento">
          Si, Eliminar.
        </PrimaryButton>
      </div>
      <div class="m-6 flex justify-center">
        <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import Pagination from '@/Components/Pagination.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
  movimientos: Object,
  fecha: String,
  consolidado: Number,
})

const v = ref({ id: '', nombres: '' });

const showModalForm = ref(false);
const showModalDel = ref(false);

const title = ref('');

const operation = ref(0);


const form = useForm({
  fecha: '',
})

const form2 = useForm({
  tipo_movimiento: '',
  moneda: 'BS',
  concepto: '',
  monto: ''
})

const buscarFecha = () => {
  if (form.fecha === '') {
    form.errors.fecha = ('Por favor, ingrese una fecha válida.');
    return;
  }
  form.get(route('movimientoBSdate.index', form.fecha), {
    preserveState: true,
    onSuccess: () => {
    },
  });
}

const movimiento = (op) => {
  showModalForm.value = true;
  operation.value = op;
  if (op === 1) {
    title.value = 'Movimiento: Retiro';
    form2.tipo_movimiento = 'Retiro';
    console.log(title.value);
  }
  else {
    title.value = 'Movimiento: Depósito';
    console.log(title.value);
    form2.tipo_movimiento = 'Deposito';
  }
}

const closeModalForm = () => {
  showModalForm.value = false;
  form2.reset();
  form2.clearErrors();
}

const openModalDel = (movimiento) => {
  showModalDel.value = true;
  v.value.id = movimiento.id;
}

const closeModalDel = () => {
  showModalDel.value = false;
}

const save = () => 
{
  {
    form2.post(route('movimiento.store'),
    {
      onSuccess: () =>{
        closeModalForm();
      }
    }
    );
    
  }
}


const deleteMovimiento = () => 
{
  form2.delete(route('movimiento.destroy', v.value.id), 
  {
    onSuccess: () => 
    {
      closeModalDel();
    }
  });
}

</script>
