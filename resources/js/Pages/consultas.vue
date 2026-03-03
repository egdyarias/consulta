<template>

  <Head title="Consultas del día" />

  <AuthenticatedLayout>
    <template #header>
      <div class="text-center mb-4">
        Consultas del día
      </div>
      <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-sky-700">
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
              {{ sumaMontoBs > 0 ? sumaMontoBs + ' REF' : ''}}
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-sky-700">
          <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-white">
              Acumulado en USD
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              {{ sumaMontoUSD > 0 ? sumaMontoUSD + ' USD' : ''}}
            </p>
          </div>
        </div>
      </div>
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">

      <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-white uppercase bg-sky-700 border-b">
                <th class="px-4 py-3">Paciente</th>
                <th class="px-4 py-3">Motivo de Consulta</th>
                <th class="px-4 py-3">Pago en BS</th>
                <th class="px-4 py-3">Pago en USD</th>
                <th class="px-4 py-3 flex justify-center">Opciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="consulta in consultas.data" :key="consulta.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm  font-semibold">
                  {{ consulta.paciente.nombres }} {{ consulta.paciente.apellidos }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ consulta.motivo }}
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ consulta.monto_bs > 0 ? consulta.monto_bs + ' REF' : '' }}
                </td>
                <td class="px-4 py-3 text-sm ">
                  {{ consulta.monto_usd > 0 ? consulta.monto_usd + ' USD' : ''}}
                </td>
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
import { Head } from '@inertiajs/vue3';

import Pagination from '@/Components/Pagination.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  consultas: Object,
  sumaMontoBs: Object,
  sumaMontoUSD: Object,
})
</script>
