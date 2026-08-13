<template>
    <LayoutDashboard>
        <Announcements />
    </LayoutDashboard>
</template>

<script lang="ts" setup>
import LayoutDashboard from '@/components/client/LayoutDashboard.vue';
import Announcements from '@/components/client/Dashboard/Main/Announcements.vue';
import { LuminaDOM } from '@/lumina/LuminaDOM';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
LuminaDOM.setPageTitle(t('components.sidebar.announcements'));
</script>
