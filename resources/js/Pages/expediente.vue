<template>

  <Head title="Expediente" />

  <AuthenticatedLayout>
    <template #header>
      <Link :href="route('pacientes.index')">
        <DarkButton class="mr-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd"
              d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z"
              clip-rule="evenodd" />
          </svg>
        </DarkButton>
      </Link>
      EXPEDIENTE: {{ capitalizarPalabras(paciente.nombres) }} {{ capitalizarPalabras(paciente.apellidos) }} - {{
        paciente.cedula }} ({{ calcularEdad(paciente.fecha_nacimiento) }} años)
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="overflow-hidden w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <div
            class="flex justify-between items-center p-3 text-white font-black bg-white border-b dark:bg-sky-700 dark:border-sky-700">
            <div>Creación de Expediente: {{ formatearFecha(expediente.created_at) }}</div>
            <div>Última actualización: {{ formatearFecha(expediente.updated_at) }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-xl font-black text-center mb-4">Historial de Consultas <DarkButton class="ml-4"
        @click="openModalForm(1)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
          <path fill-rule="evenodd"
            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
            clip-rule="evenodd" />
        </svg>
      </DarkButton>
    </div>
    <div class="px-12 bg-white rounded-lg shadow-xs">
      <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-white uppercase bg-sky-700 border-b">
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3">Motivo</th>
                <!--<th class="px-4 py-3">Monto Bs</th>
                <th class="px-4 py-3">Monto USD</th>-->
                <th class="px-4 py-3 flex justify-center">Opciones</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="consulta in consultas.data" :key="consulta.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                  {{ formatearFecha(consulta.created_at) }}
                </td>
                <td class="px-4 py-3 text-sm font-semibold">
                  {{ consulta.motivo }}
                </td>
                <!--<td class="px-4 py-3 text-sm">
                  {{ consulta.monto_bs > 0 ? consulta.monto_bs + ' REF' : 'N/A' }}
                </td>
                <td class="px-4 py-3 text-sm ">
                  {{ consulta.monto_usd > 0 ? consulta.monto_usd + ' USD' : 'N/A' }}
                </td>-->
                <td class="px-4 py-3 text-sm flex justify-center gap-2">
                  <WarningButton @click="openModalForm(2, consulta)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                  </WarningButton>
                  <DangerButton @click="openModalDel(consulta)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                  </DangerButton>
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

      <div class="m-6 mb-6 p-4 border shadow bg-sky-700 rounded-lg shadow-xs grid gap-6 md:grid-cols-2">

        <div class="space-y-3">
          <!---->

          <InputLabel class="font-bold text-white" for="antecedentes" value="Antecedentes" />
          <InputGroupLarge class="font-bold" id="antecedentes" :text="'Antecedentes del Paciente'" v-model="form2.antecedentes"
            :type="'text'" :maxlength="1000">
          </InputGroupLarge>
          <InputError class="mt-1" :message="form2.errors.antecedentes">
          </InputError>

          <InputLabel class="font-bold text-white" for="examen_fisico" value="Examen físico" />
          <InputGroupLarge class="font-bold" id="examen_fisico" :text="'Examen Físico del Paciente'"
            v-model="form2.examen_fisico" :type="'text'" :maxlength="1000">
          </InputGroupLarge>
          <InputError class="mt-1" :message="form2.errors.examen_fisico">
          </InputError>

        </div>

        <div class="space-y-3">
          <!---->

          <InputLabel class="font-bold text-white" for="diagnostico" value="Diagnóstico del Paciente" />
          <InputGroupLarge class="font-bold" id="diagnostico" :text="'Diagnóstico del Paciente'" v-model="form2.diagnostico"
            :type="'text'" :maxlength="1000">
          </InputGroupLarge>
          <InputError class="mt-1" :message="form2.errors.diagnostico">
          </InputError>

          <InputLabel class="font-bold text-white" for="plan" value="Plan del Paciente" />
          <InputGroupLarge class="font-bold" id="plan" :text="'Plan del Paciente'" v-model="form2.plan" :type="'text'"
            :maxlength="1000">
          </InputGroupLarge>
          <InputError class="mt-1" :message="form2.errors.plan">
          </InputError>

        </div>


      </div>
      <div class="m-6 mb-6 p-4 border shadow bg-sky-700 rounded-lg shadow-xs justify-center">
        <InputLabel class="font-bold text-white" for="pendiente" value="PENDIENTE" />
        <InputGroup class="font-bold" id="pendiente" :text="'Pendiente'" v-model="form2.pendiente" :type="'text'" :maxlength="1000">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
          </svg>
        </InputGroup>
        <InputError class="mt-1" :message="form2.errors.pendiente">
        </InputError>
      </div>
      <div class="pb-16 flex justify-center gap-8">
      <Link :href="route('pacientes.index')"><SecondaryButton>Cancelar</SecondaryButton></Link>
      <WarningButton class="ml-4" @click="updateExpediente()">
        Guardar
      </WarningButton>
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
          <div>
            <InputGroup :text="'Motivo de la Consulta'" :maxlength="50" :required="'required'" v-model="form.motivo"
              :type="'text'">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                <path fill-rule="evenodd"
                  d="M11.097 1.515a.75.75 0 0 1 .589.882L10.666 7.5h4.47l1.079-5.397a.75.75 0 1 1 1.47.294L16.665 7.5h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.2 6h3.585a.75.75 0 0 1 0 1.5h-3.885l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103h-4.47l-1.08 5.397a.75.75 0 1 1-1.47-.294l1.02-5.103H3.75a.75.75 0 0 1 0-1.5h3.885l1.2-6H5.25a.75.75 0 0 1 0-1.5h3.885l1.08-5.397a.75.75 0 0 1 .882-.588ZM10.365 9l-1.2 6h4.47l1.2-6h-4.47Z"
                  clip-rule="evenodd" />
              </svg>
            </InputGroup>
            <InputError class="mt-1" :message="form.errors.motivo">
            </InputError>
          </div>
          <div class="text-center font-semibold"> Distribución de pagos (Opcional)</div>
          <div class="grid gap-3 mb-8 md:grid-cols-2 xl:grid-cols-2">
            <div>
              <InputGroup :text="'Mónto Bs (Referencial)'" :maxlength="6" :required="'required'" v-model="form.monto_bs"
                :type="'number'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.monto_bs">
              </InputError>
            </div>
            <div>
              <InputGroup :text="'Monto USD'" :maxlength="6" :required="'required'" v-model="form.monto_usd"
                :type="'number'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
              </InputGroup>
              <InputError class="mt-1" :message="form.errors.monto_usd">
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
        <p class="text-2xl text-gray-600"> ¿Estás seguro de eliminar esta consulta?
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
import InputLabel from '@/Components/InputLabel.vue';
import InputGroupLarge from '@/Components/InputGroupLarge.vue';

const props = defineProps({
  paciente: Object,
  expediente: Object,
  consultas: Object,
})

const paciente = props.paciente[0];
const expediente = props.expediente[0];


const form = useForm({
  paciente_id: '',
  motivo: '',
  monto_bs: '',
  monto_usd: '',
});

const form2 = useForm({
  paciente_id: paciente.id,
  antecedentes: expediente.antecedentes,
  examen_fisico: expediente.examen_fisico,
  diagnostico: expediente.diagnostico,
  plan: expediente.plan,
  pendiente: expediente.pendiente,
});

const v = ref({ id: '' });

const showModalForm = ref(false);
const showModalDel = ref(false);

const title = ref('');

const operation = ref(0);

const openModalForm = (op, consulta) => {
  showModalForm.value = true;
  operation.value = op;
  if (op === 1) {
    title.value = 'Registrar Consulta';
    console.log(title.value);
    form.paciente_id = paciente.id;
  }
  else {
    title.value = 'Editar Consulta';
    console.log(title.value);
    form.paciente_id = paciente.id;
    form.monto_bs = consulta.monto_bs;
    form.monto_usd = consulta.monto_usd;
    form.motivo = consulta.motivo;
    v.value.id = consulta.id;
  }
}

const closeModalForm = () => {
  showModalForm.value = false;
  form.reset();
}

const save = () => {
  if (operation.value === 1) {
    form.post(route('consultas.store'),
      {
        onSuccess: () => {
          form.reset();
          closeModalForm();
        }
      }
    );

  }
  else {
    form.patch(route('consultas.update', v.value.id),
      {
        onSuccess: () => {
          form.reset();
          closeModalForm();
        }
      });
    form.reset();
    closeModalForm();
  }
}


const openModalDel = (consulta) => {
  showModalDel.value = true;
  v.value.id = consulta.id;
}

const closeModalDel = () => {
  showModalDel.value = false;
}



const deleteCargo = () => {
  form.delete(route('consultas.destroy', v.value.id),
    {
      onSuccess: () => {
        form.reset();
        closeModalDel();
      }
    });
}

const updateExpediente = () => {
  form2.patch(route('expedientes.update', expediente.id),
    {
      onSuccess: () => {
        form2.reset();
      }
    });
}



function capitalizarPalabras(str) {
  return str
    .toLowerCase()
    .split(' ')
    .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
    .join(' ');
}

function calcularEdad(fechaNacimiento) {
  const hoy = new Date();
  const nacimiento = new Date(fechaNacimiento);

  let edad = hoy.getFullYear() - nacimiento.getFullYear();
  const mes = hoy.getMonth() - nacimiento.getMonth();

  if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
    edad--;
  }

  return edad;
}

function formatearFecha(fechaISO) {
  const fecha = new Date(fechaISO);
  const dia = String(fecha.getDate()).padStart(2, '0');
  const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // +1 porque los meses empiezan en 0
  const año = fecha.getFullYear();

  return `${dia}-${mes}-${año}`;
}

</script>
