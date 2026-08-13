<script setup lang="ts">
import { FileQuestionIcon } from 'lucide-vue-next';
import ErrorPage from '@/components/client/Errors/ErrorPage.vue';
import Translation from '@/lumina/Translation';
import { LuminaDOM } from '@/lumina/LuminaDOM';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
LuminaDOM.setPageTitle(t('errors.servererror.title'));
</script>
<template>
    <ErrorPage
        :icon="FileQuestionIcon"
        :title="Translation.getTranslation('errors.servererror.title')"
        :message="Translation.getTranslation('errors.servererror.message')"
    />
</template>
