<template>
    <Toast />
    <MainLayout>
        <div class="flex gap-6 w-full justify-center" >
            <form @submit.prevent="submit" class="flex flex-col" style="width: 30%;">
                <div class="flex flex-col">
                    <div class="flex-auto">
                        <label for="firstNb" class="block font-semibold mb-2">Enter the first number</label>
                        <InputNumber v-model="form.firstNb" id="firstNb" class="w-full" />
                    </div>
                    <div class="flex-auto mb-2">
                        <label for="secondNb" class="block font-semibold mb-2">Enter the second number</label>
                        <InputNumber v-model="form.secondNb" id="secondNb" class="w-full" />
                    </div>
                    <div class="flex-auto mb-2">
                        <label for="secondNb" class="block font-semibold mb-2">Select an operation</label>
                        <Select :options="operations" v-model="form.operation" placeholder="Select Operation" class="w-full sm:w-44" />
                    </div>
                </div>
                <Button type="submit" :disabled="form.processing || form.secondNb == undefined || form.firstNb == undefined" label="Calculate" icon="pi pi-search" :loading="loading" @click="load" />
            </form>
            <div class="card" v-if="calculations && calculations.length">
                <DataTable :value="calculations" tableStyle="min-width: 50rem">
                    <Column field="num1" header="First number"></Column>
                    <Column field="operation" header="Operation"></Column>
                    <Column field="num2" header="Second number"></Column>
                    <Column field="result" header="Result"></Column>
                </DataTable>
            </div>
        </div>
    </MainLayout>
    
</template>

<script setup lang="ts">
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import Button from 'primevue/button';
import MainLayout from '@/layouts/MainLayout.vue';
import { useForm, usePage, router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import { ref, watch } from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const toast = useToast();


defineProps({
    operations: Array,
    calculations: Array,
    result: Number
});


const params = usePage<{ operations: string[] }>();
const operations = ref<string[]>(params.props.operations);
let calculations = ref<any[]>(params.props.calculations);

const form = useForm({
  firstNb: 0,
  secondNb: 0,
  operation: operations.value[0],
});

watch(() => params.props.calculations, () => {
    calculations = params.props.calculations;
}, { deep: true });

const submit = () => {
  form.post("/calculator", {
    onSuccess: () => {
        form.reset();
        toast.add({
            severity: 'success',
            summary: 'Success',
            detail: `The operation was successfully completed`,
            life: 3000 
        });
    },
    onError: ({error}) => {
        toast.add({ severity: 'error', summary: 'Error', detail: error, life: 3000 });
    },
  })
}
</script>