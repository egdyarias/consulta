<template>

  <Head title="Consultas del día" />

  <AuthenticatedLayout>
    <template #header>
      <div class="text-center mb-2">
        Consultas del día: {{ fecha }}
        <DarkButton @click="buscarFecha()" class="ml-4">Buscar</DarkButton>
      </div>
    </template>

    <div class="flex justify-center mb-2">
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
    

    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-white uppercase bg-sky-700 border-b">
                <th class="px-4 py-3">Cédula</th>
                <th class="px-4 py-3">Paciente</th>
                <th class="px-4 py-3">Motivo de Consulta</th>
                <!--<th class="px-4 py-3">Pago en BS</th>
                <th class="px-4 py-3">Pago en USD</th>-->
                <th class="px-4 py-3 flex justify-center">Opciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="consulta in consultas.data" :key="consulta.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ consulta.paciente.cedula }}
                </td>
                <td class="px-4 py-3 text-sm  font-semibold">
                  {{ consulta.paciente.nombres }} {{ consulta.paciente.apellidos }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ consulta.motivo }}
                </td>
                <!--<td class="px-4 py-3 text-sm">
                  {{ consulta.monto_bs > 0 ? consulta.monto_bs + ' REF' : '' }}
                </td>
                <td class="px-4 py-3 text-sm ">
                  {{ consulta.monto_usd > 0 ? consulta.monto_usd + ' USD' : ''}}
                </td>-->
                <td class="px-4 py-3 text-sm flex justify-center gap-2">
                  <Link :href="route('expedientes.edit', consulta.paciente_id)" method="get" as="button">
                  <WarningButton>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                  </WarningButton>
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div
          class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
          <pagination :links="consultas.links" />
        </div>
      </div>
    </div>
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

const props = defineProps({
  consultas: Object,
  sumaMontoBs: Object,
  sumaMontoUSD: Object,
  fecha: String,
})

const form = useForm ({
  fecha: '',
})

const buscarFecha = () => {
  if(form.fecha === ''){
    form.errors.fecha = ('Por favor, ingrese una fecha válida.');
    return;
  }
  form.get(route('consultas.fecha2', form.fecha), {
    preserveState: true,
    onSuccess: () => {
    },
  });
}

localStorage.setItem('validacion', JSON.stringify(false));
</script>
