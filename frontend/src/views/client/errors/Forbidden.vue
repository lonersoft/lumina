<script setup lang="ts">
import { ShieldAlertIcon } from 'lucide-vue-next';
import ErrorPage from '@/components/client/Errors/ErrorPage.vue';
import Translation from '@/lumina/Translation';
import { LuminaDOM } from '@/lumina/LuminaDOM';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
LuminaDOM.setPageTitle(t('errors.forbidden.title'));
</script>

<template>
    <ErrorPage
        :icon="ShieldAlertIcon"
        :title="Translation.getTranslation('errors.forbidden.title')"
        :message="Translation.getTranslation('errors.forbidden.message')"
    />
</template>
