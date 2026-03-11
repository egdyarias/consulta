<template>

  <Head title="Pacientes" />

  <AuthenticatedLayout>
    <template #header>
      Pacientes
      <DarkButton class="ml-4" @click="openModalForm(1)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path fill-rule="evenodd"
            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
            clip-rule="evenodd" />
        </svg>
      </DarkButton>
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">

      <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
          <div class="p-4">
            <form @submit.prevent="submitSearch" class="flex gap-2 items-center">
              <input v-model="searchForm.search" type="text" placeholder="Buscar por cédula, nombre o apellido"
                class="w-full border rounded px-3 py-2" />
              <button type="submit" class="bg-sky-700 text-white px-3 py-2 rounded">Buscar</button>
              <button type="button" @click="clearSearch" class="px-3 py-2 border rounded">Limpiar</button>
            </form>
          </div>
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-white uppercase bg-sky-700 border-b">
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Cédula</th>
                <th class="px-4 py-3">Nombres</th>
                <th class="px-4 py-3">Apellidos</th>
                <th class="px-4 py-3 flex justify-center">Opciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="paciente, i in pacientes.data" :key="paciente.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ i + 1 }}
                </td>
                <td class="px-4 py-3 text-sm font-semibold">
                  {{ paciente.cedula }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ paciente.nombres }}
                </td>
                <td class="px-4 py-3 text-sm ">
                  {{ paciente.apellidos }}
                </td>
                <td class="px-4 py-3 text-sm flex justify-center gap-2">
                  <Link :href="route('expedientes.edit', paciente.id)">
                    <DarkButton class="ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                      <path fill-rule="evenodd"
                        d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                        clip-rule="evenodd" />
                      <path fill-rule="evenodd"
                        d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                        clip-rule="evenodd" />
                    </svg>
                  </DarkButton>
                  </Link>
                  
                  <WarningButton @click="openModalForm(2,paciente)">
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
                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" 
                        />
                    </svg>
                  </WarningButton>
                  <DangerButton @click="openModalDel(paciente)">
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
        <div
          class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
          <pagination :links="pacientes.links" />
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
              d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>
        </div>

        <div class="ml-12 m-6 mb-6 space-y-6 max-w-xl">
          <div class="grid gap-3 mb-8 md:grid-cols-2 xl:grid-cols-2">
            <div>
              <InputGroup :text="'Nombres del Paciente'" :maxlength="30" :required="'required'" v-model="form.nombres" :type="'text'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                  <path fill-rule="evenodd"
                    d="M11.097 1.515a.75.75 0 0 1 .589.882L10.666 7.5h4.47l1.079-5.397a.75.75 0 1 1 1.47.294L16.665 7.5h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.2 6h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103h-4.47l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103H3.75a.75.75 0 0 1 0-1.5h3.885l1.2-6H5.25a.75.75 0 0 1 0-1.5h3.885l1.08-5.397a.75.75 0 0 1 .882-.588ZM10.365 9l-1.2 6h4.47l1.2-6h-4.47Z"
                    clip-rule="evenodd" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.nombres">
              </InputError>
            </div>
            <div>
              <InputGroup :text="'Apellidos del Paciente'" :maxlength="30" :required="'required'" v-model="form.apellidos"
                :type="'text'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                  <path fill-rule="evenodd"
                    d="M11.097 1.515a.75.75 0 0 1 .589.882L10.666 7.5h4.47l1.079-5.397a.75.75 0 1 1 1.47.294L16.665 7.5h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.2 6h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103h-4.47l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103H3.75a.75.75 0 0 1 0-1.5h3.885l1.2-6H5.25a.75.75 0 0 1 0-1.5h3.885l1.08-5.397a.75.75 0 0 1 .882-.588ZM10.365 9l-1.2 6h4.47l1.2-6h-4.47Z"
                    clip-rule="evenodd" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.apellidos">
              </InputError>
            </div>
            <div>
              <InputGroup :text="'Cédula del Paciente'" :maxlength="10" :required="'required'" v-model="form.cedula" :type="'text'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.cedula">
              </InputError>
            </div>
            <div>
              <InputGroup :text="'Fecha de Nacimiento'" :required="'required'" v-model="form.fecha_nacimiento"
                :type="'date'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.fecha_nacimiento">
              </InputError>
            </div>
          </div>
          <div>
            <InputGroup :text="'Dirección del Paciente (Opcional)'" :maxlength="100" :required="'required'" v-model="form.direccion"
              :type="'text'">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
              </svg>
            </InputGroup>
            <InputError class="mt-1" :message="form.errors.direccion">
            </InputError>
          </div>

          <div class="grid gap-3 mb-8 md:grid-cols-2 xl:grid-cols-2">
            <div>
              <InputGroup :text="'Teléfono del Paciente (Opcional)'" :maxlength="15" :required="'required'" v-model="form.telefono" :type="'text'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.telefono">
              </InputError>
            </div>
            <div>
              <InputGroup :text="'Referido por: (Opcional)'" :maxlength="30" :required="'required'" v-model="form.referido" :type="'text'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                  <path fill-rule="evenodd"
                    d="M11.097 1.515a.75.75 0 0 1 .589.882L10.666 7.5h4.47l1.079-5.397a.75.75 0 1 1 1.47.294L16.665 7.5h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.2 6h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103h-4.47l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103H3.75a.75.75 0 0 1 0-1.5h3.885l1.2-6H5.25a.75.75 0 0 1 0-1.5h3.885l1.08-5.397a.75.75 0 0 1 .882-.588ZM10.365 9l-1.2 6h4.47l1.2-6h-4.47Z"
                    clip-rule="evenodd" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.referido">
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
        <p class="text-2xl text-gray-600"> ¿Estás seguro de eliminar a {{ v.nombres }}?
        </p>
        <br>
      </div>
      <div class="m-6 flex justify-center">
        <PrimaryButton @click="deleteCargo">
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
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DarkButton from '@/Components/DarkButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
  pacientes: Object,
  search: {
    type: String,
    default: ''
  }
})

const form = useForm({
  nombres: '',
  apellidos: '',
  cedula: '',
  fecha_nacimiento: '',
  direccion: '',
  telefono: '',
  referido: ''
});

// Search form for filtering pacientes
const searchForm = useForm({ search: props.search || '' });

const submitSearch = () => {
  // perform GET via Inertia to preserve SPA behavior
  searchForm.get(route('pacientes.index'), { preserveState: true, replace: true });
}

const clearSearch = () => {
  searchForm.search = '';
  submitSearch();
}

const v = ref({ id: '', nombres: ''});

const showModalForm = ref(false);
const showModalDel = ref(false);

const title = ref('');

const operation = ref(0);

const openModalForm = (op, paciente) => {
  showModalForm.value = true;
  operation.value = op;
  if (op === 1) {
    title.value = 'Registrar Paciente';
    console.log(title.value);
  }
  else {
    title.value = 'Editar Paciente';
    console.log(title.value);
    form.nombres = paciente.nombres;
    form.apellidos = paciente.apellidos;
    form.cedula = paciente.cedula;
    form.fecha_nacimiento = paciente.fecha_nacimiento;
    form.direccion = paciente.direccion;
    form.telefono = paciente.telefono;
    form.referido = paciente.referido;
    v.value.id = paciente.id;
  }
}

const closeModalForm = () => {
  showModalForm.value = false;
  form.reset();
}

const save = () => 
{
  if(operation.value === 1)
  {
    form.post(route('pacientes.store'),
    {
      onSuccess: () =>{
        form.reset();
        closeModalForm();
      }
    }
    );
    
  }
  else 
  {
    form.patch(route('pacientes.update',v.value.id),
    {
      onSuccess: () =>{
        form.reset();
        closeModalForm();
      }
    });
    form.reset();
    closeModalForm();
  }
}


const openModalDel = (paciente) =>
{
  showModalDel.value = true;
  v.value.id = paciente.id;
  v.value.nombres = paciente.nombres + ' ' + paciente.apellidos;
}

const closeModalDel = () =>{
  showModalDel.value = false;
}



const deleteCargo = () => 
{
  form.delete(route('pacientes.destroy', v.value.id), 
  {
    onSuccess: () => 
    {
      form.reset();
      closeModalDel();
    }
  });
}

localStorage.setItem('validacion', JSON.stringify(false));

</script>
